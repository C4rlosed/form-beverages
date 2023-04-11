<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Exclusão de registro</title>
</head>
<body>
    <?php
    //Armazenar o código escolhido na lista.
    //Se o usuário acessar diretamente a página sem passar nenhum parâmetro, ela ficará em branco.
    //Em value no formulário, será configurada a variável $codigo.
    if(isset($_GET["txtCodCliente"])){
    $codigo = $_GET["txtCodCliente"];
    ?>
    <div class="container">
        <div id="titulo">
            <h1> Exclusão de Registro </h1> <br>
        </div>
        <form method="post" action="envio.php" id="frmExcluir" autocomplete="off">
            <fieldset>
                <legend>Tem certeza que deseja excluir o Resgistro?</legend>
                <span>
                    <label for="txtCod"> Código: </label>
                    <input type="text" id="txtCodCliente" name="txtCodCliente" value="<?=$codigo?>" readonly/>
                </span>
                <span>
                    <button type="submit" name="btnExcluir">Excluir</button>
                </span>
            </fieldset>
        </form>
    </div>
    <?php
    //Fechamento do if.
    }
    ?>
</body>
</html>
