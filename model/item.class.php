<?php
require_once("CRUDGenerico.class.php");

//$crud = new CRUDGenerico();

Class item{
    
    private $crud;
    
    public function item()
    {
        $this->crud = CRUDGenerico::getInstance('itens');
    }
    
    public function lista($id = "")
    {
        
        if(! empty($id)){
            $where = "WHERE codigo = ?";
            $arrayParam = array($id);  
        }else{
            $where      = "";
            $arrayParam = "";  
        }
        
        $sql        = "Select * From itens $where";
        
        $dados      = $this->crud->getSQLGeneric($sql, $arrayParam, "");  
        //$dados      = CRUDGenerico::getSQLGeneric($sql, $arrayParam, FALSE);
        
        return $dados;
        
    }
    
    public function cadastro($dados)
    {

        $tableData = stripcslashes($_POST['pTableData']);

        $tableData = json_decode($tableData,TRUE);

        $countArr = count($tableData);

        for($i = 0;$i < $countArr;$i++){
            $arrayDados = array('numero' => $tableData[$i]['numero_pedido'], 'codigo' => $tableData[$i]['codigo_produto'], 'quantidade' => $tableData[$i]['quantidade_produto'], 'situacao' => $tableData[$i]['situacao_item'] );
            $retorno[$i] = $this->crud->insert($arrayDados);
        }

        //var_dump($retorno);

        $counArrRet = count($retorno);

        for($j = 0;$j < $counArrRet;$j++){
            if(!$retorno[$j]){
                return false;
            }
        }

        return true;

    }
    
    public function apaga($dados)
    {
        $arrayCond = array('cpf=' => $_POST['cpf']);  
        $retorno   = $this->crud->delete($arrayCond);  
        
        return $retorno;
    }
    
}

?>