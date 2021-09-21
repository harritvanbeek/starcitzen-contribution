<?php
namespace classes\core;
defined('_BOANN') or header("Location:{$_SERVER["REQUEST_SCHEME"]}://{$_SERVER["SERVER_NAME"]}");
class input{

	public static function exist($type = 'post'){
		switch($type){
			case "file" :
				if(!empty($_FILES) ){
					return true;					
				} else {
					return false;					
				}
			break;

			case "post" :
				return (!empty($_POST)) ? true : false;
			break;

			case "get" :
				return (!empty($_GET)) ? true : false;
			break;

			default:
				return false;
			break;
		}
	}

	public static function get($item = null){
		if(isset($_POST[$item])){
			return $_POST[$item];
		}else if(isset($_GET[$item])){
			return $_GET[$item];
		}else if(isset($_FILES[$item])){
			return $_FILES[$item];
		}
		return "";
	}

}