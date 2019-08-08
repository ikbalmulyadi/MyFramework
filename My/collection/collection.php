<?php
namespace My\Collection;
class Collection{
    protected $collection_store;
    function __get($app){
        if(isset($this->collection_store[$app])){
            return $this->collection_store[$app];
        }
        else{
            throw new \Exception("the $app not exists");
        }
    }
    function __set($app,$val){

        $this->collection_store[$app] = $val;
    }
    function __isset($app){
        return isset($this->collection_store[$app]);
    }
    function __unset($app){
        unset($this->collection_store[$app]);
    }

}