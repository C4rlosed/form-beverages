<?php
class Conexao{
    //Constantes de definem os parâmetros do Banco de Dados
    const HOST = "localhost";
    const USER = "root";
    const PASSWORD = "";
    const DB_NAME = "bdestoque_bebidas";
    public function __construct()
    {
        $this->Conectar();
    }
    public function Conectar(){
        try
        {
            //Instância da classe PDO - Construtor realiza a conexão.
            $this->pdo = new PDO( 'mysql:host=' . self::HOST . ';dbname=' . self::DB_NAME, 
            self::USER, self::PASSWORD );
            //Parar o processo de conexão caso haja erro - lançar uma exceção.
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Conexão realizada com Sucesso";
        }
        catch ( PDOException $e )
        {
            echo 'Erro ao conectar com o MySQL: ' . $e->getMessage();
        }
    }

    public function InserirRegistros(){
        //ISSET verifica se o atributo foi configurado.
        if (isset($_POST["txtCod_Bebida"])) {
            //Declaração das variáveis
            $codbebida = $_POST["txtCod_Bebida"];
            $quantidade = $_POST["txtQuant"];
            $compra = $_POST["txtCompra"];
            $venda = $_POST["txtVenda"];

            //String de Inserção no Banco de dados
            $query = "INSERT INTO tb_estoque (EBCodigo, EQtde, ECompra, EVenda)
            VALUES (:codbebida, :quantidade, :compra, :venda)";

            //Atribui o Insert ao PDO
            $insert = $this->pdo->prepare($query);

            //Define os parâmetros que serão substituídos
            $insert->bindParam( ':codbebida', $codbebida );
            $insert->bindParam( ':quantidade', $quantidade );
            $insert->bindParam( ':compra', $compra );
            $insert->bindParam( ':venda', $venda );

            //Verifica se house inserção de registros no Banco de Dados
            if ($insert->execute()){
                //Se um registro foi inserido.
                echo "<p>Registro inserido com Sucesso</p>";
            }
            else{
                //Se nenhum registro foi inserido.
                echo "<p>Falha ao inserir registro.</p>";
            }
        }
    }
    public function SelecionarRegistros(){
        //Realiza a consulta com ou sem um parâmetro de nome
        if (empty($_POST["txtNomeBebida"])) {
            $query = "SELECT ESC.ECodigo, BEB.BCodigo, BEB.BDescricao, BEB.BML, ESC.EQtde, ESC.ECompra, ESC.EVenda 
            FROM tb_bebidas AS BEB INNER JOIN tb_estoque AS ESC ON BCodigo = EBCodigo";
            $select = $this->pdo->prepare($query);
        }else {
            $nomeBebida = $_POST["txtNomeBebida"];
            $nomeBebida = '%' . $nomeBebida . '%';
            $query = "SELECT E.ECodigo, BEB.BCodigo, BEB.BDescricao, BEB.BML, E.EQtde, E.ECompra, E.EVenda 
            FROM tb_estoque AS E INNER JOIN tb_bebidas AS BEB ON BEB.BCodigo = E.EBCodigo WHERE BEB.BDescricao LIKE :descricao";
            $select = $this->pdo->prepare($query);
            $select->bindParam(':descricao', $nomeBebida);
        }
        //Executa a query e retorna os registros do banco
        $select->execute();
        $linhas = $select->fetchAll(PDO::FETCH_ASSOC);
        //Verifica se há registros e cria uma estrutura de tabela.

        if(empty($linhas)){
            echo "Erro ao listar Bebidas ou tabela vazia!";
            }else{
            //Iniciar uma sessão - array oculto
            session_start();
            //Variável Global com um vetor vazio
            $_SESSION = array();
            require_once ("htmlcabecalho.php");
            require_once ("tabelacabecalho.php");
            for($i=0;$i<count($linhas);$i++){
                echo "<tr>";
                foreach($linhas[$i] as $coluna => $registro){
                    echo "<td>" . $registro . "</td>";
                    $_SESSION['registro'][$i][$coluna] = $registro;
                }
                ?>
                
                <!-- Atribuir o código e nome ao link -->
                <td><a href="formeditar.php?txtCodEstoque=<?=$linhas[$i]['ECodigo']?>">Editar</a></td>
                <?php
                echo "</tr>";
            }
            require_once ("tabelarodape.php");
            require_once ("htmlrodape.php");
            ?>
            <!DOCTYPE html>
            <a href="../index.html">Voltar</a >
            <?php
        }     
    }
    public function SelecionarTRegistros(){
        //Realiza a consulta com ou sem um parâmetro de nome
        if (empty($_POST["txtTBebidas"])) {
            $query = "SELECT EBCodigo, BDescricao, SUM(EQtde) AS 'Quantidade Total' FROM tb_estoque 
            INNER JOIN tb_bebidas ON tb_bebidas.BCodigo = tb_estoque.EBCodigo GROUP BY EBCodigo";
            $select = $this->pdo->prepare($query);
        }else {
            //Iniciar uma sessão - array oculto
            session_start();
            //Variável Global com um vetor vazio
            $_SESSION = array();
            $codbebida = $_POST["txtTBebidas"];
            $query = "SELECT EBCodigo, BDescricao, SUM(EQtde) AS 'Quantidade Total' FROM tb_estoque 
            INNER JOIN tb_bebidas ON tb_bebidas.BCodigo = tb_estoque.EBCodigo WHERE EBCodigo = :codbebida GROUP BY EBCodigo";
            $select = $this->pdo->prepare($query);
            $select->bindParam(':codbebida', $codbebida);
        }
        //Executa a query e retorna os registros do banco
        $select->execute();
        $linhas = $select->fetchAll(PDO::FETCH_ASSOC);
        //Verifica se há registros e cria uma estrutura de tabela.

        if(empty($linhas)){
            echo "Erro ao listar Bebidas ou tabela vazia!";
            }else{
            require_once ("htmlcabecalho.php");
            require_once ("tabelacabecalhot.php");
            for ($i = 0; $i < count($linhas); $i++) {
                echo "<tr>";
                foreach ($linhas[$i] as $registro) {
                    echo "<td>" . $registro . "</td>";
                }

                echo "</tr>";
            }
            require_once ("tabelarodape.php");
            require_once ("htmlrodape.php");
            ?>
            <!DOCTYPE html>
            <a href="../index.html">Voltar</a >
            <?php
        }     
    }
    
