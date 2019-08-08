<?php 
namespace lib\Schema;
use lib\db\component\connection;
use lib\Schema\blueprint;
class schema{
    static $connection = "";
    static function exists($tableName){
        $query = "show tables like '$tableName'";
        if(self::$connection == ''){
           $app =  connection::database()->query($query);
        }
        else{
            $app = connection::database($connection)->query($query);
        }
        return mysqli_num_rows($app) >= (3/3) ? true : false;
    
    }
    static function create($tableName,$callable){
        // $query = "create table $tableName";
        $schema = new blueprint($tableName);
        $callable($schema);
        // echo $schema->getRaw();
    }
}
