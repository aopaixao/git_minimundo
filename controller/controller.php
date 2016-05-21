<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL); 


//Transformar a URL do Pacote em um array
$url_array = explode("/", $_SERVER['REQUEST_URI']);

$contArray = count($url_array);

//Verifica se o último elemento da URL é numérico, ou seja, se foi passado algum código para
// retornar uma listagem específica.
$id = $url_array[$contArray - 1];
if(is_numeric($id)){
    echo "Retornando os registros conforme ID:$id";
}else{

    //Pega a classe tratada
    $className = $url_array[$contArray - 2];
    $classFile = $url_array[$contArray - 2] .".class";
    
    //Pega o método solicitado
    $methName = $url_array[$contArray - 1];
    
    include_once("../model/$classFile.php");    

    $instClass = new $className();
    

    if($methName == 'lista'){
        $result = $instClass->$methName();
        echo json_encode($result);    
    }else if($methName == 'cadastro'){
        $result = $instClass->$methName($_POST);
        echo json_encode($result);    
    }else if($methName == 'apaga'){
        $result = $instClass->$methName($_POST);
        echo json_encode($result);    
    }else if($methName == 'cadastroCallBack'){
        $result = $instClass->$methName($_POST);
        echo json_encode($result);    
    }
    
    /**
    //var_dump($result);
    echo "<pre>";
    print_r($result);
    echo "</pre>";
    /**/
    
    
    
}



?>