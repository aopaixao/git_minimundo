<?php 
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL); 
 
 
/*  
* Constantes de parâmetros para configuração da conexão  
*/  
define('HOST', 'mysql.petamus.com.br');  
define('DBNAME', 'petamus_minimundo');  
define('CHARSET', 'utf8');  
define('USER', 'petamus_db_root');  
define('PASSWORD', 'my_password'); 

//mysql -u petamus_db_root -p -h mysql.petamus.com.br petamus_minimundo 
//petamus_db_root  - root_minimundo
//3nGpQPnhaA 

Class Conn {  

    /*  
    * Atributo estático para instância do PDO  
    */  
    private static $pdo;

    /*  
    * Escondendo o construtor da classe  
    */ 
    private function __construct() 
    {  
     //  
    } 

    /*  
    * Método estático para retornar uma conexão válida  
    * Verifica se já existe uma instância da conexão, caso não, configura uma nova conexão  
    */  
    public static function getInstance() 
    {  
        if (!isset(self::$pdo)) {  
            try {
                // assign PDO object to db variable
                $db = new PDO('mysql:host=mysql.petamus.com.br;dbname=petamus_minimundo;charset=utf8', 'petamus_db_root', '3nGpQPnhaA');
                $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            }
            catch (PDOException $e) {
                //Output error - would normally log this to error file rather than output to user.
                echo "Connection Error: " . $e->getMessage();
            }
            
            self::$pdo = $db;
        }
          
        return self::$pdo;  
    }
      
}

//Conn::getInstance();

?>
