<?php 
namespace api;

defined('_BOANN') or header("Location:{$_SERVER["REQUEST_SCHEME"]}://{$_SERVER["SERVER_NAME"]}");

class starcitzen_api{
    private     $_DB        =   NULL,
                $_CONFIG    =   NULL,
                $_SESSION   =   NULL; 
    

    protected   $_apiKey  = SC_API,
                $_ORG     = SC_ORG;

    public function __construct(){
        $this->_DB          = NEW \classes\core\db;                                 
        $this->_CONFIG      = NEW \classes\core\config;                                         
        $this->_SESSION     = NEW \classes\core\session;                                            
    }

    public function setShip($data = []){
        $this->query  = "UPDATE `import_ships` 
                            SET 
                                `price`     = :price, 
                                `location`  = :location
                            WHERE `ship_uuid` = :ship_uuid 
                        ";
        return $this->_DB->action($this->query, $data);
    }

    public function get_ships(){
        $this->query = "SELECT * FROM `import_ships`";
        return $this->_DB->getAll($this->query);
    }

    public function update_import_ship($uuid = "", $array = []){
        $this->query  = "UPDATE `import_ships`
                            SET 
                                `source_name`   = '{$array["source_name"]}',                                
                                `ship_name`     = '{$array["ship_name"]}',                                
                                `ship_img`      = '{$array["ship_img"]}'                                                               

                            WHERE `ship_uuid` = '{$uuid}'
                        ";
        return $this->_DB->action($this->query);
    }

    public function import($array = []){
        //chek ship exist
        $this->array    =   ["ship_name" => "{$array['ship_name']}"];
        $this->query    =   "SELECT `ship_uuid`, COUNT(`ship_name`) AS `exist` FROM `import_ships` WHERE `ship_name` = :ship_name ";   
        if($this->_DB->get($this->query, $this->array)->exist > 0){
            $ship_uuid      =  $this->_DB->get($this->query, $this->array)->ship_uuid; 
            return self::update_import_ship($ship_uuid, $array);            
        }else{
            $this->query = "INSERT INTO `import_ships` 
                            (`ship_uuid`, `source_name`, `ship_name`, `ship_img`, `ship_json`) 
                            VALUES (:ship_uuid, :source_name, :ship_name, :ship_img, :ship_json)
                        ";
            return $this->_DB->action($this->query, $array);            
        };

    }

    public function get_imported_ships(){
        //WHERE `ship_uuid` = '001c8053-1f8c-40bc-87ed-a6bc6b7fb97e'
        $this->query = "SELECT * FROM `import_ships` WHERE `ship_uuid` = '00151d5c-4521-42c2-856f-3e933d78dd8f'";
        return $this->_DB->get($this->query);
    }

    public function ships(){
        return self::request("https://api.starcitizen-api.com/{$this->_apiKey}/v1/auto/ships/");
    }

    public function user($value){
        return self::request("https://api.starcitizen-api.com/{$this->_apiKey}/v1/live/user/{$value}");
    }

    public function organization(){
        return self::request("https://api.starcitizen-api.com/{$this->_apiKey}/v1/live/organization/{$this->_ORG}");
    }

    public function organization_members(){
        return self::request("https://api.starcitizen-api.com/{$this->_apiKey}/v1/live/organization_members/{$this->_ORG}");
    }

    public function organization_member_exist($value){
        $displaynames = json_decode(self::organization_members())->data;
        foreach($displaynames as $data){
            //debug($data);
            if($data->display === $value){
                $return = true;
            }                         
        }        
        return !empty($return) ? true : false;
    }


    public function rating($data){
        foreach (range(0, $data) as $number) {
            if($number > 0){
                $rating[] = '<span class="fa fa-star member__rating"></span>';            
            }else{
               $rating[] = null; 
            }
        }       
        return implode("", $rating);
    }

    protected function request($data){
        $this->curl = curl_init($data);
        curl_setopt($this->curl, CURLOPT_URL, $data);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);

        $return = curl_exec($this->curl);
        curl_close($this->curl);

        return $return;
    }
}