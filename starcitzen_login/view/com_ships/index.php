<?php 
    define('_BOANN', 1);
    require_once dirname(dirname(dirname(__file__))).'/libraries/import.php';

    $_POST      =   json_decode(file_get_contents("php://input"), true)["0"];

    $action     =   !empty($_GET["action"]) ? $_GET["action"] : null;
    $input      =   NEW \classes\core\input;
    $session    =   NEW \classes\core\session;
    $setting    =   NEW \classes\core\settings;
    $_config    =   NEW \classes\core\config;
    
    $ship       =   NEW \classes\view\shipView;

    switch($action){
        case "bookmark" :
            if($input->exist()){
                $ship_uuid      =   !empty($input->get("data")) ? $input->get("data") : null;
                if($ship_uuid){
                    $array_data     =   [
                        "saveshipuuid"  =>  "{$setting->MakeUuid()}",
                        "useruuid"      =>  "{$session->get($_config->get("boann/user"))}",
                        "ship_uuid"     =>  "{$ship_uuid}",
                        "postdate"      =>  date("Y-m-d h:i:s", getdate()[0]),
                    ]; 

                    if( $ship->set_ships($array_data) > 0 ){
                        $dataArray  =   [
                            "data"          =>  "success",
                            "dataContent"   =>  "Je gegevens is bijgewerkt!",
                        ];
                    }else{
                        $dataArray  =   [
                            "data"          =>  "error",
                            "dataContent"   =>  "{$error[0]}",
                        ];
                    };

                    echo json_encode($dataArray);      
                };
            }
        break;

        case "shipImages" :
            $uuid       =   !empty($_GET["uuid"]) ? $_GET["uuid"] : null; 
            $ships      =   $ship->shipDetails($uuid);
            $shipData   =   json_decode($ships->ship_json)->media["0"]->images;

            echo json_encode($shipData);
        break;

        case "shipDetails" :
            $uuid       =   !empty($_GET["uuid"]) ? $_GET["uuid"] : null; 
            $ships      =   $ship->shipDetails($uuid);
            $shipData   =   json_decode($ships->ship_json);
            
            $data =   [
                "ship_uuid"             => "{$ships->ship_uuid}",
                "ship_name"             => "{$ships->ship_name}",
                "ship_img"              => "{$ships->ship_img}",
                "url"                   => "{$ship->pledgeUri($shipData->url)}",
                "ship_image_big"        => "{$ships->ship_img}",
                "manufacturer"          => "{$shipData->manufacturer->name}",
                "manufacturer_logo"     => "https://robertsspaceindustries.com/{$shipData->manufacturer->media['0']->images->avatar}",
                
                "production"            =>  [
                    "production_status"      =>  "{$shipData->production_status}",
                    "description"            =>  "{$shipData->description}",
                    "focus"                  =>  "Focus: {$shipData->focus}",
                ],

                "buy"           =>  [
                    "price"             => number_format("{$ships->price}"),
                    "location"          => "{$ships->location}",                
                ],

                "base"          =>  [
                    "length"            =>  explode(".", $shipData->length)[0]." m",
                    "height"            =>  explode(".", $shipData->height)[0]." m",
                    "cargo"             =>  "{$shipData->cargocapacity} SCU",
                    "beam"              =>  explode(".", $shipData->beam)[0]." m",
                    "mass"              =>  str_replace("00", "", number_format("{$shipData->mass}", 0))." t",
                    "type"              =>  "{$shipData->type}",
                    "size"              =>  "{$shipData->size}",
                    "price"             =>  number_format("{$shipData->price}"),
                    "time_modified"     =>  "{$shipData->time_modified}",
                ],

                "crew"          =>  [
                    "min_crew"          =>  "{$shipData->min_crew} persons",
                    "max_crew"          =>  "{$shipData->max_crew} persons",
                ],

                "speed"         =>  [
                    "scm_speed"         =>  "{$shipData->scm_speed}",
                    "afterburner_speed" =>  str_replace(",", ".", number_format("{$shipData->afterburner_speed}")),
                    "pitch_max"         =>  !empty("{$shipData->pitch_max}") ? "{$shipData->pitch_max}" : "N/A",
                    "yaw_max"           =>  !empty("{$shipData->yaw_max}") ? "{$shipData->yaw_max}" : "N/A",
                    "roll_max"          =>  !empty("{$shipData->roll_max}") ? "{$shipData->roll_max}" : "N/A",
                    "xaxis"             =>  !empty("{$shipData->xaxis_accelerationzaxis_acceleration}") ? "{$shipData->xaxis_accelerationzaxis_acceleration}" : "N/A",
                    "yaxis"             =>  !empty("{$shipData->yaxis_acceleration}") ? "{$shipData->yaxis_acceleration}" : "N/A",
                    "zaxis"             =>  !empty("{$shipData->zaxis_acceleration}") ? "{$shipData->zaxis_acceleration}" : "N/A",
                ],

                "compiled"      =>  [
                    "RSIAvionic"        =>  [
                        "computers"         =>  [
                            "type"              =>  "{$shipData->compiled->RSIAvionic->computers[0]->type}",
                            "mounts"            =>  "{$shipData->compiled->RSIAvionic->computers[0]->mounts}",
                            "quantity"          =>  "{$shipData->compiled->RSIAvionic->computers[0]->quantity}",
                            "component_size"    =>  "Size {$shipData->compiled->RSIAvionic->computers[0]->component_size} (2)",
                            "component_class"   =>  "{$shipData->compiled->RSIAvionic->computers[0]->component_class}",
                        ],

                        "radar"             =>  [
                            "type"              =>  "{$shipData->compiled->RSIAvionic->radar[0]->type}",
                            "mounts"            =>  "{$shipData->compiled->RSIAvionic->radar[0]->mounts}",
                            "quantity"          =>  "{$shipData->compiled->RSIAvionic->radar[0]->quantity}",
                            "component_size"    =>  "Size {$shipData->compiled->RSIAvionic->radar[0]->component_size} (2)",
                            "component_class"   =>  "{$shipData->compiled->RSIAvionic->radar[0]->component_class}",
                        ],
                    ],

                    "RSIModular"        =>  [

                    ],
                ],
            ];

            //$data[] = $shipData->compiled->RSIModular;
            echo json_encode($data);
            
        break;

        case "ShipCatalogus" :
            $ships = $ship->catalogus();
            foreach($ships as $shipsc){
                $shipData   =   json_decode($shipsc->ship_json);
                
                $DataArray[]  =   [
                    "ship_uuid"     => "{$shipsc->ship_uuid}",
                    "ship_name"     => "{$shipsc->ship_name}",
                    "ship_img"      => "{$shipsc->ship_img}",
                    "price"         => number_format("{$shipsc->price}", 2),
                    "location"      => "{$shipsc->location}",
                    "manufacturer"  => "{$shipData->manufacturer->code}",
                ];
            }
            echo json_encode($DataArray);
        break;

        case "searchShip" :
            $shipdata     =   !empty($_GET["data"]) ? escape($_GET["data"]) : null;
            echo json_encode( $ship ->searchShip($shipdata) );
        break;

        case "restore" :
            $uuid       =   !empty($input->get("data")["useruuid"]) ? $input->get("data")["useruuid"]   : null;
            $shipuuid   =   !empty($input->get("data")["shipuuid"]) ? $input->get("data")["shipuuid"]   : null;
            $buyit      =   !empty($input->get("data")["restore"])  ? false      : true;
            
            if($input->exist() > 0 and empty($error) === true){                
                if($ship->set_ShipsBuyit($shipuuid, $buyit) > 0){
                    $dataArray  =   [
                        "data"          =>  "success",
                        "dataContent"   =>  "Je gegevens is bijgewerkt!",
                    ];
                };                   
            }else{
                $dataArray  =   [
                    "data"          =>  "error",
                    "dataContent"   =>  "{$error[0]}",
                ];
            }
                echo json_encode($dataArray);
        break;
        
        case "buyit" :
            $uuid       =   !empty($input->get("data")["useruuid"]) ? $input->get("data")["useruuid"]   : null;
            $shipuuid   =   !empty($input->get("data")["shipuuid"]) ? $input->get("data")["shipuuid"]   : null;
            $buyit      =   !empty($input->get("data")["buyit"])    ? false : true;
            
            if($input->exist() > 0 and empty($error) === true){                
                //chek this ship is in depostit
                $ship->set_ShipsDeposit($shipuuid, 0);
                if($ship->set_ShipsBuyit($shipuuid, $buyit) > 0){
                    $dataArray  =   [
                        "data"          =>  "success",
                        "dataContent"   =>  "Je gegevens is bijgewerkt!",
                    ];
                };                   
            }else{
                $dataArray  =   [
                    "data"          =>  "error",
                    "dataContent"   =>  "{$error[0]}",
                ];
            }
                echo json_encode($dataArray);
        break;

        case "depostit" :
            $uuid       =   !empty($input->get("data")["useruuid"]) ? $input->get("data")["useruuid"]   : null;
            $shipuuid   =   !empty($input->get("data")["shipuuid"]) ? $input->get("data")["shipuuid"]   : null;
            $depostit   =   !empty($input->get("data")["depostit"]) ? false  : true;
            
            if($input->exist() > 0 and empty($error) === true){                
                if($ship->set_ShipsDeposit($shipuuid, $depostit) > 0){
                    $dataArray  =   [
                        "data"          =>  "success",
                        "dataContent"   =>  "Je gegevens is bijgewerkt!",
                    ];
                };                   
            }else{
                $dataArray  =   [
                    "data"          =>  "error",
                    "dataContent"   =>  "{$error[0]}",
                ];
            }
                echo json_encode($dataArray);
        break;

        case "trashship" :
            if($input->exist()){
                $shipuuid   =   !empty($input->get("data")["shipuuid"]) ? $input->get("data")["shipuuid"] : null;
                
                //debug($shipuuid);
                if($ship->trashship($shipuuid) > 0){
                    $dataArray  =   [
                        "data"          =>  "success",
                        "dataContent"   =>  "Je gegevens is bijgewerkt!",
                    ];
                }else{
                    $dataArray  =   [
                        "data"          =>  "error",
                        "dataContent"   =>  "No database connection!",
                    ];
                }
                    echo json_encode($dataArray);
                
            };        
        break;

        case "getmyships" :
            if(!empty($ship->getmyship())){
                foreach($ship->getmyship() as $data){
                    $shipData   =   json_decode($data->ship_json);
                    $dataArray[]  =   [
                        "shipuuid"      =>  "{$data->saveshipuuid}",
                        "useruuid"      =>  "{$data->useruuid}",
                        "ship_uuid"     =>  "{$data->ship_uuid}",

                        "ship_name"     =>  "{$data->ship_name}",
                        "ship_img"      =>  "{$data->ship_img}",
                        "manufacturer"  =>  "{$shipData->manufacturer->name}",                       
                        
                        "restore"       =>  !empty("{$data->buyit}") ? true : false,                        
                    ];                   
                }
            }else{
                $dataArray  =   [];  
            } 
                echo json_encode($dataArray);
        break;
        
        case "getship" :
            if(!empty($ship->getship())){
                foreach($ship->getship() as $data){
                    $shipData   =   json_decode($data->ship_json);
                    
                    $dataArray[]  =   [
                        "shipuuid"      =>  "{$data->saveshipuuid}",
                        "useruuid"      =>  "{$data->useruuid}",
                        "ship_uuid"     =>  "{$data->ship_uuid}",

                        "ship_name"     =>  "{$data->ship_name}",
                        "ship_img"      =>  "{$data->ship_img}",
                        "manufacturer"  =>  "{$shipData->manufacturer->name}",
                        
                        "depostit"      =>  !empty("{$data->depostit}") ? true      : false,
                        "showdepostit"  =>  !empty("{$data->depostit}") ? "active"  : null,
                        "showPrice"     =>  "aUEC ".number_format($data->price , 2),
                        "location"      =>  "{$data->location}",
                        "postdate"      =>  $data->postdate,
                    ];                   
                }
            }else{
                $dataArray  =   [];  
            }           
                //echo debug($ship->getship());                
                echo json_encode($dataArray);                
        break;
    }