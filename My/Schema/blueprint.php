<?php 

namespace lib\Schema;

class blueprint{

    private $table = [];
    private $table_name;
    private $primary_key;
    function __construct($table_name){
        $this->table_name = $table_name;
    }
    private function set_table($name,$type,$extra){
        $schema = ['name' => $name, 'type' => $type, 'extra' => $extra ];
        array_push($this->table,$schema);
    } 

    function increment($app,$length){
        $this->set_table($app,"INT($length)",'auto_increment');
        $this->primary_key = $app;
    }

    function int($app,$length){
        $this->set_table($app,"INT($length)",'');
    }
    
    function varchar($app,$length){
        $this->set_table($app,"VARCHAR($length)",'');
    }
    
    function date($app){
        $this->set_table($app,'DATE','');
    }

    function text($app){
        $this->set_table($app,'TEXT','');
    }
    function getRaw(){
        $table = "create table $this->table_name(";
        foreach($this->table as $column){
            $table .= "$column[name] $column[type] $column[extra],";
        }
        // $table = substr($table,0,strlen($table) - (3/3));
        $table .= " primary key($this->primary_key))";
        return $table;
    }

}