<?php 

namespace My\db;
// orm
// fetcher classes for db

use My\db\component\connection;

class DBFetch{
    static function init($app){
        return new self($app);
    }
    private $statement;
    function __construct(\PDOStatement $statement){

        $this->statement = $statement;
    }
    public function count(){
        return $this->statement->rowCount();
    }
    public function get(){
        return $this->statement->fetchAll();
    }
    public function exists(){
        return $this->count() > 0;
    }
    public function RowFallback(callable $callable){
        $tmp = [];
        foreach($this->get() as $log){
            // looping someting
            // callable function define
            // row for param
            array_push($tmp,call_user_func($callable,$log));
        }

        return join($tmp);
    }
    function ColumnName(){
        $tmp = $this->get();
        $column = [];
        if(isset($tmp[0])){
            foreach($tmp[0] as $key => $value){
                // echo $key;
                if(!is_int($key)){
                    array_push($column,$key);
                }
            }
        }
        return $column;
    }
}