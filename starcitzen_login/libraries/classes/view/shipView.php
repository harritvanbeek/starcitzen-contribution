<?php 
namespace classes\view;
defined('_BOANN') or header("Location:{$_SERVER["REQUEST_SCHEME"]}://{$_SERVER["SERVER_NAME"]}");

class shipView{

    private     $_DB        =   NULL,
                $_CONFIG    =   NULL,
                $_SESSION   =   NULL; 
    
    public function __construct(){
        $this->_DB          = NEW \classes\core\db;                                 
        $this->_CONFIG      = NEW \classes\core\config;                                         
        $this->_SESSION     = NEW \classes\core\session;   
    }

    public function pledgeUri($data = ""){
        return "https://robertsspaceindustries.com".parse_url($data)["path"]."#buying-options";
    }

    public function shipDetails($uuid){
        $this->query =  "SELECT * FROM `import_ships` WHERE `ship_uuid` = '{$uuid}'";
        return $this->_DB->get($this->query);
    }

    public function catalogus(){
        $this->query =  "SELECT * FROM `import_ships`";
        return $this->_DB->getAll($this->query);
    }

    public function searchShip($data){
        $this->query =  "SELECT `ship_name` FROM `import_ships` WHERE `ship_name` LIKE '%{$data}%' ";
        return $this->_DB->getAll($this->query);
    }

    public function delete_DonadedShips($data){
        $this->array =  ["donateuuid" => "{$data}"];
        $this->query = "DELETE FROM `donate_ships` WHERE `donateuuid` = :donateuuid ";
        $this->return   =   $this->_DB->action($this->query, $this->array);
        return $this->return;
    }

    public function get_DonadedShips($data){
        $this->array    =   ["shipuuid" => "{$data}"]; 
        $this->select   =   "
                            `donate_ships`.`donateuuid`,
                            `donate_ships`.`shipuuid`,
                            `users`.`username`,
                            `donate_ships`.`useruuid`,
                            `donate_ships`.`postdate`,
                            `donate_ships`.`donate`
                            ";

        $this->query    =   "SELECT $this->select 
                                FROM `donate_ships` 
                                
                                LEFT JOIN `users` 
                                ON `users`.`uuid` = `donate_ships`.`useruuid`

                                WHERE `donate_ships`.`shipuuid` = :shipuuid ";
        $this->return   =   $this->_DB->getAll($this->query, $this->array);
        return $this->return;
    }

    public function donate_ships($array = []){
        $this->query    =   "INSERT INTO `donate_ships` (`donateuuid`, `shipuuid`, `useruuid`, `donate`, `postdate`) 
                                VALUES(:donateuuid, :shipuuid, :useruuid, :donate, :postdate )
                            ";
        $this->return   =   $this->_DB->action($this->query, $array);
        return $this->return;
    }

    public function set_ShipsBuyit($shipuuid, $buyit){
        $this->array = [
            "shipuuid" => $shipuuid,
            "buyit"     => $buyit,
        ];

        $this->query    = "UPDATE `ships` SET `buyit` = :buyit WHERE `saveshipuuid` = :shipuuid ";
        $this->return   =   $this->_DB->action($this->query, $this->array);
        return $this->return;
    }

    public function trashship($data){
        $this->array  = ["shipuuid" => "{$data}"];
        $this->query  = "DELETE FROM `ships` WHERE `saveshipuuid` = :shipuuid";
        $this->return   =   $this->_DB->action($this->query, $this->array);
        return $this->return;
    }

    public function exist_ShipsDeposit($shipuuid){
        $this->array = ["shipuuid" => $shipuuid];
        $this->query    = "SELECT  COUNT(`depostit`) AS exist FROM `ships` WHERE `saveshipuuid` = :shipuuid AND `depostit` > 0 ";
        $this->return   =   $this->_DB->get($this->query, $this->array);
        return $this->return->exist;
    }

    public function set_ShipsDeposit($shipuuid, $depostit){
        $this->array = [
            "shipuuid" => $shipuuid,
            "depostit" => $depostit,
        ];

        $this->query    = "UPDATE `ships` SET `depostit` = :depostit WHERE `saveshipuuid` = :shipuuid ";
        $this->return   =   $this->_DB->action($this->query, $this->array);
        return $this->return;
    }

    public function get_ShipsDeposit(){
        $this->select   =   "
                            `ships`.`shipuuid`,
                            `ships`.`useruuid`,
                            `donate_ships`.`donateuuid`,
                            `ships`.`name`,
                            `ships`.`price`,
                            `ships`.`location`,
                            `users`.`username`,
                            sum(`donate_ships`.`donate`) as `donate`
                            ";
        
        $this->query    =   "SELECT * 
                                FROM `ships`
                                
                                LEFT JOIN `import_ships`
                                ON `ships`.`ship_uuid` = `import_ships`.`ship_uuid`

                                LEFT JOIN `users` 
                                ON `users`.`uuid` = `ships`.`useruuid`

                                LEFT JOIN `donate_ships`
                                ON `ships`.`ship_uuid` = `donate_ships`.`shipuuid`

                                WHERE `ships`.`depostit` > 0 
                            ";
        $this->return   =   $this->_DB->getall($this->query);
        return $this->return;
    }

    public function getmyship(){
        $this->array    =   [
            "useruuid" => "{$this->_SESSION->get($this->_CONFIG->get("boann/user"))}",            
        ]; 
        $this->query    =   "SELECT * 
                                FROM `ships` 
                                    LEFT JOIN `import_ships`
                                    ON `ships`.`ship_uuid` = `import_ships`.`ship_uuid`
                                WHERE `ships`.`useruuid` = :useruuid AND `buyit` > 0 ";
        $this->return   =   $this->_DB->getall($this->query, $this->array);
        return $this->return;
    }

    public function getship(){
        $this->array    =   [
            "useruuid" => "{$this->_SESSION->get($this->_CONFIG->get("boann/user"))}",            
        ]; 
        $this->query    =   "SELECT * 
                                FROM `ships` 
                                    LEFT JOIN `import_ships`
                                    ON `ships`.`ship_uuid` = `import_ships`.`ship_uuid`

                                WHERE `ships`.`useruuid` = :useruuid AND `buyit` < 1 ";
        $this->return   =   $this->_DB->getall($this->query, $this->array);
        return $this->return;
    }

    public function set_ships($data = []){
        $this->query = "INSERT INTO `ships` (`saveshipuuid`, `useruuid`, `ship_uuid`, `postdate`) 
                            VALUES (:saveshipuuid, :useruuid, :ship_uuid, :postdate)";
        $this->return   =   $this->_DB->action($this->query, $data);
        return $this->return;
    }
        
}