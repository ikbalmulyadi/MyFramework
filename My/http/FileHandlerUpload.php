<?php

namespace lib\http;

class FileHandlerUpload{
    private $file;
    public $name,
    $size,
    $mimeType,
    $extension;
    private $safeMode = 'on';
    function __construct($file){
        $ext = explode('.',$file['name']);
        $this->file = $file;
        $this->name = $file['name'];
        $this->size = $file['size'];
        $this->mimeType = $file['type'];
        $this->extension = end($ext);
        
    }
    function __toString(){
        return $this->file['tmp'];   
    }
    function save($path = '/'){
        if($this->saveMode == 'on'){
            move_uploaded_file($this->file['tmp'],"$path");
        }
        $this->saveMode ='off';
    }
    
    function saveAs($path = '/',$filename){
        if($this->saveMode == 'on'){
            move_uploaded_file($this->file['tmp'],"$path");
        }
        $this->saveMode ='off';
    }
    // function 

}