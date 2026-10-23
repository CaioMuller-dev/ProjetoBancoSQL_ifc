<?php
/*
 * Classe Boleto
 * Representa um boleto com os dados utilizados pelo CRUD.
 */
class Boleto
{
    public $id;
    public $data_vencimento;
    public $data_emissao;
    public $data_pagamento;
    public $valor;
    public $desconto;
    public $juros;
    public $multa;
    public $mora;
    public $valor_pago;
}
