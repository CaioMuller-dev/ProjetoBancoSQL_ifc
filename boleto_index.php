<?php
require_once "boleto_acao.php";

$dao = PDOBoletoDAO::getInstance();
$dados = $dao->listar();
?>
<!DOCTYPE html>
<html lang="pt-BR" data-theme="dark">
<?php include 'cabecalho.php'; ?>

<body>
    <main class="container">
        <?php include 'menu.php'; ?>
        <?php if (count($dados) == 0): ?>
            <div><span class="warning">sem dados a serem exibidos</span></div>
        <?php endif; ?>
        <table role="grid">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Vencimento</th>
                    <th>Emissão</th>
                    <th>Pagamento</th>
                    <th>Valor</th>
                    <th>Desconto</th>
                    <th>Juros</th>
                    <th>Multa</th>
                    <th>Mora</th>
                    <th>Valor pago</th>
                    <th>Alterar</th>
                    <th>Excluir</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dados as $key): ?>
                    <tr>
                        <td><?= (int) $key['id'] ?></td>
                        <td><?= boleto_data_br($key['data_vencimento']) ?></td>
                        <td><?= boleto_data_br($key['data_emissao']) ?></td>
                        <td><?= boleto_data_br($key['data_pagamento']) ?></td>
                        <td><?= boleto_moeda($key['valor']) ?></td>
                        <td><?= boleto_moeda($key['desconto']) ?></td>
                        <td><?= boleto_moeda($key['juros']) ?></td>
                        <td><?= boleto_moeda($key['multa']) ?></td>
                        <td><?= boleto_moeda($key['mora']) ?></td>
                        <td><?= boleto_moeda($key['valor_pago']) ?></td>
                        <td align="center">
                            <a role="button" href="boleto_cad.php?id=<?= (int) $key['id'] ?>">A</a>
                        </td>
                        <td align="center">
                            <a role="button"
                                href="javascript:excluirRegistro('boleto_acao.php?acao=excluir&id=<?= (int) $key['id'] ?>');">E</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
    <script>
        function excluirRegistro(url) {
            if (confirm("Confirmar Exclusão?"))
                location.href = url;
        }
    </script>
</body>

</html>
