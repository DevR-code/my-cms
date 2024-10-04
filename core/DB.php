<?php
namespace Core;

use \PDO;
use \Exception;
use Core\{Config, H};

class DB {
    protected $_dbHandler, $_results, $_lastInsertId, $_rowCount = 0, $_fetchType = PDO::FETCH_OBJ, $_class, $_error = false;
    protected static $_db;

    public function __construct(){
        $host = Config::get('db_host');
        $name = Config::get('db_name');
        $user = Config::get('db_user');
        $pass = Config::get('db_password');
        $options = [
            PDO::ATTR_EMULATE_PREPARES => false,  //
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ];

        echo "ask $name";
        //connect
        try{
            $this->_dbHandler = new PDO("mysql:host={$host};dbname={$name}", $user, $pass, $options); //instantiate a new PDP class
        } catch (Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    public static function getInstance(){      //providing singleton method  /pattern/
        if(!self::$_db){
            self::$_db = new DB;    //or DB
        }
        return self::$_db;
    }
}










//singleton pattern:there wont be more that one db obj instanciated.