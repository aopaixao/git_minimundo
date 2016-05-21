<?php
function __autoload($className)
{
	include_once("models/$className.php");	
}

$users=new User("your_host","your_user","your_password","your_database");

if(!isset($_POST['action'])) {
	print json_encode(0);
	return;
}

switch($_POST['action']) {
	case 'get_users':
		print $users->getUsers();		
	break;
	
	case 'add_user':
		$user = new stdClass;
		$user = json_decode($_POST['user']);
		print $users->add($user);		
	break;
	
	case 'delete_user':
		$user = new stdClass;
		$user = json_decode($_POST['user']);
		print $users->delete($user);		
	break;
	
	case 'update_field_data':
		$user = new stdClass;
		$user = json_decode($_POST['user']);
		print $users->updateValue($user);				
	break;
}

exit();

/*
 <?php require_once "Conexao.class.php";  
 require_once "Crud.class.php"; 

 // Consumindo m�todos do CRUD gen�rico 
 
 // Atribui uma conex�o PDO   
 $pdo = Conexao::getInstance();  
 
 // Atribui uma inst�ncia da classe Crud, passando como par�metro a conex�o PDO e o nome da tabela  
 //passa para o CR
 $crud = Crud::getInstance($pdo, 'TAB_USUARIO');  
 
 // Inseri os dados do usu�rio
 $arrayUser = array('nome' => 'Jo�o', 'email' => 'joao@gmail.com', 'senha' => base64_encode('123456'), 'privilegio' => 'A');  
 $retorno   = $crud->insert($arrayUser);  
 
 // Editar os dados do usuario com id 1 
 $arrayUser = array('nome' => 'Jo�o da Silva', 'email' => 'joao@gmail.com.br', 'senha' => base64_encode('654321'), 'privilegio' => 'A');  
 $arrayCond = array('id=' => 1);  
 $retorno   = $crud->update($arrayUser, $arrayCond);  
 
 // Exclui o registro do usu�rio com id 1 
 $arrayCond = array('id=' => 1);  
 $retorno   = $crud->delete($arrayCond);  
 
 // Consulta os dados do usu�rio com id 1 e privilegio A 
 $sql        = "SELECT nome, email, privilegio FROM TAB_USUARIO WHERE id = ? AND privilegio = ?";  
 $arrayParam = array(1, 'A');  
 $dados      = $crud->getSQLGeneric($sql, $arrayParam, FALSE);  

*/

?>