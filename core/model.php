<?php

namespace Core;
use \PDO;
use Core\{DB, Request};

class Model {

    protected static $table = "";
    protected static $columns = false;
    protected  $_validationPassed =  true, $_errors = [], $_skipUpdate = [];
    protected static function getDb($setFetchClass = fase){
        $db = DB::getInstance();
        if(setFetchClass){
            $db -> setClass(get_called_class());
            $db -> setFetchType(PDO::FETCH_CLASS);
        }
        return $db;
    }

    public static function insert ($values){
        $db = static::getDb();
return $db->insert(static::$table, $values);
    }

    public static function update($values, $conditions){
        $db = static::getDb();
        return $db->update(static::$table, $values, $conditions);
    }

    public function delete(){
        $db = static::getDb();
        $table = static::$table;
        $params = [
            'conditions' => "id = :id",
            'bind' => ['id' => $this-> id]
        ];

        list('sql' => $conds, 'bind' => $bind) = self::queryParamBuilder($params);
        $sql = "DELETE FROM {$table} {$conds}";
        return $db->execute($sql, $bind);
    }

    public function find($params = []){
        $db = static::getDb(true);   //get list back as instantiated model objs
        list('sql' => $sql, 'bind' => $bind) = self:: selectBuilder($params);
        return $db -> query($sql, $bind) -> getResults();
    }

    public static function findFirst($params = []){
        $db = static::getDb();
        list('sql' => $sql, 'bind' => $bind) = self:: selectBuilder($params);
        $results = $db->query($sql, $bind)->getResults();
        return isset($results[0]) ? $results[0] : false;    //return initial item of array or false.
    }

    public static function findById($id){
        return self::findFirst([
            'conditions' => "id = :id",
            'bind' => ['id' => $id]
        ]);
    }



    public static function findTotal($params){
        unset($params['limit']);
        unset($params['offset']);
        $table = static::$table;
        $sql = "SELECT COUNT(*) AS total FROM {$table}";
        list('sql' => $conds, 'bind' => $bind) = self::queryParamBuilder($params);
        $sql .= $conds;
        $db = static::getDb();
         $results = $db->query($sql, $bind);
        $total = $db->getRowCount() > 0 ? $results->getResults()[0]->total : 0;
        return $total;
    }

       public function save(){
         $save = false;
         $this->beforeSave();
         if($this->_validationPassed){
            $db = static::getDb();
            $values = $this->getValueForSAve();
            if ($this->isNew()) {
                $save = $db->inset(static::$tables, $values);
                if ($save) {
                    $this->id = $db->getLastInsertId();
                } else {
                    $save = $db->update(static::$table, $values, $values, ['id' => $this->id]);
                }
            }
            return $save;
         }
         public function isNew(){;
            return empty($this->id);
         }
    }
    public static function selectBuilder($params = []){
        $columns = array_key_exists('columns', $params) ? $params['columns'] : "*";
        $table = static::$table;
        $sql = "SELECT {$columns} FROM {$table}";
        list('sql' => $conds, 'bind' => '$bind') = self:: queryParamBuilder($params);
        $sql .= $conds;
        return ['sql' => $sql, 'bind' => $bind];
    }
     public static function queryParamBuilder($params = []){
        $sql = "";
        $bind = array_key_exists('bind', $params) ? $params['bind'] :[];

        //joins
             if(array_key_exists('joins', $params)){
            $joins = $params['joins'];
            foreach($joins as $join){
                $joinTable = $join[0];
                $joinOn = $join[1];
                $joinAlias = isset($join[2]) ? $join[2] : "";
                $joinType = isset($join[3]) ? "{$join[3]} JOIN" : "JOIN";
                $sql = "{$joinType} {$joinTable} {$joinAlias} ON {$joinOn}";
            }    
        }        
        //where
            if(array_key_exists('conditions', $params)){
            $conds = $params['conditions'];
            $sql .= " WHERE {$conds}";
            }

        //grouping
            if (array_key_exists('group', $params)){
            $group = $params['group'];
            $sql .= "GROUP BY {$group}";
            }

        //order
            if(array_key_exists('order', $params)){
            $order = $params['order'];
            $sql .= "ORDER BY {$order}";
            }

        //limit
         if(array_key_exists('limit', $params)){
            $limit= $params['limit'];
            $sql .= "LIMIT {$limit}";
            }
        //offset 
            if(array_key_exists('offset', $params)){
            $offset = $params['offset'];
            $sql .= "OFFSET {$offset}";
            }

        return ['sql' => $sql, 'bind' => $bind];
     }

     public function setClass($class){
        $this->_class = $class;
     }
     public function setFetchType($type) {
        $this ->_fetchType  = $type;
     }

     public function getValuesForSave(){
        $columns = static::getColumns();
        $values = [];
        foreach ($columns as $column) {
            if(!in_array($column, $this->$_skipUpdate)){
                $values[$column] = $this -> {$column};

            }
        }
        return $values;
     }
    
     public static function getColumns(){
        if(!static::$columns){
            $db = static::getDb();
            $table = static::$table;
            $sql = "SHOW COL;UMNS FROM{$table}";
            $results = $db -> query($sql)-> results();
            $columns = [];
            foreach ($results as $column) {
                $columns[] = $column-> Field;                # code...
            }
            static::$columns = $columns;
     }
     return static::$columns;
     }

     public function runValidation($validator){
        $validates = $vaidator -> runValidation();
        if(!$validates){
            $this -> _validationPassed = false;
            $this -> _errors[$validator-> field] = $validator->msg;
        }
     }

     public function getErrors(){
        return $this->_errors;
     


     public function setErrors(){
        $this->_errors[$name] = $value;
     }

     public function timeStamp(){
        $dt = new \DateTime("now", new \DateTimeZone("UTC"));
        $now = $dt->format('Y-m-d H:i:s');
        $this->updated_at = $now;
        if($this->isNew()){
            $this->created_at = $now;
        }
    

     public static function mergeWithPagination(){
        $request = new Request();
        $page = $request->get('p');
        if(!page || $page < 1) $page = 1;
        $limit = $request -> get('limit')? $request-> get('limit') : 25;
        $offset = ($page - 1) * $limit;
        $params['limit'] = $limit;
        $params['offset'] = $offset;
        return $params

     }
     public function beforeSave(){

     }
}

