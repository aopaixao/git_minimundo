<?php  
  
 /*************************************************************************************************************** 
 * @author Alexandre Paix�o                                                                                     *  
 * Data: 20/06/2014                                                                                             *
 * T�tulo: CRUD gen�rico                                                                                        *  
 * Descri��o: A Classe de CRUD gen�rico foi elaborada com o objetivo de auxlilar nas opera��es CRUDs em diversos* 
 * SGBDS, possui funcionalidades para construir instru��es de INSERT, UPDATE E DELETE onde as mesmas podem ser  *
 * executadas nos principais SGBDs, exemplo SQL Server, MySQL e Firebird. Instru��es SELECT s�o recebidas       *
 * integralmente via par�metro.                                                                                 *  
 *************************************************************************************************************/  
  
header('Content-Type: text/html; charset=utf-8'); 

require_once("dbo/Conn.class.php");
//$conn = new Conn();
//$conn->getInstance(); 
//Conn::getInstance();

 
Class CRUDGenerico{   

    // Atributo para guardar uma conex�o PDO   
    private $pdo         = null;   

    // Atributo onde ser� guardado o nome da tabela    
    private $tabela      = null;   

    // Atributo est�tico que cont�m uma inst�ncia da pr�pria classe   
    private static $crud = null;   
      
    /*   
    * M�todo privado construtor da classe    
    * @param $conexao = Conex�o PDO configurada   
    * @param $tabela = Nome da tabela    
    */   
    private function __construct($tabela=NULL)
    {   
        $this->pdo = Conn::getInstance();
        
        /**
        if (!empty($conexao)){  
            $this->pdo = Conn::getInstance();
        }else{  
            echo "<h3>Conex�o inexistente!</h3>";  
            exit();  
        }   
        /**/
        
        if (!empty($tabela)){
            $this->tabela =$tabela;
        }      
        /**/ 
    }   

    /*    
    * M�todo p�blico est�tico que retorna uma inst�ncia da classe Crud    
    * @param $conexao = Conex�o PDO configurada   
    * @param $tabela = Nome da tabela   
    * @return Atributo contendo inst�ncia da classe Crud   
    */   
    public static function getInstance($tabela=NULL)
    {   
     
        // Verifica se existe uma inst�ncia da classe   
        //if(!isset(self::$crud)){
            try {   
                self::$crud = new CRUDGenerico($tabela);   
            } catch (Exception $e) {   
                echo "Erro " . $e->getMessage();   
            }   
        //}

        return self::$crud;   
     
    }   

    /*  
    * M�todo para setar o nome da tabela na propriedade $tabela  
    * @param $tabela = String contendo o nome da tabela  
    */   
    public function setTableName($tabela)
    {  
        if(!empty($tabela)){  
            $this->tabela = $tabela;  
        }  
    }  

    /*   
    * M�todo privado para constru��o da instru��o SQL de INSERT   
    * @param $arrayDados = Array de dados contendo colunas e valores   
    * @return String contendo instru��o SQL   
    */    
    private function buildInsert($arrayDados)
    {   

        // Inicializa vari�veis   
        $sql = "";   
        $campos = "";   
        $valores = "";   

        // Loop para montar a instru��o com os campos e valores   
        foreach($arrayDados as $chave => $valor){   
            $campos .= $chave . ', ';   
            $valores .= '?, ';   
        }
           

        // Retira v�rgula do final da string   
        $campos = (substr($campos, -2) == ', ') ? trim(substr($campos, 0, (strlen($campos) - 2))) : $campos ;    

        // Retira v�rgula do final da string   
        $valores = (substr($valores, -2) == ', ') ? trim(substr($valores, 0, (strlen($valores) - 2))) : $valores ;    

        // Concatena todas as vari�veis e finaliza a instru��o   
        $sql .= "INSERT INTO {$this->tabela} (" . $campos . ")VALUES(" . $valores . ")";   

        // Retorna string com instru��o SQL   
        return trim($sql);
           
    }   

    /*   
    * M�todo privado para constru��o da instru��o SQL de UPDATE   
    * @param $arrayDados = Array de dados contendo colunas, operadores e valores   
    * @param $arrayCondicao = Array de dados contendo colunas e valores para condi��o WHERE   
    * @return String contendo instru��o SQL   
    */    
    private function buildUpdate($arrayDados, $arrayCondicao)
    {   

        // Inicializa vari�veis   
        $sql = "";   
        $valCampos = "";   
        $valCondicao = "";   

        // Loop para montar a instru��o com os campos e valores   
        foreach($arrayDados as $chave => $valor){   
            $valCampos .= $chave . '=?, ';   
        }   

        // Loop para montar a condi��o WHERE   
        foreach($arrayCondicao as $chave => $valor){   
            $valCondicao .= $chave . '? AND ';   
        }   

        // Retira v�rgula do final da string   
        $valCampos = (substr($valCampos, -2) == ', ') ? trim(substr($valCampos, 0, (strlen($valCampos) - 2))) : $valCampos ;    

        // Retira v�rgula do final da string   
        $valCondicao = (substr($valCondicao, -4) == 'AND ') ? trim(substr($valCondicao, 0, (strlen($valCondicao) - 4))) : $valCondicao ;    

        // Concatena todas as vari�veis e finaliza a instru��o   
        $sql .= "UPDATE {$this->tabela} SET " . $valCampos . " WHERE " . $valCondicao;   

        // Retorna string com instru��o SQL   
        return trim($sql);
       
    }   

    /*   
    * M�todo privado para constru��o da instru��o SQL de DELETE   
    * @param $arrayCondicao = Array de dados contendo colunas, operadores e valores para condi��o WHERE   
    * @return String contendo instru��o SQL   
    */    
    private function buildDelete($arrayCondicao)
    {   

        // Inicializa vari�veis   
        $sql = "";   
        $valCampos= "";   

        // Loop para montar a instru��o com os campos e valores   
        foreach($arrayCondicao as $chave => $valor){   
            $valCampos .= $chave . '? AND ';   
        }   

        // Retira a palavra AND do final da string   
        $valCampos = (substr($valCampos, -4) == 'AND ') ? trim(substr($valCampos, 0, (strlen($valCampos) - 4))) : $valCampos ;    

        // Concatena todas as vari�veis e finaliza a instru��o   
        $sql .= "DELETE FROM {$this->tabela} WHERE " . $valCampos;   

        // Retorna string com instru��o SQL   
        return trim($sql); 
      
    }   

    /*   
    * M�todo p�blico para inserir os dados na tabela   
    * @param $arrayDados = Array de dados contendo colunas e valores   
    * @return Retorna resultado booleano da instru��o SQL   
    */   
    public function insert($arrayDados)
    {   
        try {   

            // Atribui a instru��o SQL construida no m�todo   
            $sql = $this->buildInsert($arrayDados);   

            // Passa a instru��o para o PDO   
            $stm = $this->pdo->prepare($sql);   

            // Loop para passar os dados como par�metro   
            $cont = 1;   
            
            foreach ($arrayDados as $valor){   
                $stm->bindValue($cont, $valor);   
                $cont++;   
            }   

            // Executa a instru��o SQL e captura o retorno   
            $retorno = $stm->execute();   

            return $retorno;   

        } catch (PDOException $e) {   
            echo "Erro: " . $e->getMessage();   
        }   
    }   

    /*   
    * M�todo p�blico para atualizar os dados na tabela   
    * @param $arrayDados = Array de dados contendo colunas e valores   
    * @param $arrayCondicao = Array de dados contendo colunas e valores para condi��o WHERE - Exemplo array('$id='=>1)   
    * @return Retorna resultado booleano da instru��o SQL   
    */   
    public function update($arrayDados, $arrayCondicao)
    {   
        try {   

            // Atribui a instru��o SQL construida no m�todo   
            $sql = $this->buildUpdate($arrayDados, $arrayCondicao);   

            // Passa a instru��o para o PDO   
            $stm = $this->pdo->prepare($sql);   

            // Loop para passar os dados como par�metro   
            $cont = 1;   
            foreach ($arrayDados as $valor){   
                $stm->bindValue($cont, $valor);   
                $cont++;   
            }   

            // Loop para passar os dados como par�metro cl�usula WHERE   
            foreach ($arrayCondicao as $valor){   
                $stm->bindValue($cont, $valor);   
                $cont++;   
            }   

            // Executa a instru��o SQL e captura o retorno   
            $retorno = $stm->execute();   

            return $retorno;   

        } catch (PDOException $e) {   
            echo "Erro: " . $e->getMessage();   
        }   
    }   

    /*   
    * M�todo p�blico para excluir os dados na tabela   
    * @param $arrayCondicao = Array de dados contendo colunas e valores para condi��o WHERE - Exemplo array('$id='=>1)   
    * @return Retorna resultado booleano da instru��o SQL   
    */   
    public function delete($arrayCondicao)
    {   
        try {   
            // Atribui a instru��o SQL construida no m�todo   
            $sql = $this->buildDelete($arrayCondicao);   

            // Passa a instru��o para o PDO   
            $stm = $this->pdo->prepare($sql);   

            // Loop para passar os dados como par�metro cl�usula WHERE   
            $cont = 1;   
            foreach ($arrayCondicao as $valor){   
                $stm->bindValue($cont, $valor);   
                $cont++;   
            }

            // Executa a instru��o SQL e captura o retorno
            $retorno = $stm->execute();   

            return $retorno;   

        } catch (PDOException $e) {   
            echo "Erro: " . $e->getMessage();   
        }   
    }   

    /*  
    * M�todo gen�rico para executar instru��es de consulta independente do nome da tabela passada no _construct  
    * @param $sql = Instru��o SQL inteira contendo, nome das tabelas envolvidas, JOINS, WHERE, ORDER BY, GROUP BY e LIMIT  
    * @param $arrayParam = Array contendo somente os par�metros necess�rios para cl�susla WHERE  
    * @param $fetchAll  = Valor booleano com valor default TRUE indicando que ser�o retornadas v�rias linhas, FALSE retorna apenas a primeira linha  
    * @return Retorna array de dados da consulta em forma de objetos  
    */  
    public function getSQLGeneric($sql, $arrayParams="", $fetchAll="")
    {  
        try {   

            // Passa a instru��o para o PDO   
            $stm = $this->pdo->prepare($sql); 
            
            // Verifica se existem condi��es para carregar os par�metros    
            if (!empty($arrayParams)){   

                // Loop para passar os dados como par�metro cl�usula WHERE   
                $cont = 1;   
                foreach ($arrayParams as $valor){   
                    $stm->bindValue($cont, $valor);   
                    $cont++;   
                }   

            }

            // Executa a instru��o SQL    
            $stm->execute();   
            
            /**/
            // Verifica se � necess�rio retornar v�rias linhas  
            if(empty($fetchAll)){   
                $dados = $stm->fetchAll(PDO::FETCH_OBJ);  
                //$dados = $stm->fetchAll(PDO::FETCH_ASSOC);  
            }else{  
                $dados = $stm->fetch(PDO::FETCH_OBJ);   
            }  
            
            /**/
        } catch (PDOException $e) {   
            echo "Erro: " . $e->getMessage();   
        }
        
        return $dados;
    }   
}  

?>