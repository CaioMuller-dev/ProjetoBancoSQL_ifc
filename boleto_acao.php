<?php
/*
 * Controlador responsavel pela manutencao do cadastro de Boleto.
 */
require_once "boleto.php";
require_once "persistencia/PDOBoletoDAO.php";

if (!defined("BOLETO_DESTINO")) {
    define("BOLETO_DESTINO", "boleto_index.php");
}

$acao = "";
switch ($_SERVER['REQUEST_METHOD'] ?? '') {
    case 'GET':
        $acao = $_GET['acao'] ?? "";
        break;
    case 'POST':
        $acao = $_POST['acao'] ?? "";
        break;
}

switch ($acao) {
    case 'Salvar':
        boleto_salvar();
        break;
    case 'Alterar':
        boleto_alterar();
        break;
    case 'excluir':
        boleto_excluir();
        break;
}

/*
 * Converte os dados do formulario em um array.
 */
function boleto_tela2array()
{
    return array(
        'id' => isset($_POST['id']) ? (int) $_POST['id'] : 0,
        'data_vencimento' => boleto_data($_POST['data_vencimento'] ?? null),
        'data_emissao' => boleto_data($_POST['data_emissao'] ?? null),
        'data_pagamento' => boleto_data($_POST['data_pagamento'] ?? null),
        'valor' => boleto_numero($_POST['valor'] ?? null),
        'desconto' => boleto_numero($_POST['desconto'] ?? null),
        'juros' => boleto_numero($_POST['juros'] ?? null),
        'multa' => boleto_numero($_POST['multa'] ?? null),
        'mora' => boleto_numero($_POST['mora'] ?? null),
        'valor_pago' => boleto_numero($_POST['valor_pago'] ?? null)
    );
}

/*
 * Normaliza uma data recebida do formulario.
 */
function boleto_data($data)
{
    $data = trim((string) $data);
    return $data === "" ? null : $data;
}

/*
 * Normaliza um valor numerico recebido do formulario.
 */
function boleto_numero($valor)
{
    if ($valor === null || $valor === "") {
        return 0.0;
    }
    $valor = trim((string) $valor);
    if (strpos($valor, ',') !== false) {
        $valor = str_replace('.', '', $valor);
        $valor = str_replace(',', '.', $valor);
    }
    return (float) $valor;
}

/*
 * Converte array em objeto Boleto.
 */
function boleto_array2objeto($dados)
{
    $elemento = new Boleto();
    $elemento->id = $dados['id'];
    $elemento->data_vencimento = $dados['data_vencimento'];
    $elemento->data_emissao = $dados['data_emissao'];
    $elemento->data_pagamento = $dados['data_pagamento'];
    $elemento->valor = $dados['valor'];
    $elemento->desconto = $dados['desconto'];
    $elemento->juros = $dados['juros'];
    $elemento->multa = $dados['multa'];
    $elemento->mora = $dados['mora'];
    $elemento->valor_pago = $dados['valor_pago'];
    return $elemento;
}

/*
 * Carrega um boleto pelo id.
 */
function boleto_carregar($id)
{
    $dao = PDOBoletoDAO::getInstance();
    return $dao->obter($id);
}

/*
 * Salva um novo boleto.
 */
function boleto_salvar()
{
    $dados = boleto_tela2array();
    $objeto = boleto_array2objeto($dados);
    $dao = PDOBoletoDAO::getInstance();
    $dao->inserir($objeto);
    header("Location: " . BOLETO_DESTINO);
    exit;
}

/*
 * Altera um boleto existente.
 */
function boleto_alterar()
{
    $dados = boleto_tela2array();
    $objeto = boleto_array2objeto($dados);
    $dao = PDOBoletoDAO::getInstance();
    $dao->alterar($objeto);
    header("Location: " . BOLETO_DESTINO);
    exit;
}

/*
 * Exclui um boleto.
 */
function boleto_excluir()
{
    $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
    $dao = PDOBoletoDAO::getInstance();
    $dao->excluir($id);
    header("Location: " . BOLETO_DESTINO);
    exit;
}

/*
 * Formata uma data no padrao brasileiro.
 */
function boleto_data_br($data)
{
    if ($data === null || $data === "") {
        return "-";
    }
    $dt = DateTime::createFromFormat('Y-m-d', $data);
    return $dt ? $dt->format('d/m/Y') : htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

/*
 * Formata um valor monetario.
 */
function boleto_moeda($valor)
{
    if ($valor === null || $valor === "") {
        return "-";
    }
    return "R$ " . number_format((float) $valor, 2, ',', '.');
}
