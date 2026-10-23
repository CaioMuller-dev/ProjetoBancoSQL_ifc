<?php
/*
 * Código de exemplo da utilização de PDO como persistencia
 * Classe abstrata para persistencia de Pessoa
 * @author Wesley R. Bezerra <wesley.bezerra@ifc.edu.br>
 * @version 0.1
 *
 */
abstract class PessoaDAO
{

    /*
     * Método faz a conexao com o recurso usado
     * @return void
     */
    public abstract function connect();
    /*
     * Método que insere dados no sistema de persistencia
     * @param $objeto Pessoa objeto que será inserido 
     * @return void
     */
    public abstract function inserir($objeto);
    /*
     * Método que altera dados no sistema de persistencia
     * @param $objeto Pessoa objeto que será inserido 
     * @return void
     */
    public abstract function alterar($objeto);
    /*
     * Método que exclui dados no sistema de persistencia
     * @param $id int identificador do registro 
     * @return void
     */
    public abstract function excluir($id);

    /*
     * Método que lista dados no sistema de persistencia
     * @return array array de dados
     */
    public abstract function listar();

    /* Método que lista dados com filtro no sistema de persistencia
     * @param $filtro String filtro para dados     
     * @return array array de dados
     */
    public abstract function listar_filtro($filtro);
    /*
     * Método que obtem dados no sistema de persistencia
     * @param $id int identificador do registro 
     * @return array objeto em array
     */
    public abstract function obter($id);
}
?>