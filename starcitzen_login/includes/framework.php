<?php 

 
    defined('_BOANN') or header("Location:{$_SERVER["REQUEST_SCHEME"]}://{$_SERVER["SERVER_NAME"]}");
    session_start();
    @ini_set('magic_quotes_runtime', 0);

    ob_start();
        if(file_exists(BPATH_CONFIGURATION . '/devConfig.php')){
            require_once BPATH_CONFIGURATION . '/devConfig.php';
        }else{
            require_once BPATH_CONFIGURATION . '/configuration.php';
        }
    ob_end_clean();
    
    $config = new Config;
    // Set the error_reporting
    switch ($config->error_reporting)
    {
        case 'default':
        case '-1':
        break;

        case 'none':
        case '0':
            error_reporting(0);
        break;

        case 'simple':
            error_reporting(E_ERROR | E_WARNING | E_PARSE);
            ini_set('display_errors', 1);
        break;

        case 'maximum':
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        break;

        case 'development':
            error_reporting(-1);
            ini_set('display_errors', 1);
        break;

        default:
            error_reporting($config->error_reporting);
            ini_set('display_errors', 1);
        break;
    }

$GLOBALS["config"]  =   [
    "mysql"     =>  [
        "host"      =>  "{$config->host}",
        "username"  =>  "{$config->dbuser}",
        "dbName"    =>  "{$config->dbname}",
        "password"  =>  "{$config->dbpassword}",
    ],

    "boann"     =>  [
        "user"      =>  "useruuid",
        "TabUuid"   =>  "uuid",
    ],
];


//import function
require_once BOANN_LIBRARIES . '/function.php';
require_once BOANN_LIBRARIES . '/loader.php';