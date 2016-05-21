<?php
require_once("CRUDGenerico.class.php");

//$crud = new CRUDGenerico();

Class produto{
    
    private $crud;
    
    public function produto()
    {
        $this->crud = CRUDGenerico::getInstance('produtos');         
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
        
        $sql        = "Select * From produtos $where";  
        
        $dados      = $this->crud->getSQLGeneric($sql, $arrayParam, "");  
        //$dados      = CRUDGenerico::getSQLGeneric($sql, $arrayParam, FALSE);
        
        return $dados;
        
    }
    
    public function cadastro($dados)
    {
        $arrayDados = array('descricao' => $_POST['descricao_produto'], 'unidade' => $_POST['unidade_produto'], 'disponibilidade' => 'b'+$_POST['disponibilidade_produto'], 'precovenda' => $_POST['preco_produto'] );  
        $retorno    = $this->crud->insert($arrayDados);  
        
        return $retorno;
    }
    
    public function apaga($dados)
    {
        $arrayCond = array('codigo=' => $_POST['codigo']);  
        $retorno   = $this->crud->delete($arrayCond);  
        
        return $retorno;
    }
    
}

?>