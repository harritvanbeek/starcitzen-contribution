<?php 
namespace classes\view;
defined('_BOANN') or header("Location:{$_SERVER["REQUEST_SCHEME"]}://{$_SERVER["SERVER_NAME"]}");

class loginView{
    private     $_DB        =   NULL,
                $_CONFIG    =   NULL,
                $_SESSION   =   NULL; 
    
    public function __construct(){
        $this->_DB          = NEW \classes\core\db;                                 
        $this->_CONFIG      = NEW \classes\core\config;                                         
        $this->_SESSION     = NEW \classes\core\session;                                            
    }
    
    public function register($data = []){
        $this->query    =   "INSERT INTO `users` (`uuid`, `username`, `email`, `password`) 
                                VALUES(:uuid, :username, :email, :password)";
        $this->return   =   $this->_DB->action($this->query, $data);
        return $this->return;
    }

    public function SetPassword($data = ''){
        $options = ['cost' => 12];
        return password_hash($data, PASSWORD_BCRYPT, $options);
    }

    public function userData($data){
        $this->array    =   ["username" => "{$data}"];   
        $this->query    =   "SELECT `uuid` FROM `users` WHERE `username` = :username ";
        $this->return   =   $this->_DB->get($this->query, $this->array);
        return $this->return;
    }

    public function emailExist($data){
        $this->array    =   ["email" => "{$data}"];   
        $this->query    =   "SELECT COUNT(`email`) AS `exist` FROM `users` WHERE `email` = :email ";
        $this->return   =   $this->_DB->get($this->query, $this->array);
        return $this->return->exist;
    }

    public function userExist($data){
        $this->array    =   ["username" => "{$data}"];   
        $this->query    =   "SELECT COUNT(`username`) AS `exist` FROM `users` WHERE `username` = :username ";
        $this->return   =   $this->_DB->get($this->query, $this->array);
        return $this->return->exist;
    }

    public function passwordExist($username = "", $password = ""){
        return self::_chekUserPasswordexist($username, $password);
    }


    protected function _chekUserPasswordexist($username = "", $password = ""){
        $this->array    =   ["username" => "{$username}"];
        $this->query    =   "SELECT `password` FROM `users` WHERE `username` = :username ";
        $this->data   =   $this->_DB->get($this->query, $this->array);
        return password_verify($password, $this->data->password);
    }

}