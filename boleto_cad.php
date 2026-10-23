<?php
require_once "boleto_acao.php";

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$dados = array();
if ($id > 0) {
    $dados = boleto_carregar($id);
}

$valorCampo = static function ($campo) use ($dados) {
    return htmlspecialchars(
        isset($dados[$campo]) && $dados[$campo] !== null ? (string) $dados[$campo] : '',
        ENT_QUOTES,
        'UTF-8'
    );
};
?>
<!DOCTYPE html>
<html lang="pt-BR" data-theme="dark">
<?php include 'cabecalho.php'; ?>

<body>
    <header class="container">
        <?php include 'menu.php'; ?>
    </header>
    <main class="container">

        <form action="boleto_acao.php" method="post">
            <fieldset>
                <legend>Cadastro de Boletos</legend>

                <label for="id">Id</label>
                <input type="text" name="id" id="id" value="<?= $id ?>" readonly><br>

                <label for="data_vencimento">Data de vencimento</label>
                <input type="date" name="data_vencimento" id="data_vencimento"
                    value="<?= $valorCampo('data_vencimento') ?>" required><br>

                <label for="data_emissao">Data de emissão</label>
                <input type="date" name="data_emissao" id="data_emissao"
                    value="<?= $valorCampo('data_emissao') ?>" required><br>

                <label for="data_pagamento">Data de pagamento</label>
                <input type="date" name="data_pagamento" id="data_pagamento"
                    value="<?= $valorCampo('data_pagamento') ?>"><br>

                <label for="valor">Valor</label>
                <input type="number" name="valor" id="valor" step="0.01" min="0"
                    value="<?= $valorCampo('valor') ?>" required><br>

                <label for="desconto">Desconto</label>
                <input type="number" name="desconto" id="desconto" step="0.01" min="0"
                    value="<?= $valorCampo('desconto') ?>"><br>

                <label for="juros">Juros</label>
                <input type="number" name="juros" id="juros" step="0.01" min="0"
                    value="<?= $valorCampo('juros') ?>"><br>

                <label for="multa">Multa</label>
                <input type="number" name="multa" id="multa" step="0.01" min="0"
                    value="<?= $valorCampo('multa') ?>"><br>

                <label for="mora">Mora</label>
                <input type="number" name="mora" id="mora" step="0.01" min="0"
                    value="<?= $valorCampo('mora') ?>"><br>

                <label for="valor_pago">Valor pago</label>
                <input type="number" name="valor_pago" id="valor_pago" step="0.01" min="0"
                    value="<?= $valorCampo('valor_pago') ?>"><br>

                <input class="primary" type="submit" name="acao" id="acao"
                    value="<?= $id > 0 ? 'Alterar' : 'Salvar' ?>">
                <input type="reset" value="Cancelar">
                <a href="boleto_index.php" role="button" class="secondary">Voltar</a>

            </fieldset>
        </form>
    </main>
    <footer class="container"></footer>
</body>

</html>
