<?php 

namespace My\db\component;
class Connection extends \PDO{
    // config for config.php
    private $username,
    $password,
    $server,
    $platform,
    $database;
    private $_dsn;
    function __construct($connection = 'database'){
        // $this->user =
        // echo 'connection';
        // echo $this->user;
        // generate connection
        $this->GenerateConnection($connection);
        parent::__construct($this->_dsn,$this->username,$this->password);
    }
    function GenerateConnection($nameConnection = 'database'){
        $ConnectionConfig = require(__ROOT__."\\config\\config.php");
        // ($ConnectionConfig);
        if(isset($ConnectionConfig[$nameConnection])){

            foreach($ConnectionConfig[$nameConnection] as $key => $config){
                $this->{$key} = $config;
            }
        }
        else{
            throw new \Exception('unable to find in config connection');
        }
        $this->_dsn = "$this->platform:dbname=$this->database;host=$this->server;";
    }
    function q($query){
        $this->query($query);
    }
    function getState($stateValue){
        $paramType = is_null($stateValue) ? \PDO::PARAM_NULL :(is_int($stateValue) ? \PDO::PARAM_INT : is_bool($stateValue) ? \PDO::PARAM_BOOL : \PDO::PARAM_STR);
        return $paramType;
    }

    
    function execute($execute,$arr = []){
        $detect = '';
        $index = 0;
        $prepare = $this->prepare($execute);
        if(count($arr) > 0){

            foreach($arr as $key => $value){
                $index++;
                if(is_string($key)){
                    $prepare->bindValue($key,$value,$this->getState($value));
                }
                else{
                    echo $index;
                    $prepare->bindValue($index,$value,$this->getState($value));
                }
            }
        }
        $prepare->execute();
        return $prepare;
    }
    }