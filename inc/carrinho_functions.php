<?php

/*
    Funções que substituem as antigas Stored Procedures do MySQL
    (sp_carrinhosprodutos_add, sp_carrinhosprodutos_list, sp_carrinhosprodutos_rem,
    sp_carrinhosprodutostodos_rem, sp_carrinhos_get, sp_carrinhosprodutosfrete_list).

    Motivo: o plano gratuito do InfinityFree não permite CREATE ROUTINE / ALTER ROUTINE,
    então stored procedures não podem ser criadas no banco. A lógica que estava dentro
    de cada procedure foi movida para cá, em PHP puro, usando a mesma classe Sql já
    utilizada no restante do projeto (métodos select() e query()).

    Nenhuma rota do index.php muda de comportamento - só troca "CALL sp_xxx(...)"
    por chamadas dessas funções.
*/

/**
 * Lista os produtos de um carrinho, com quantidade e total.
 * Equivalente a: sp_carrinhosprodutos_list(pid_car)
 */
function sp_carrinhosprodutos_list($pid_car) {

    $pid_car = (int) $pid_car;

    $sql = new Sql();

    return $sql->select("
        SELECT
            a.id_prod, a.id_car,
            b.nome_prod_longo, b.nome_prod_curto, b.preco, b.peso,
            b.largura_centimetro, b.altura_centimetro, b.comprimento_centimetro,
            b.foto_principal,
            COUNT(*) AS qtd_car,
            SUM(b.preco) AS total
        FROM tb_carrinhosprodutos a
        INNER JOIN tb_produtos b USING(id_prod)
        WHERE a.id_car = $pid_car
        GROUP BY
            a.id_prod, a.id_car, b.nome_prod_longo, b.nome_prod_curto, b.preco,
            b.peso, b.largura_centimetro, b.altura_centimetro, b.comprimento_centimetro,
            b.foto_principal
    ");
}

/**
 * Adiciona um produto ao carrinho e retorna a lista atualizada.
 * Equivalente a: sp_carrinhosprodutos_add(pid_car, pid_prod)
 */
function sp_carrinhosprodutos_add($pid_car, $pid_prod) {

    $pid_car = (int) $pid_car;
    $pid_prod = (int) $pid_prod;

    $sql = new Sql();
    $sql->query("INSERT INTO tb_carrinhosprodutos (id_car, id_prod) VALUES($pid_car, $pid_prod)");

    return sp_carrinhosprodutos_list($pid_car);
}

/**
 * Remove UMA unidade de um produto do carrinho e retorna a lista atualizada.
 * Equivalente a: sp_carrinhosprodutos_rem(pid_car, pid_prod)
 */
function sp_carrinhosprodutos_rem($pid_car, $pid_prod) {

    $pid_car = (int) $pid_car;
    $pid_prod = (int) $pid_prod;

    $sql = new Sql();
    $sql->query("DELETE FROM tb_carrinhosprodutos WHERE id_car = $pid_car AND id_prod = $pid_prod LIMIT 1");

    return sp_carrinhosprodutos_list($pid_car);
}

/**
 * Remove TODAS as unidades de um produto do carrinho e retorna a lista atualizada.
 * Equivalente a: sp_carrinhosprodutostodos_rem(pid_car, pid_prod)
 */
function sp_carrinhosprodutostodos_rem($pid_car, $pid_prod) {

    $pid_car = (int) $pid_car;
    $pid_prod = (int) $pid_prod;

    $sql = new Sql();
    $sql->query("DELETE FROM tb_carrinhosprodutos WHERE id_car = $pid_car AND id_prod = $pid_prod");

    return sp_carrinhosprodutos_list($pid_car);
}

/**
 * Busca o carrinho da sessão atual (criando um novo se não existir) e
 * retorna um array com id_car, frete_car, cep_car, data_car, session_car,
 * qtd_prod, subtotal_car e total_car.
 * Equivalente a: sp_carrinhos_get(psession_car)
 */
function sp_carrinhos_get($psession_car) {

    // session_id() só contém caracteres alfanuméricos, então é seguro concatenar direto
    $psession_car = (string) $psession_car;

    $sql = new Sql();
    $rows = $sql->select("SELECT id_car FROM tb_carrinhos WHERE session_car = '$psession_car'");

    if (empty($rows)) {

        $sql = new Sql();
        $sql->query("INSERT INTO tb_carrinhos (session_car, data_car) VALUES('$psession_car', NOW())");

        $sql = new Sql();
        $rows = $sql->select("SELECT id_car FROM tb_carrinhos WHERE session_car = '$psession_car' ORDER BY id_car DESC LIMIT 1");
    }

    $pid_car = (int) $rows[0]['id_car'];

    $sql = new Sql();
    $totais = $sql->select("
        SELECT COUNT(*) AS qtd_prod, SUM(b.preco) AS subtotal_car
        FROM tb_carrinhosprodutos a
        INNER JOIN tb_produtos b USING(id_prod)
        WHERE a.id_car = $pid_car
    ");

    $qtd_prod = $totais[0]['qtd_prod'] ?? 0;
    $subtotal_car = $totais[0]['subtotal_car'] ?? 0;

    $sql = new Sql();
    $carrinho = $sql->select("SELECT id_car, frete_car, cep_car, prazo_car, data_car, session_car FROM tb_carrinhos WHERE id_car = $pid_car");

    $carrinho[0]['qtd_prod'] = $qtd_prod;
    $carrinho[0]['subtotal_car'] = $subtotal_car;
    $carrinho[0]['total_car'] = (float) $subtotal_car + (float) ($carrinho[0]['frete_car'] ?? 0);

    return $carrinho;
}

/**
 * Retorna os dados de peso/dimensão/preço dos produtos do carrinho,
 * usados no cálculo de frete.
 * Equivalente a: sp_carrinhosprodutosfrete_list(pid_car)
 */
function sp_carrinhosprodutosfrete_list($pid_car) {

    $pid_car = (int) $pid_car;

    $sql = new Sql();

    return $sql->select("
        SELECT
            b.preco * COUNT(*) AS preco,
            b.peso * COUNT(*) AS peso,
            b.largura_centimetro * COUNT(*) AS largura,
            b.altura_centimetro * COUNT(*) AS altura,
            b.comprimento_centimetro * COUNT(*) AS comprimento,
            a.id_car
        FROM tb_carrinhosprodutos a
        INNER JOIN tb_produtos b USING(id_prod)
        WHERE a.id_car = $pid_car
        GROUP BY b.id_prod
    ");
}
