<?php
require_once("CRUDGenerico.class.php");

//$crud = new CRUDGenerico();

Class cliente{
    
    private $crud;
    
    public function cliente()
    {
        $this->crud = CRUDGenerico::getInstance('clientes');         
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
        
        $sql        = "Select * From clientes $where";  
        
        $dados      = $this->crud->getSQLGeneric($sql, $arrayParam, "");  
        //$dados      = CRUDGenerico::getSQLGeneric($sql, $arrayParam, FALSE);
        
        return $dados;
        
    }
    
    public function cadastro($dados)
    {
        $arrayDados = array('cpf' => $_POST['cpf'], 'nome' => $_POST['nome_cliente'], 'email' => $_POST['email_cliente'], 'endereco' => $_POST['endereco_cliente'], 'cep' => $_POST['cep_cliente'], 'senha' => $_POST['senha_cliente'] );  
        $retorno    = $this->crud->insert($arrayDados);  
        
        return $retorno;
    }
    
    public function apaga($dados)
    {
        $arrayCond = array('cpf=' => $_POST['cpf']);  
        $retorno   = $this->crud->delete($arrayCond);  
        
        return $retorno;
    }
    
}

?>