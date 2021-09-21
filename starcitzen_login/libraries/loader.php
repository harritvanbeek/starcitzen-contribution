<?php 
defined('_BOANN') or header("Location:{$_SERVER["REQUEST_SCHEME"]}://{$_SERVER["SERVER_NAME"]}");

spl_autoload_register(function ($class_name) {
    $classes_name = str_replace("\\", DIRECTORY_SEPARATOR, $class_name);
    if(file_exists(BOANN_LIBRARIES.DIRECTORY_SEPARATOR.$classes_name.".php")){
        require_once BOANN_LIBRARIES.DIRECTORY_SEPARATOR.$classes_name.".php";      
    }else{
       //do somting else       
    }
});