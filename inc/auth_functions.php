<?php

/*
    Funções de autenticação (cadastro/login/logout), edição de dados
    e histórico de pedidos. Usa a mesma classe Sql já existente no projeto.
    A sessão de login usa $_SESSION, que já é iniciada em configuration.php.
*/

function usuario_buscar_por_email($email) {

    $email = trim($email);

    $sql = new Sql();
    $rows = $sql->select("SELECT id_usu, nome_usu, email_usu, senha_usu FROM tb_usuarios WHERE email_usu = '$email' LIMIT 1");

    return empty($rows) ? null : $rows[0];
}

function usuario_criar($nome, $email, $senha) {

    $nome = trim($nome);
    $email = trim($email);

    if ($nome === '' || $email === '' || empty($senha)) {
        return array('success' => false, 'message' => 'Preencha todos os campos.');
    }

    if (usuario_buscar_por_email($email)) {
        return array('success' => false, 'message' => 'Este e-mail já está cadastrado.');
    }

    $hash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = new Sql();
    $sql->query("INSERT INTO tb_usuarios (nome_usu, email_usu, senha_usu, data_usu) VALUES ('$nome', '$email', '$hash', NOW())");

    return array('success' => true);
}

function usuario_login($email, $senha) {

    $usuario = usuario_buscar_por_email($email);

    if (!$usuario) {
        return array('success' => false, 'existe' => false, 'message' => 'Não encontramos uma conta com esse e-mail.');
    }

    if (!password_verify($senha, $usuario['senha_usu'])) {
        return array('success' => false, 'existe' => true, 'message' => 'Senha incorreta.');
    }

    $_SESSION['id_usu'] = (int) $usuario['id_usu'];
    $_SESSION['nome_usu'] = $usuario['nome_usu'];
    $_SESSION['email_usu'] = $usuario['email_usu'];

    return array('success' => true, 'nome' => $usuario['nome_usu'], 'email' => $usuario['email_usu']);
}

function usuario_logout() {
    unset($_SESSION['id_usu']);
    unset($_SESSION['nome_usu']);
    unset($_SESSION['email_usu']);
}

function usuario_logado() {

    if (empty($_SESSION['id_usu'])) {
        return null;
    }

    return array(
        'id_usu' => $_SESSION['id_usu'],
        'nome' => $_SESSION['nome_usu'],
        'email' => $_SESSION['email_usu']
    );
}

function usuario_atualizar($id_usu, $nome, $email, $senha = null) {

    $id_usu = (int) $id_usu;
    $nome = trim($nome);
    $email = trim($email);

    $existente = usuario_buscar_por_email($email);
    if ($existente && (int) $existente['id_usu'] !== $id_usu) {
        return array('success' => false, 'message' => 'Este e-mail já está em uso por outra conta.');
    }

    $sql = new Sql();
    $sql->query("UPDATE tb_usuarios SET nome_usu = '$nome', email_usu = '$email' WHERE id_usu = $id_usu");

    if (!empty($senha)) {
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = new Sql();
        $sql->query("UPDATE tb_usuarios SET senha_usu = '$hash' WHERE id_usu = $id_usu");
    }

    $_SESSION['nome_usu'] = $nome;
    $_SESSION['email_usu'] = $email;

    return array('success' => true);
}

function pedido_criar($id_usu, $carrinho, $produtos) {

    $id_usu = (int) $id_usu;
    $subtotal = (float) $carrinho['subtotal_car'];
    $frete = (float) $carrinho['frete_car'];
    $total = (float) $carrinho['total_car'];
    $cep = !empty($carrinho['cep_car']) ? "'".$carrinho['cep_car']."'" : "NULL";

    $sql = new Sql();
    $sql->query("INSERT INTO tb_pedidos (id_usu, data_ped, subtotal_ped, frete_ped, total_ped, cep_ped) VALUES ($id_usu, NOW(), $subtotal, $frete, $total, $cep)");

    $sql = new Sql();
    $idPedidoRows = $sql->select("SELECT id_ped FROM tb_pedidos WHERE id_usu = $id_usu ORDER BY id_ped DESC LIMIT 1");
    $id_ped = (int) $idPedidoRows[0]['id_ped'];

    foreach ($produtos as $produto) {

        $id_prod = (int) $produto['id_prod'];
        $qtd = (int) $produto['qtd_car'];
        $preco = (float) $produto['preco'];

        $sql = new Sql();
        $sql->query("INSERT INTO tb_pedidos_produtos (id_ped, id_prod, qtd, preco_unit) VALUES ($id_ped, $id_prod, $qtd, $preco)");
    }

    return $id_ped;
}

function pedidos_listar($id_usu) {

    $id_usu = (int) $id_usu;

    $sql = new Sql();
    $pedidos = $sql->select("SELECT id_ped, data_ped, subtotal_ped, frete_ped, total_ped, cep_ped FROM tb_pedidos WHERE id_usu = $id_usu ORDER BY id_ped DESC");

    foreach ($pedidos as &$pedido) {

        $sql = new Sql();
        $pedido['produtos'] = $sql->select("
            SELECT b.nome_prod_curto, b.foto_principal, a.qtd, a.preco_unit
            FROM tb_pedidos_produtos a
            INNER JOIN tb_produtos b USING(id_prod)
            WHERE a.id_ped = ".$pedido['id_ped']
        );
    }

    return $pedidos;
}
