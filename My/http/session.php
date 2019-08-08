<?php 

namespace lib\http;
use lib\collection\Collection;
class session extends collection{
    static function set(&$app){
        return isset($app);
    }
    // private $instace;
    // private $collection_store;
    function __construct(){
        $this->collection_store = &$_SESSION;
    }
    // function __set($app,$value){
    //     $this->instace[$app] = $value;
    //     parent::__set($app,$value);
    // }
    function flush(){
        session_destroy();
        session_unset();
    }
    function delete($app){
        if(self::set($this->collection_store[$app])){
            unset($this->collection_store[$app]);
        }
        else{
            throw new \Exception("unable to find $app in session storage");
        }
    }
    function dump(){
        return $this->collection_store;
    }
}