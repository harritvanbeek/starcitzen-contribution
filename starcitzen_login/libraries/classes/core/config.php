<?php 
namespace classes\core;

defined('_BOANN') or header("Location:{$_SERVER["REQUEST_SCHEME"]}://{$_SERVER["SERVER_NAME"]}");

class config {

	public static function get($path = []){
		if($path){
			$config = $GLOBALS["config"];
			$path 	= explode("/", $path);

			foreach($path as $bit){
				if(isset($config[$bit])){
					$config = $config[$bit];
				}else{
					return "value is not extist";
				}
			}
			return $config;
		}
		return false;
	}
}