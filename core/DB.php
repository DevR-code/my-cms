<?php
namespace Core;

use \PDO;
use \Exception;
use Core\{Config, H};

class DB {
    protected $_dbHandler, $_results, $_lastInsertId, $_rowCount = 0, $_fetchType = PDO::FETCH_OBJ, $_class, $_error = false;
    protected static $_db;
    protected $_stmt;

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

     public function execute($sql, $bind=[]){
            $this -> _result = null;
            $this -> _lastInsertId = null;
            $this -> _error = false;

            // $stmt = $this -> _dbHandler ->prepare($sql);
            $this ->_stmt = $this -> _dbHandler -> prepare($sql);
            if(!$this ->_stmt->execute($bind)){
            $this->_error = true;
            } else{
             $this ->_lastInsertId = $this ->_dbHandler -> lastInsertId();

            }
        $stmt = NULL;
        return $this;
    }

    public function query($sql, $bind=[]){      //bind set to default
            // $this -> _result = null;
            // $this -> _lastInsertId = null;
            // $this -> _error = false;
            $this->execute($sql, $bind);    //running execute   instead of repeating above four lines...
            //$stmt = $this -> _dbHandler ->prepare($sql);
            //if(!$stmt->execute($bind)){
            if(!$this->_error) {
            $this ->_rowCount =  $this ->_stmt -> rowCount();
            //$this ->_lastInsertId = $this ->_dbHandler -> lastInsertId();
            $this ->_results =  $this ->_stmt ->fetchAll($this ->_fetchType);
            }
            
        //$stmt = NULL;
        return $this;
    }

    public function insert($table, $values){
        $fields = [];
        $binds = [];
        foreach($values as $key => $value){
            $fields[] = $key;
            $binds[] = ":{$key}";
        }      //making prpared statements
        $fieldStr = implode('`, `', $fields);
        $bindStr = implode(', ', $binds);
        $sql = "INSERT INTO {$table} (`{$fieldStr}`) VALUES ({$bindStr})";
        $this->execute($sql, $values);
        return !$this->_error;
        // H::dnd($sql);
    }

    public function update($table, $values, $conditions){
        $binds = [];
        $valueStr = "";
        foreach($values as $field => $value){
            $valueStr .= ", `{$field}` = :{$field}";
            $binds[$field] = $value;
        }
        $valueStr = ltrim($valueStr, ', ');
        $sql = "UPDATE {$table} SET {$valueStr}";
        //$sql = "UPDATE {$table} SET title = :title, body = :body WHERE id = 12";


        if(!empty($conditions)){
            $conditionStr = " WHERE ";
            foreach($conditions as $field => $value) {
                $conditionStr .= "`{$field}` = :cond{$field} AND ";
                $binds['cond' .$field] = $value;
            }
            $conditionStr = rtrim($conditionStr, ' AND ');
            $sql .= $conditionStr;
           // H::dnd($binds);
           //H::dnd($conditionStr);

            echo $sql;
            
        }
            $this->execute($sql, $binds);
                return !$this->_error;

          //H::dnd($conditionStr);
    

    }

    public function getResults(){
        return $this->_results;

    }

    public function count(){
        return $this ->_rowCount;
    }
    public function lastInsertId(){
        return $this->_lastInsertId;
    }
}











//singleton pattern:there wont be more that one db obj instanciated.