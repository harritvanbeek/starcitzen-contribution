<?php

    defined('_BOANN') or header("Location:{$_SERVER["REQUEST_SCHEME"]}://{$_SERVER["SERVER_NAME"]}");

    // Global definitions
    $parts = explode(DIRECTORY_SEPARATOR, BPATH_BASE);

    // Defines.
    define('DS',                  DIRECTORY_SEPARATOR);
    define('BOANN_ROOT',          implode(DS, $parts));
    define('BOANN_SITE',          BOANN_ROOT);
    define('USER_IP',             $_SERVER["REMOTE_ADDR"]);
    define('BOANN_LIBRARIES',     BOANN_ROOT . DS . 'libraries');
    define('BOANN_THEMES',        BPATH_BASE . DS . 'templates');
    define('BOANN_CACHE',         BPATH_BASE . DS . 'cache');
    define('BPATH_CONFIGURATION', BPATH_BASE . DS);
    define('SITE',                "{$_SERVER["REQUEST_SCHEME"]}://{$_SERVER["SERVER_NAME"]}/starcitzen_login");   
    define('ASSETS',              SITE."/assets");  
    define('THEMES',              SITE."/templates");   
    define('ADMIN_THEMES',        SITE."/templates");
    define('SC_API',              "W2qPiWJOao9ss0U51MtGKapPfQc4USFl");
    define('SC_ORG',              "BOANN");