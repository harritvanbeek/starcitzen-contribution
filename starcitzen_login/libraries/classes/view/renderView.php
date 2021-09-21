<?php 
namespace classes\view;
defined('_BOANN') or header("Location:{$_SERVER["REQUEST_SCHEME"]}://{$_SERVER["SERVER_NAME"]}");

class renderView{

    private     $_DB        =   NULL,
                $_CONFIG    =   NULL,
                $_SESSION   =   NULL; 
    
    public function __construct(){
        $this->_DB          = NEW \classes\core\db;                                 
        $this->_CONFIG      = NEW \classes\core\config;                                         
        $this->_SESSION     = NEW \classes\core\session;   


        if(isset($_GET["logout"]) || !empty($_GET["logout"]) === true || $_GET["logout"] === "logout"){
            //chek session 
            if($this->_SESSION->exist($this->_CONFIG->get("boann/user"))){
                $this->_SESSION->delete($this->_CONFIG->get("boann/user"));
            }            
            header("Location:".SITE);
            die;
        }

    }
    
    public function getHtml(){}
    
    public function view(){
        return $this->_view();
    }

    private function _view(){
        if($this->_SESSION->exist($this->_CONFIG->get("boann/user"))){
               //$this->_SESSION->delete($this->_CONFIG->get("boann/user"));
               require_once "templates/index.php";  
        }else{
            require_once "view/com_login/login.php";
        }
    }
        
}