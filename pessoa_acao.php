<?php

/*
 * Código de exemplo da utilização de PDO como persistencia
 * Controlador reponsável pela manutenção do cadastro da entidade Pessoa
 * @author Wesley R. Bezerra <wesley.bezerra@ifc.edu.br>
 * @version 0.1
 *
 */
require_once "pessoa.php";
require_once "persistencia/PDOPessoaDAO.php";
/* definição de constantes */
define("DESTINO", "index.php");
define("ARQUIVO_XML", "pessoa.xml");

/* escolha da ação que processará a requisição */
$acao = "";
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $acao = isset($_GET['acao']) ? $_GET['acao'] : "";
        break;
    case 'POST':
        $acao = isset($_POST['acao']) ? $_POST['acao'] : "";
        break;
}

switch ($acao) {
    case 'Salvar':
        salvar();
        break;
    case 'Alterar':
        alterar();
        break;
    case 'excluir':
        excluir();
        break;
}

/*
 * Método que converte formulário html para array com respectivos dados
 * @return array
 */
function tela2array()
{
    $novo = array(
        'id' => isset($_POST['id']) ? $_POST['id'] : date("YmdHis"),
        'nome' => isset($_POST['nome']) ? $_POST['nome'] : "",
        'peso' => isset($_POST['peso']) ? $_POST['peso'] : "",
        'altura' => isset($_POST['altura']) ? $_POST['altura'] : "",
        'idade' => isset($_POST['idade']) ? $_POST['idade'] : "",
        'sexo' => isset($_POST['sexo']) ? $_POST['sexo'] : ""
    );
    if ($novo['id'] == "0") {
        $novo['id'] = date("YmdHis");
    }
    return $novo;
}

/*
 * Método que converte array para objeto
 * @return String json
 */
function array2objeto($array_dados)
{
    $elemento = new Pessoa();

    $elemento->id = $array_dados['id'];
    $elemento->nome = $array_dados['nome'];
    $elemento->peso = $array_dados['peso'];
    $elemento->altura = $array_dados['altura'];
    $elemento->idade = $array_dados['idade'];
    $elemento->sexo = $array_dados['sexo'];

    return $elemento;
}


/*
 * Método que converte array para objeto
 * @return String array
 */
function objeto2array($elemento)
{
    $dado = array(
        'id' => (string) $elemento->id,
        'nome' => (string) $elemento->nome,
        'peso' => (string) $elemento->peso,
        'altura' => (string) $elemento->altura,
        'idade' => (string) $elemento->idade,
        'sexo' => (string) $elemento->sexo
    );

    return $dado;
}

/*
 * Método que lê os dados e os carrega em um variável chamada json
 * @param $id int identificador numérico do registro
 * @return String dados codificados no formato json
 */
function carregar($id)
{
    $dao = PDOPessoaDAO::getInstance();
    $dados = $dao->obter($id);
    return $dados;
}

/*
 * Método que altera os dados de um registro
 * @return void
 */
function alterar() //todo: ainda nao funciona
{
    $novo = tela2array();

    $dao = PDOPessoaDAO::getInstance();
    $objeto = array2objeto($novo);
    $dados = $dao->alterar($objeto);


    header("location:" . DESTINO);

}


/*
1 - abrir json em formato php;
2 - percorrer e achar o item pelo ID;
3 - estratégia de deletar;
4 - gravar em json novamente, sem o item;
5 - redirecionar para a página index.php
*/

/*
 * Método exclui um registro
 * @return void
 */
function excluir()
{
    $id = isset($_GET['id']) ? $_GET['id'] : "";
    $dao = PDOPessoaDAO::getInstance();
    $dados = $dao->excluir($id);

    header("location:" . DESTINO);

}
/*
 * Método salva alterações feitas em um registro
 * @return void
 */
function salvar()
{
    $xml = NULL;
    $novo = tela2array();

    $dao = PDOPessoaDAO::getInstance();
    $objeto = array2objeto($novo);
    $dados = $dao->inserir($objeto);

    header("location:" . DESTINO);
}

?>