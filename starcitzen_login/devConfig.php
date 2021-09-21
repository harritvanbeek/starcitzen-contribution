<?php

defined('_BOANN') or header("Location:{$_SERVER["REQUEST_SCHEME"]}://{$_SERVER["SERVER_NAME"]}");

class Config{
        public
            $error_reporting    =   "none",
            //$error_reporting    =   "maximum",
            $host               =   "",    
            $dbname             =   "",    
            $dbuser             =   "", 
            $dbpassword         =   "";          
}