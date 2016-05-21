<?php
require_once("CRUDGenerico.class.php");

//$crud = new CRUDGenerico();

Class pedido{
    
    private $crud;
    
    public function pedido()
    {
        $this->crud = CRUDGenerico::getInstance('pedidos');         
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
        
        $sql        = "Select * From pedidos $where";  
        
        $dados      = $this->crud->getSQLGeneric($sql, $arrayParam, "");  
        //$dados      = CRUDGenerico::getSQLGeneric($sql, $arrayParam, FALSE);
        
        return $dados;
        
    }
    
    public function cadastro($dados)
    {
        $arrayDados = array('cpf' => $_POST['cpf_pedido'], 'data' => $_POST['data_pedido'], 'situacao' => $_POST['situacao_pedido'] );  
        $retorno    = $this->crud->insert($arrayDados);  
        
        return $retorno;
    }
    
	public function cadastroCallBack($dados)
    {
        $arrayDados = array('cpf' => $_POST['cpf_pedido'], 'data' => $_POST['data_pedido'], 'situacao' => $_POST['situacao_pedido'] );  
        $retorno    = $this->crud->insert($arrayDados); 

        if($retorno){
			$sql        = "Select Max(numero) As numero From pedidos";  
        
			$num_pedido = $this->crud->getSQLGeneric($sql, "", "true");
			
			return $num_pedido;
			
		}else{
			return "";
		}
    }
    
}

?>