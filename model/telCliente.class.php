<?php
require_once("CRUDGenerico.class.php");

//$crud = new CRUDGenerico();

Class telCliente{
    
    private $crud;
    
    public function telCliente()
    {
        $this->crud = CRUDGenerico::getInstance('telefones_clientes');         
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
        
        $sql        = "Select * From telefones_clientes $where";  
        
        $dados      = $this->crud->getSQLGeneric($sql, $arrayParam, "");  
        //$dados      = CRUDGenerico::getSQLGeneric($sql, $arrayParam, FALSE);
        
        return $dados;
        
    }
    
    public function cadastro($dados)
    {
        $arrayDados = array('cpf' => $_POST['pfk_cpf'], 'numero' => $_POST['numero_tel_cliente'] );  
        $retorno    = $this->crud->insert($arrayDados);  
        
        return $retorno;
    }
    
    public function apaga($dados)
    {
        $arrayCond = array('cpf=' => $_POST['cpf'], 'numero=' => $_POST['numero']);  
        $retorno   = $this->crud->delete($arrayCond);  
        
        return $retorno;
    }
    
}

?>