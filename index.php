<?php
/*
 * Código de exemplo da utilização de PDO como persistencia
 * Página reponsável pela listagem da entidade Pessoa
 * @author Wesley R. Bezerra <wesley.bezerra@ifc.edu.br>
 * @version 0.1
 *
 */
?>
<!DOCTYPE html>
<html lang="pt-BR" data-theme="dark">
<?php include 'cabecalho.php'; ?>
<?php require_once 'pessoa_acao.php'; ?>

<body>
    <main class="container">
        <?php include 'menu.php'; ?>
        <?php


        $dao = PDOPessoaDAO::getInstance();        
        $dados = array();
        $dados = $dao->listar();
        if (($dados == NULL) || (count($dados) == 0)) {
            echo "<div><span class='warning'>sem dados a serem exibidos</span></div>";
        }
        ?>
        <table role="grid">
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>Altura</th>
                <th>Peso</th>
                <th>Idade</th>
                <th>Sexo</th>
                <th>Alterar</th>
                <th>Excluir</th>
            </tr>
            <?php
            foreach ($dados as $key)
                echo "<tr><td>{$key['id']}</td>
                  <td>{$key['nome']}</td>
                  <td>{$key['altura']}</td>
                  <td>{$key['peso']}</td>
                  <td>{$key['idade']}</td>
                  <td>{$key['sexo']}</td>
                  <td align='center'><a role='button' href='pessoa_cad.php?id=" . $key['id'] . "'>A</a></td>
                  <td align='center'><a role='button' href=javascript:excluirRegistro('pessoa_acao.php?acao=excluir&id=" . $key['id'] . "');>E</a></td>
              </tr>";
            ?>
        </table>
    </main>
    <!-- funcao de confirmacacao em javascript para a exclusao-->
    <script>
        function excluirRegistro(url) {
            if (confirm("Confirmar Exclusão?"))
                location.href = url;
        }
    </script>
</body>

</html>