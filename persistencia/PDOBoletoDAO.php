<?php
/*
 * Persistencia de Boleto utilizando PDO e SQLite.
 */
include_once __DIR__ . "/BoletoDAO.php";

class PDOBoletoDAO extends BoletoDAO
{
    private static $instance = NULL;
    private $conn = NULL;

    private function __construct()
    {
        $this->connect();
    }

    public static function getInstance()
    {
        if (self::$instance === NULL) {
            self::$instance = new PDOBoletoDAO();
        }
        return self::$instance;
    }

    /*
     * Abre a conexao e garante que a tabela boleto exista.
     */
    public function connect()
    {
        try {
            $this->conn = new PDO('sqlite:' . __DIR__ . '/pessoas.db');
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec(
                'CREATE TABLE IF NOT EXISTS boleto (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    data_vencimento TEXT NOT NULL,
                    data_emissao TEXT NOT NULL,
                    data_pagamento TEXT,
                    valor REAL NOT NULL DEFAULT 0,
                    desconto REAL NOT NULL DEFAULT 0,
                    juros REAL NOT NULL DEFAULT 0,
                    multa REAL NOT NULL DEFAULT 0,
                    mora REAL NOT NULL DEFAULT 0,
                    valor_pago REAL NOT NULL DEFAULT 0
                )'
            );
        } catch (PDOException $e) {
            error_log('Error: ' . $e->getMessage());
        }
    }

    /*
     * Insere um boleto e retorna o id gerado.
     */
    public function inserir($objeto)
    {
        try {
            $stmt = $this->conn->prepare(
                'INSERT INTO boleto
                    (data_vencimento, data_emissao, data_pagamento, valor, desconto,
                     juros, multa, mora, valor_pago)
                 VALUES
                    (:data_vencimento, :data_emissao, :data_pagamento, :valor, :desconto,
                     :juros, :multa, :mora, :valor_pago)'
            );
            $stmt->execute(array(
                ':data_vencimento' => $objeto->data_vencimento,
                ':data_emissao' => $objeto->data_emissao,
                ':data_pagamento' => $objeto->data_pagamento,
                ':valor' => $objeto->valor,
                ':desconto' => $objeto->desconto,
                ':juros' => $objeto->juros,
                ':multa' => $objeto->multa,
                ':mora' => $objeto->mora,
                ':valor_pago' => $objeto->valor_pago
            ));
            return (int) $this->conn->lastInsertId();
        } catch (PDOException $e) {
            error_log('Error: ' . $e->getMessage());
            return false;
        }
    }

    /*
     * Altera um boleto existente.
     */
    public function alterar($objeto)
    {
        try {
            $stmt = $this->conn->prepare(
                'UPDATE boleto SET
                    data_vencimento = :data_vencimento,
                    data_emissao = :data_emissao,
                    data_pagamento = :data_pagamento,
                    valor = :valor,
                    desconto = :desconto,
                    juros = :juros,
                    multa = :multa,
                    mora = :mora,
                    valor_pago = :valor_pago
                 WHERE id = :id'
            );
            $stmt->execute(array(
                ':data_vencimento' => $objeto->data_vencimento,
                ':data_emissao' => $objeto->data_emissao,
                ':data_pagamento' => $objeto->data_pagamento,
                ':valor' => $objeto->valor,
                ':desconto' => $objeto->desconto,
                ':juros' => $objeto->juros,
                ':multa' => $objeto->multa,
                ':mora' => $objeto->mora,
                ':valor_pago' => $objeto->valor_pago,
                ':id' => $objeto->id
            ));
            return $stmt->rowCount();
        } catch (PDOException $e) {
            error_log('Error: ' . $e->getMessage());
            return false;
        }
    }

    /*
     * Exclui um boleto pelo id.
     */
    public function excluir($id)
    {
        try {
            $stmt = $this->conn->prepare('DELETE FROM boleto WHERE id = :id');
            $stmt->execute(array(':id' => $id));
            return $stmt->rowCount();
        } catch (PDOException $e) {
            error_log('Error: ' . $e->getMessage());
            return false;
        }
    }

    /*
     * Lista todos os boletos ordenados pela data de vencimento.
     */
    public function listar()
    {
        $dados = array();
        try {
            $result = $this->conn->query('SELECT * FROM boleto ORDER BY data_vencimento, id');
            while ($linha = $result->fetch(PDO::FETCH_ASSOC)) {
                $dados[] = $linha;
            }
        } catch (PDOException $e) {
            error_log('Error: ' . $e->getMessage());
        }
        return $dados;
    }

    /*
     * Obtem um boleto pelo id.
     */
    public function obter($id)
    {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM boleto WHERE id = :id');
            $stmt->execute(array(':id' => $id));
            $linha = $stmt->fetch(PDO::FETCH_ASSOC);
            return $linha ? $linha : array();
        } catch (PDOException $e) {
            error_log('Error: ' . $e->getMessage());
            return array();
        }
    }
}
