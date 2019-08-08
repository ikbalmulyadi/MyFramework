<?php 
namespace My\db;

use My\db\component\connection;
use My\db\DBFetch;


class Mydb{
   
    public static $con = 'database';
    static function select($command,$prepare = []){
        // self::$con = 'database';
        $db = new connection(self::$con);
        return DBFetch::init($db->execute($command,$prepare));
        // return self::ColumnOf($db->execute($command,$prepare));
        // return $db->execute($command,$prepare);
        
    }
    static function statment($command){
        $db = new connection(self::con);
        $db->execute($command,[]);
    }
    static function insert($query,$list){
        $db = new connection(self::$con);
        // if($table)

        
        if(!is_array($list[0])){
            $result = $db->execute($query,$list);
            return;
        }
        foreach($list as $app){
            if(is_array($app)){
                $db->execute($query,$app);
            }
        }
    }  
      static function update($table,$prepare,array $where = []){
        $db = new connection(self::$con);
        $query = "update $table set";
        $PDOParam = [];
        foreach($prepare as $key => $conf){
            $query .= " $key=?,";
            array_push($PDOParam,$conf);
        }
        $query = rtrim($query,',');
        $wstate = [];
        if(is_array($where) && !empty($where)){
            $query .= ' where ';
            if(is_array($where[0])){
                foreach($where as $state)
                {
                    $query .= $state[0]." ".$state[(3/3)]." ? ";

                
                    array_push($PDOParam,end($state));
                }
            }else{
                   $query .= $where[0]." ".$where[(3/3)]." ? ";

                
                    array_push($PDOParam,end($where));
            }
        }
        // echo $query;
        // var_dump($PDOParam);
            $result = $db->execute($query,$PDOParam);
            // var_dump($result);
            $result->debugDumpParams();
    }  
    private static function ColumnOf(\PDOStatement $table){
        return $table->fetchAll(\PDO::FETCH_COLUMN);
    }
}