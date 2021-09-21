<?php 
namespace classes\core;

defined('_BOANN') or header("Location:{$_SERVER["REQUEST_SCHEME"]}://{$_SERVER["SERVER_NAME"]}");

class settings {
	private $_DB 		=	NULL,
			$_SESSION 	=	NULL,
			$_language	=	NULL;
	
	public function __construct(){
		$this->_DB			= NEW \classes\core\db;	
		$this->_SESSION		= NEW \classes\core\session;	
	}

	public function get_settings($data = ''){
		$this->array 	=	["keys" => "{$data}"];
		$this->query 	=	"SELECT `params` FROM `settings` WHERE `keys` = :keys ";
		return $this->_DB->get($this->query, $this->array)->params;
	}

	public function post_settings($array = []){
		$this->query =	"INSERT INTO `settings` 
							(`keys`, `params`) VALUES(:keys, :params)
							ON DUPLICATE KEY UPDATE
							`params` = :params
						";
		return $this->_DB->action($this->query, $array);
	}

	public function MakeUuid(){
		return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
	        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
	        mt_rand( 0, 0xffff ),
	        mt_rand( 0, 0x0fff ) | 0x4000,
	        mt_rand( 0, 0x3fff ) | 0x8000,
	        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    	);
	}

	public function Code(){
		return sprintf( '%04x%04x%04x',
	        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    	);
	}
}