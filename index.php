<?php

require 'inc/configuration.php';
require 'inc/carrinho_functions.php';
require 'inc/auth_functions.php';
require 'inc/Slim-2.x/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

// GET route
$app->get(
    '/index',
    function () {

        require_once("view/index.php");
        
    }
);

$app->get(
    '/videos',
    function () {
        
        require_once("view/videos.php");
        
    }
);

$app->get(
    '/shop',
    function () {
        
        require_once("view/shop.php");
        
    }
);

$app->get('/produtos', function(){

    $sql = new Sql();

    $data = $sql->select("SELECT * FROM tb_produtos where preco_promorcional > 0 order by preco_promorcional desc limit 3;");

    foreach ($data as &$produto) {
        $preco = $produto['preco'];
        $centavos = explode(".", $preco);
        $produto['preco'] = number_format($preco, 0, ",", ".");
        $produto['centavos'] = end($centavos);
        $produto['parcelas'] = 10;
        $produto['parcela'] = number_format($preco/$produto['parcelas'], 2, ",", ".");
        $produto['total'] = number_format($preco, 2, ",", ".");
    }

    echo json_encode($data);

});

$app->get('/produtos-mais-buscados', function(){

    $sql = new Sql();

    $data = $sql->select("
        SELECT 
        tb_produtos.id_prod,
        tb_produtos.nome_prod_curto,
        tb_produtos.nome_prod_longo,
        tb_produtos.codigo_interno,
        tb_produtos.id_cat,
        tb_produtos.preco,
        tb_produtos.peso,
        tb_produtos.largura_centimetro,
        tb_produtos.altura_centimetro,
        tb_produtos.quantidade_estoque,
        tb_produtos.preco_promorcional,
        tb_produtos.foto_principal,
        tb_produtos.visivel,
        cast(avg(review) as dec(10,2)) as media, 
        count(id_prod) as total_reviews
        FROM tb_produtos 
        INNER JOIN tb_reviews USING(id_prod) 
        GROUP BY 
        tb_produtos.id_prod,
        tb_produtos.nome_prod_curto,
        tb_produtos.nome_prod_longo,
        tb_produtos.codigo_interno,
        tb_produtos.id_cat,
        tb_produtos.preco,
        tb_produtos.peso,
        tb_produtos.largura_centimetro,
        tb_produtos.altura_centimetro,
        tb_produtos.quantidade_estoque,
        tb_produtos.preco_promorcional,
        tb_produtos.foto_principal,
        tb_produtos.visivel
        LIMIT 4;
    ");

    foreach ($data as &$produto) {
        $preco = $produto['preco'];
        $centavos = explode(".", $preco);
        $produto['preco'] = number_format($preco, 0, ",", ".");
        $produto['centavos'] = end($centavos);
        $produto['parcelas'] = 10;
        $produto['parcela'] = number_format($preco/$produto['parcelas'], 2, ",", ".");
        $produto['total'] = number_format($preco, 2, ",", ".");
    }

    echo json_encode($data);

});

$app->get("/produto-:id_prod", function($id_prod){

    $sql = new Sql();

    $produtos = $sql->select("SELECT * FROM tb_produtos WHERE id_prod = $id_prod");

    $produto = $produtos[0];

    $preco = $produto['preco'];
    $centavos = explode(".", $preco);
    $produto['preco'] = number_format($preco, 0, ",", ".");
    $produto['centavos'] = end($centavos);
    $produto['parcelas'] = 10;
    $produto['parcela'] = number_format($preco/$produto['parcelas'], 2, ",", ".");
    $produto['total'] = number_format($preco, 2, ",", ".");

    require_once("view/shop-produto.php");

});

$app->get(
    '/cart',
    function () {
        
        require_once("view/cart.php");
        
    }
);

$app->get('/carrinho-dados', function(){

    $result = sp_carrinhos_get(session_id());

    $carrinho = $result[0];

    $carrinho['produtos'] = sp_carrinhosprodutos_list($carrinho['id_car']);

    $carrinho['total_car'] = number_format((float)$carrinho['total_car'], 2, ',', '.');
    $carrinho['subtotal_car'] = number_format((float)$carrinho['subtotal_car'], 2, ',', '.');
    $carrinho['frete_car'] = number_format((float)$carrinho['frete_car'], 2, ',', '.');

    echo json_encode($carrinho);

});

$app->get('/carrinhoAdd-:id_prod', function($id_prod){

    $result = sp_carrinhos_get(session_id());

    $carrinho = $result[0];

    sp_carrinhosprodutos_add($carrinho['id_car'], $id_prod);

    header("location: cart");
    exit;

});

$app->delete("/carrinhoRemoveAll-:id_prod", function($id_prod){

    $result = sp_carrinhos_get(session_id());

    $carrinho = $result[0];

    sp_carrinhosprodutostodos_rem($carrinho['id_car'], $id_prod);

    echo json_encode(array(
        "success"=>true
    ));

});

$app->post("/carrinho-produto", function(){

    $data = json_decode(file_get_contents("php://input"), true);

    $result = sp_carrinhos_get(session_id());

    $carrinho = $result[0];

    sp_carrinhosprodutos_add($carrinho['id_car'], $data['id_prod']);

    echo json_encode(array(
        "success"=>true
    ));

});

$app->delete("/carrinho-produto", function(){

    $data = json_decode(file_get_contents("php://input"), true);

    $result = sp_carrinhos_get(session_id());

    $carrinho = $result[0];

    sp_carrinhosprodutos_rem($carrinho['id_car'], $data['id_prod']);

    echo json_encode(array(
        "success"=>true
    ));

});

$app->get("/calcular-frete-:cep", function($cep){

    // Cálculo de frete FICTÍCIO (sem depender de API externa tipo Correios,
    // já que hospedagens gratuitas costumam bloquear conexões de saída).

    $result = sp_carrinhos_get(session_id());

    $carrinho = $result[0];

    $produtos = sp_carrinhosprodutosfrete_list($carrinho['id_car']);

    $pesoTotal = 0;

    foreach ($produtos as $produto) {
        $pesoTotal += (float) $produto['peso'];
    }

    $cep = trim(str_replace('-', '', $cep));

    // Fórmula fictícia: frete base + valor por peso; prazo varia um pouco
    // conforme o primeiro dígito do CEP, só para não ser sempre igual.
    $freteValor = round(15 + ($pesoTotal * 2.5), 2);
    $primeiroDigito = (int) substr($cep, 0, 1);
    $prazoDias = 3 + ($primeiroDigito % 5);

    $sql = new Sql();

    $sql->query("
        UPDATE tb_carrinhos 
        SET 
            cep_car = '".$cep."', 
            frete_car = ".$freteValor.",
            prazo_car = ".$prazoDias."
        WHERE id_car = ".$carrinho['id_car']
    );

    echo json_encode(array(
        'success'=>true
    ));

});

$app->post("/comprar", function(){

    $usuarioLogado = usuario_logado();

    if (!$usuarioLogado) {
        echo json_encode(array(
            'success' => false,
            'loginNecessario' => true,
            'message' => 'Você precisa estar logado para finalizar a compra.'
        ));
        return;
    }

    $result = sp_carrinhos_get(session_id());

    $carrinho = $result[0];

    $pid_car = (int) $carrinho['id_car'];

    // Baixa o estoque de cada produto conforme a quantidade no carrinho
    $produtos = sp_carrinhosprodutos_list($pid_car);

    foreach ($produtos as $produto) {

        $id_prod = (int) $produto['id_prod'];
        $qtd = (int) $produto['qtd_car'];

        $sql = new Sql();
        $sql->query("UPDATE tb_produtos SET quantidade_estoque = GREATEST(quantidade_estoque - $qtd, 0) WHERE id_prod = $id_prod");
    }

    // Grava o pedido no histórico do usuário
    pedido_criar($usuarioLogado['id_usu'], $carrinho, $produtos);

    // Esvazia o carrinho e reseta frete/cep, já que a compra foi "finalizada"
    $sql = new Sql();
    $sql->query("DELETE FROM tb_carrinhosprodutos WHERE id_car = $pid_car");

    $sql = new Sql();
    $sql->query("UPDATE tb_carrinhos SET frete_car = NULL, cep_car = NULL, prazo_car = NULL WHERE id_car = $pid_car");

    echo json_encode(array(
        'success' => true,
        'mensagem' => 'Compra finalizada com sucesso!'
    ));

});

$app->post('/cadastro', function(){

    $data = json_decode(file_get_contents("php://input"), true);

    echo json_encode(usuario_criar($data['nome'], $data['email'], $data['senha']));

});

$app->post('/login', function(){

    $data = json_decode(file_get_contents("php://input"), true);

    echo json_encode(usuario_login($data['email'], $data['senha']));

});

$app->post('/logout', function(){

    usuario_logout();

    echo json_encode(array('success' => true));

});

$app->get('/usuario-logado', function(){

    $usuario = usuario_logado();

    echo json_encode(array(
        'logado' => $usuario !== null,
        'usuario' => $usuario
    ));

});

$app->put('/usuario', function(){

    $usuarioLogado = usuario_logado();

    if (!$usuarioLogado) {
        echo json_encode(array('success' => false, 'message' => 'Você precisa estar logado.'));
        return;
    }

    $data = json_decode(file_get_contents("php://input"), true);
    $senha = !empty($data['senha']) ? $data['senha'] : null;

    echo json_encode(usuario_atualizar($usuarioLogado['id_usu'], $data['nome'], $data['email'], $senha));

});

$app->get('/meus-pedidos', function(){

    $usuarioLogado = usuario_logado();

    if (!$usuarioLogado) {
        echo json_encode(array());
        return;
    }

    echo json_encode(pedidos_listar($usuarioLogado['id_usu']));

});

$app->run();
