<?php 
    defined('_BOANN') or header("Location:{$_SERVER["REQUEST_SCHEME"]}://{$_SERVER["SERVER_NAME"]}");
    define('BPATH_BASE', DIRNAME(__DIR__));
    require_once BPATH_BASE . '/includes/defines.php';
    require_once BPATH_BASE . '/includes/framework.php';