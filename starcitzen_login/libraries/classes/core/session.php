<?php
namespace classes\core;
defined('_BOANN') or header("Location:{$_SERVER["REQUEST_SCHEME"]}://{$_SERVER["SERVER_NAME"]}");
class session{
	public static function exist($name = null){
		return (isset($_SESSION[$name])) ? true : false;
	}

	public static function put($name = null, $value = null){
		return $_SESSION[$name] =$value;
	}

	public static function get($name = null){
		return $_SESSION[$name];
	}

	public static function delete($name = null){
		if(self::exist($name)) {
			unset($_SESSION[$name]);
		}
	}
}