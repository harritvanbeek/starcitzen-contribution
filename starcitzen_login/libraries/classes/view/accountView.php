<?php 
namespace classes\view;
defined('_BOANN') or header("Location:{$_SERVER["REQUEST_SCHEME"]}://{$_SERVER["SERVER_NAME"]}");

class accountView{
    private     $_DB        =   NULL,
                $_CONFIG    =   NULL,
                $_SESSION   =   NULL; 

    public function __construct(){
        $this->_DB          = NEW \classes\core\db;                                 
        $this->_CONFIG      = NEW \classes\core\config;                                         
        $this->_SESSION     = NEW \classes\core\session;  
    }

    public function premissions($uuid = ""){
        $this->premission = self::me($uuid)->premissions;
        switch($this->premission){
            case 1200 :
                return "admin";
            break;

            default:
                return "user";
            break;
        }
    }

    public function users(){
        $this->select   = "
                            `uuid`, 
                            `username`, 
                            `email`, 
                            `bank`,
                            `contribution`,
                            `premissions`
                            ";
        $this->query    = "SELECT $this->select FROM `users` ";
        $this->return   =   $this->_DB->getAll($this->query);
        return $this->return;
    }

    public function me($uuid = ""){
        $this->array  = ["userid" => !empty($uuid) ? $uuid : $this->_SESSION->get($this->_CONFIG->get("boann/user"))];
        $this->query  = "SELECT `uuid`, `username`, `email`, `bank`, `contribution`, `premissions` FROM `users` WHERE `uuid` = :userid ";
        $this->return   =   $this->_DB->get($this->query, $this->array);
        return $this->return;
    }

    public function updateContribution($data = ""){
        $this->array  = [                            
                            "uuid"          =>  "{$this->_SESSION->get($this->_CONFIG->get("boann/user"))}",
                            "contribution"  =>  "{$data}",
                        ];
        $this->query    = "UPDATE `users` SET `contribution` = :contribution WHERE `uuid` = :uuid ";
        $this->return   =   $this->_DB->action($this->query, $this->array);
        return $this->return;    
    }

    public function updateUserAdmin($data = []){
        $this->query = "UPDATE `users`
                            SET 
                                `username`      = :username,
                                `email`         = :email,
                                `premissions`   = :premission

                            WHERE `uuid` = :uuid
                        ";
        $this->return   =   $this->_DB->action($this->query, $data);
        return $this->return;
    }

    public function updateUsername($data = []){
        $this->query    = "UPDATE `users` SET `username` = :username WHERE `uuid` = :uuid ";
        $this->return   =   $this->_DB->action($this->query, $data);
        return $this->return;
    }

    public function updatePassword($data = []){
        $this->query = "UPDATE `users` SET `password` = :password WHERE `uuid` = :uuid";
        $this->return   =   $this->_DB->action($this->query, $data);
        return $this->return;
    }

    public function updateEmail($data = []){
        $this->query = "UPDATE `users` SET `email` = :email WHERE `uuid` = :uuid";
        $this->return   =   $this->_DB->action($this->query, $data);
        return $this->return;
    }

    public function updateBank($data = []){
        $this->query = "UPDATE `users` SET `bank` = :bank WHERE `uuid` = :uuid";
        $this->return   =   $this->_DB->action($this->query, $data);
        return $this->return;
    }
}