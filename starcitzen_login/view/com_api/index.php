<?php 
    define('_BOANN', 1);
    require_once dirname(dirname(dirname(__file__))).'/libraries/import.php';

    $_POST          =   json_decode(file_get_contents("php://input"), true)["0"];
    $action         =   !empty($_GET["action"]) ? $_GET["action"] : null;

    $input      =   NEW \classes\core\input;
    $setting    =   NEW \classes\core\settings;
    $starcitzen =   NEW \api\starcitzen_api;

    switch($action){
        case "set_ship" :
            if($input->exist()){
                $ship_uuid  =   !empty($input->get("data")["ship_uuid"])    ? $input->get("data")["ship_uuid"]              :  null;
                $price      =   !empty($input->get("data")["price"])        ? replace_money($input->get("data")["price"])   :  null;
                $location   =   !empty($input->get("data")["location"])     ? $input->get("data")["location"]               :  null;
                
                //10for10
                
                $updateArray    =   [
                    "ship_uuid" =>  "{$ship_uuid}",
                    "price"     =>  "{$price}",
                    "location"  =>  "{$location}",
                ];
                
                debug($starcitzen->setShip($updateArray));

            }
        break;
        
        case "get_ships" :
                echo json_encode($starcitzen->get_ships());
        break;

        case "import_ships" :
            $ships  =   json_decode($starcitzen->ships())->data;

            foreach($ships as $ship){
                if($ship->media["0"]->source_name){
                    $shipImg    =   parse_url($ship->media["0"]->images->hub_large);
                    $img        =   !empty($shipImg["host"]) ? $ship->media["0"]->images->hub_large : "https://robertsspaceindustries.com".$ship->media["0"]->images->hub_large ;
                    
                    $dataArray  =   [
                        "ship_uuid"    =>  "{$setting->MakeUuid()}",
                        "source_name"  =>  escape("{$ship->media["0"]->source_name}"),
                        "ship_name"    =>  escape("{$ship->name}"),
                        "ship_img"     =>  "{$img}",
                        "ship_json"    =>  json_encode($ship),
                    ];
                    
                    if($starcitzen->import($dataArray) > 0){
                        $postData[]    =   [
                            "data"          =>   "success",
                            "dataContent"   =>   "{$ship->name} imported!",
                        ];
                    }else{
                        $postData[]    =   [
                            "data"          =>   "error",
                            "dataContent"   =>   "{$ship->name} not imported!",
                        ];
                    };
                }                
            }
            
            echo json_encode($postData);

        break;

        case "get_members" :
            $members    = json_decode($starcitzen->organization_members())->data;
            foreach($members as $member){
                $meberArray[]   =   [
                    "display"   =>  "{$member->display}",
                    "image"     =>  "{$member->image}",
                    "rank"      =>  "{$member->rank}",
                    "roles"     =>  implode(",", $member->roles),
                    "stars"     =>  $starcitzen->rating($member->stars),
                ];
            }
            echo json_encode($meberArray); 
        break;

        case "get_orginisation" :
            $data   = json_decode($starcitzen->organization())->data;
            $array  =   [
                "banner"    => "{$data->banner}",
                "logo"      => "{$data->logo}",
                "members"   => "{$data->members}",
                "sid"       => "{$data->sid}",
                "name"      => "{$data->name}",
                "headline"  => "{$data->headline->html}",
                "primary"   => "{$data->headline->html}",
            ];
            echo json_encode($array);           
        break;
    }
    