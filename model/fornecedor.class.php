<?php
require_once("CRUDGenerico.class.php");

//$crud = new CRUDGenerico();

Class fornecedor{
    
    private $crud;
    
    public function fornecedor()
    {
        $this->crud = CRUDGenerico::getInstance('fornecedores');         
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
        
        $sql        = "Select * From fornecedores $where";  
        
        $dados      = $this->crud->getSQLGeneric($sql, $arrayParam, "");  
        //$dados      = CRUDGenerico::getSQLGeneric($sql, $arrayParam, FALSE);
        
        return $dados;
        
    }
    
    public function cadastro($dados)
    {
        $arrayDados = array('cnpj' => $_POST['cnpj'], 'endereco' => $_POST['endereco_fornecedor'], 'nome' => $_POST['nome_fornecedor'] );  
        $retorno    = $this->crud->insert($arrayDados);  
        
        return $retorno;
    }
    
    public function apaga($dados)
    {
        $arrayCond = array('cnpj=' => $_POST['cnpj']);  
        $retorno   = $this->crud->delete($arrayCond);  
        
        return $retorno;
    }
    
}

?>