<?php
require_once("CRUDGenerico.class.php");

//$crud = new CRUDGenerico();

Class telFornecedor{
    
    private $crud;
    
    public function telFornecedor()
    {
        $this->crud = CRUDGenerico::getInstance('telefones_fornecedores');         
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
        
        $sql        = "Select * From telefones_fornecedores $where";  
        
        $dados      = $this->crud->getSQLGeneric($sql, $arrayParam, "");  
        //$dados      = CRUDGenerico::getSQLGeneric($sql, $arrayParam, FALSE);
        
        return $dados;
        
    }
    
    public function cadastro($dados)
    {
        $arrayDados = array('cnpj' => $_POST['pfk_cnpj'], 'numero' => $_POST['numero_tel_fornecedor'] );  
        $retorno    = $this->crud->insert($arrayDados);  
        
        return $retorno;
    }
    
    public function apaga($dados)
    {
        $arrayCond = array('cnpj=' => $_POST['cnpj'], 'numero=' => $_POST['numero']);  
        $retorno   = $this->crud->delete($arrayCond);  
        
        return $retorno;
    }
    
}

?>