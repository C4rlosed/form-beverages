<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Edição de Registro</title>
</head>
<body>
    <div class="container">
        <div id="titulo">
            <h1> Edição de Registro </h1> <br>
        </div>
        <?php
            if(isset($_GET["txtCodEstoque"])){
            $codigo = $_GET["txtCodEstoque"];
            session_start();

            $codigo = $_SESSION['registro'][$codigo-1]['ECodigo'];
            $codigoBebida = $_SESSION['registro'][$codigo-1]['BCodigo'];
            $descricao = $_SESSION['registro'][$codigo-1]['BDescricao'];
            $ml = $_SESSION['registro'][$codigo-1]['BML'];
            $qtdeBebida = $_SESSION['registro'][$codigo-1]['EQtde'];
            $compra = $_SESSION['registro'][$codigo-1]['ECompra'];
            $venda = $_SESSION['registro'][$codigo-1]['EVenda'];
            session_destroy();
        ?>
            <form method="post" action="envio.php" id="frmContato" autocomplete="off">
                <fieldset>
                    <legend>Formulário</legend>
                    <div>
                        <label class="form-label" for="txtCod"> Código: </label>
                        <input type="int" value="<?=$codigo?>"id="txtCod" name="txtCod" readonly required />
                    </div>
                    <div>
                        <label class="form-label" for="txtCod_Bebida"> Código Bebida: </label>
                        <input type="int" value="<?=$codigoBebida?>" id="txtCod_Bebida" name="txtCod_Bebida" maxlength="50" placeholder="Código da Bebida" required />
                    </div>
                    <div>
                        <label class="form-label" for="txtDescricao"> Descrição: </label>
                        <input type="int" value="<?=$descricao?>" id="txtDescricao" name="txtDescricao" maxlength="50" placeholder="Nome da bebida" required />
                    </div>
                    <div>
                        <label class="form-label" for="txtML"> ML: </label>
                        <input type="int" value="<?=$ml?>" id="txtML" name="txtML" maxlength="50" placeholder="000" required />
                    </div>
                    <div>
                        <label class="form-label" for="txtQuant"> Quantidade: </label>
                        <input type="int" value="<?=$qtdeBebida?>" id="txtQuant" name="txtQuant" maxlength="14" placeholder="000" required />
                    </div>
                    <div>
                        <label class="form-label" for="txtCompra"> Compra: </label>
                        <input type="decimal" value="<?=$compra?>" id="txtCompra" name="txtCompra" placeholder="Ex:R$123.46" required />
                    </div>
                    <div>
                        <label class="form-label" for="txtVenda"> Venda: </label>
                        <input type="decimal" value="<?=$venda?>" id="txtVenda" name="txtVenda" placeholder="Ex:R$123.46" required />
                    </div>
                    <div>
                        <button class="btn btn-primary" type="submit" name="btnEditar"> Editar </button>
                        <button class="btn btn-secondary"type="reset" name="btnLimpar">Limpar</button>
                    </div>
                </fieldset>
            </form>
            <?php
        //Fechamento do if.
        }
        ?>
        <a href="../index.html">Voltar</a>
    </div>
</body>
</html>