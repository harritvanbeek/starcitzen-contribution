<?php

defined('_BOANN') or header("Location:{$_SERVER["REQUEST_SCHEME"]}://{$_SERVER["SERVER_NAME"]}");

class Config{
        public
            $error_reporting    =   "none",
            //$error_reporting    =   "maximum",
            $host               =   "127.0.0.1",    
            $dbname             =   "starcitzen",    
            $dbuser             =   "root", 
            $dbpassword         =   "";          
}