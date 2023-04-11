<?php

    //Importar o arquivo com a classe de conexão
    include "controlepdo.php";
    //Instância da classe de conexão
    $conexao = new Conexao();
    
    if(isset($_POST["btnEnviar"])){
        $conexao = new Conexao();
        $conexao->InserirRegistros();   
    }else if(isset($_POST["btnListar"])){
        $conexao = new Conexao();
        $conexao->SelecionarRegistros();
    }else if(isset($_POST["btnExcluir"])){
        $conexao->DeletarRegistros();
        $conexao->SelecionarRegistros();        
    }else if(isset($_POST["btnEditar"])){
        $conexao->EditarRegistros();
        $conexao->SelecionarRegistros();
    }else if(isset($_POST["btnTListar"])){
        $conexao->SelecionarTRegistros();
    }else if(isset($_POST["btnVenda"])){
        $conexao->VendaBebida();  
        $conexao->AtualizarTotal();    
        $conexao->SelecionarRegistrosTotal();
        $conexao->DeletarVenda();
    }else{
        echo "ERRO - Nenhuma ação executada.";
    }
?>