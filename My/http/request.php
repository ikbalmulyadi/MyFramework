<?php
namespace My\http;
use My\collection\Collection;
use My\http\session;
use My\http\FileHandlerUpload as UploadFile;
class request extends collection{
    private $session;
    private $fileInfo = [];
    static function getMethod(){
        return $_SERVER['REQUEST_METHOD'];
    }
    function __construct(){
        $this->collection_store = $_POST;
        // $this->fileInfo = [];
        if(isset($_FILES[0]['tmp_name'])){
            // check if 
            foreach($_FILES as $key => $log){

                $this->collection_store[$key] = new UploadFile($log);

            }
        }
        $this->session = new session;
    }
    function method(){
        return $_SERVER['REQUEST_METHOD'];
    }
    function _save(){
        if(count($_FILES) > 0){
            var_dump($_FILES);
        }
    }
    function session(){
        return $this->session;
    }
}