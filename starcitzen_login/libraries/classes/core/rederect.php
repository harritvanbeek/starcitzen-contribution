<?php
namespace classes\core;
defined('_BOANN') or header("Location:{$_SERVER["REQUEST_SCHEME"]}://{$_SERVER["SERVER_NAME"]}");

class rederect{

	public static function to($location = null){
		if($location){
			header("Location:{$location}");
			exit();
		}
	}
}