    public function EditarRegistros(){
        //ISSET verifica se o atributo foi configurado.
        if (isset($_POST["txtCod"])) {
            //Declaração das variáveis
            $codigo = $_POST["txtCod"];
            $codbebida = $_POST["txtCod_Bebida"];
            $descricao = $_POST["txtDescricao"];
            $ml = $_POST["txtML"];
            $quantidade = $_POST["txtQuant"];
            $compra = $_POST["txtCompra"];
            $venda = $_POST["txtVenda"];
            //String de atualização no Banco de dados
            $query = "UPDATE tb_estoque AS E INNER JOIN tb_bebidas AS B ON B.BCodigo = E.EBCodigo SET E.EBCodigo = :codbebida, B.BDescricao = :descricao, 
            B.BML = :ml, E.EQtde = :quantidade, E.ECompra = :compra, E.EVenda = :venda WHERE E.ECodigo = :codigo";
            //tb_estoque SET EBCodigo = :codbebida,  EQtde = :quantidade, ECompra = :compra, EVenda = :venda WHERE ECodigo = :codigo";
            //Atribui o Insert ao PDO
            $update = $this->pdo->prepare($query);
            //Define os parâmetros que serão substituídos
            $update->bindParam(':codigo', $codigo);
            $update->bindParam(':codbebida', $codbebida);
            $update->bindParam(':descricao', $descricao);
            $update->bindParam(':ml', $ml);
            $update->bindParam(':quantidade', $quantidade);
            $update->bindParam(':compra', $compra);
            $update->bindParam(':venda', $venda);
            //Verifica se house inserção de registros no Banco de Dados
            if ($update->execute()){
                //Se um registro foi inserido.
                echo "<p>Registro alterado com Sucesso</p>";
                ?>
                <!DOCTYPE html>
                <a href="../index.html">Voltar</a>
                <?php
            }
            else{
                //Se nenhum registro foi inserido.
                echo "<p>Falha ao alterar registro.</p>";
            }
        }
    }
    public function VendaBebida(){
        //ISSET verifica se o atributo foi configurado.
        if (isset($_POST["txtVendaBebida"])) {
            //Declaração das variáveis
            $codbebida = $_POST["txtVendaBebida"];
            $quantidade = $_POST["txtQuantidade"];
           

            //String de Inserção no Banco de dados
            $query = "INSERT INTO tb_venda (VeBeCodigo, VeQuantidade)
            VALUES (:codbebida, :quantidade)";

            //Atribui o Insert ao PDO
            $insert = $this->pdo->prepare($query);

            //Define os parâmetros que serão substituídos
            $insert->bindParam( ':codbebida', $codbebida );
            $insert->bindParam( ':quantidade', $quantidade );
           

            //Verifica se house inserção de registros no Banco de Dados
            if ($insert->execute()){
                //Se um registro foi inserido.
                echo "<p>Registro inserido com Sucesso</p>";
            }
            else{
                //Se nenhum registro foi inserido.
                echo "<p>Falha ao inserir registro.</p>";
            }
        }
    }
    public function AtualizarTotal(){
        //ISSET verifica se o atributo foi configurado.
        if (isset($_POST["txtVendaBebida"])) {
            //Declaração das variáveis
            $codbebida = $_POST["txtVendaBebida"];
            $qtde = $_POST["txtQuantidade"];
           

            //String de Inserção no Banco de dados
            $query = "UPDATE tb_estoque AS E INNER JOIN tb_venda AS V INNER JOIN tb_bebidas AS B SET E.EQtde = E.EQtde - V.VeQuantidade 
            WHERE B.BCodigo = E.EBCodigo AND B.BCodigo = :codbebida AND V.VeQuantidade = :qtde";

            //Atribui o Insert ao PDO
            $update = $this->pdo->prepare($query);

            //Define os parâmetros que serão substituídos
            $update->bindParam( ':codbebida', $codbebida );
            $update->bindParam( ':qtde', $qtde );
           

            //Verifica se house inserção de registros no Banco de Dados
            if ($update->execute()){
                //Se um registro foi inserido.
                echo "<p>Quantidade atualizada com Sucesso!</p>";
            }
            else{
                //Se nenhum registro foi inserido.
                echo "<p>Falha ao atualizar a Quantidade!</p>";
            }
        }
    }
    public function SelecionarRegistrosTotal(){
        //Realiza a consulta com ou sem um parâmetro de nome
    
        $codbebida = $_POST["txtVendaBebida"];
        
        $query = "SELECT E.EBCodigo, B.BDescricao, SUM(EQtde) FROM tb_estoque AS E
        INNER JOIN tb_bebidas AS B ON B.BCodigo = E.EBCodigo WHERE E.EBCodigo = :codbebida GROUP BY EBCodigo";
        $select = $this->pdo->prepare($query);
        $select->bindParam(':codbebida', $codbebida);
        
        //Executa a query e retorna os registros do banco
        $select->execute();
        $linhas = $select->fetchAll(PDO::FETCH_ASSOC);
        //Verifica se há registros e cria uma estrutura de tabela.

        if(empty($linhas)){
            echo "Erro ao listar Bebidas ou tabela vazia!";
            }else{
            require_once ("htmlcabecalho.php");
            require_once ("tabelacabecalhot.php");
            for ($i = 0; $i < count($linhas); $i++) {
                echo "<tr>";
                foreach ($linhas[$i] as $registro) {
                    echo "<td>" . $registro . "</td>";
                }

                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            require('./htmlrodape.php');
         
        }     
    }
    public function DeletarVenda(){
        //Realiza a consulta com ou sem um parâmetro de nome
        $codbebida = $_POST["txtVendaBebida"];
        
        $query = "DELETE FROM tb_venda WHERE VeBeCodigo = :codbebida";
        $select = $this->pdo->prepare($query);
        $select->bindParam(':codbebida', $codbebida);

        ?>
        <!DOCTYPE html>
        <a href="../index.html">Voltar</a>
        <?php
        
        //Executa a query e retorna os registros do banco
        $select->execute();
        $linhas = $select->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>


