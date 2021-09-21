<?php 
    define('_BOANN', 1);
    require_once dirname(dirname(dirname(__file__))).'/libraries/import.php';

    $_POST      =   json_decode(file_get_contents("php://input"), true)["0"];

    $action     =   !empty($_GET["action"]) ? $_GET["action"] : null;
    $input      =   NEW \classes\core\input;
    $session    =   NEW \classes\core\session;
    $setting    =   NEW \classes\core\settings;
    $_config    =   NEW \classes\core\config;

    $me         =   NEW \classes\view\accountView;
    $ships      =   NEW \classes\view\shipView;

    switch($action){
        case "getsettings":
                $array  =   [
                    "sc_orginisation_name"  => $setting->get_settings("sc_orginisation_name"),
                    "sc_api_key"            => $setting->get_settings("sc_api_key"),
                ];
                
                echo json_encode($array);
        break;

        case "post_settings":
            if($input->exist()){
                $postData   =  $input->get("data");
                foreach($postData as $keys => $params){
                    $dataArray  =   [
                        "keys"      =>  "{$keys}",
                        "params"    =>  "{$params}",
                    ];
                    if($setting->post_settings($dataArray)){
                        $dataArray  =   [
                            "data"          =>  "success",
                            "dataContent"   =>  "Je gegevens zijn bijgewerkt!",
                        ];
                    }else{
                        $dataArray  =   [
                            "data"          =>  "error",
                            "dataContent"   =>  "try later again!",
                        ];
                    };                    
                } 
                    echo json_encode($dataArray);
            }
        break;

        case "reset_contribution":
            if($input->exist() > 0){
                if($me->updateContribution(null)){
                    $dataArray  =   [
                        "data"          =>  "success",
                        "dataContent"   =>  "Je gegevens zijn bijgewerkt!",
                    ];
                }

                echo json_encode($dataArray);
            }
        break;
        
        case "donate_saving_ship":
            if($input->exist() > 0){
                $shipuuid   =   !empty($input->get("data")["shipuuid"])     ? $input->get("data")["shipuuid"]               : null;
                $useruuid   =   !empty($me->me()->uuid)                     ? $me->me()->uuid               : null;
                $donate     =   !empty($input->get("data")["donate"])       ? replace_money($input->get("data")["donate"])  : null;

                if(empty($donate) === true)                          {   $error = ["incorect value"];  }  
                elseif(empty(number_format($donate, 2)) === true)    {   $error = ["incorect value"];  }  
                
                if($input->exist() > 0 and empty($error) === true){
                    
                    $array  =   [
                        "donateuuid"    =>  "{$setting->MakeUuid()}",
                        "shipuuid"      =>  "{$shipuuid}",
                        "useruuid"      =>  "{$useruuid}",
                        "donate"        =>  "{$donate}",
                        "postdate"      =>  date("Y-m-d h:i:s", getdate()[0]), //2021-07-30 12:09:42
                    ];                                        
                    
                    //and set contribution
                    $contribution   =   $me->me()->contribution + $donate;
                    if($ships->donate_ships($array) and $me->updateContribution($contribution)){
                        $dataArray  =   [
                            "data"          =>  "success",
                            "dataContent"   =>  "Je gegevens zijn bijgewerkt!",
                        ];
                    };
                }else{
                    $dataArray  =   [
                        "data"          =>  "error",
                        "dataContent"   =>  "{$error[0]}",
                    ];
                }
                    echo json_encode($dataArray);

            }
        break;

        case "deleteShipDonation":
            if($input->exist() > 0){
                $donateuuid     =   !empty($input->get("data")["donateuuid"]) ? $input->get("data")["donateuuid"]   : null;
                if($input->exist() > 0 and empty($error) === true){
                    if($ships->delete_DonadedShips($donateuuid) > 0){
                        $dataArray  =   [
                            "data"          =>  "success",
                            "dataContent"   =>  "Je gegevens zijn bijgewerkt!",
                        ];
                    };
                }else{
                        $dataArray  =   [
                            "data"          =>  "error",
                            "dataContent"   =>  "{$error[0]}",
                        ];
                }
                        echo json_encode($dataArray);
            }; 
        break;

        case "get_DonadedShips":
            if($input->exist() > 0){
                $shipuuid     =   !empty($input->get("data")["shipuuid"]) ? $input->get("data")["shipuuid"] : null;
                
                if(!empty($ships->get_DonadedShips($shipuuid)) == true){
                    foreach($ships->get_DonadedShips($shipuuid) as $item) {
                        $date = new DateTime($item->postdate);
                        $dataArray[]    =   [
                            "shipuuid"      =>  "{$item->shipuuid}",
                            "donateuuid"    =>  "{$item->donateuuid}",
                            "username"      =>  "{$item->username}",
                            "donate"        =>  "aUEC ". number_format($item->donate , 2),
                            "postdate"      =>  "{$date->format('F d, Y')}",
                            "useruuid"      =>  "{$item->useruuid}",
                            "uuid"          =>  "{$session->get($_config->get("boann/user"))}",
                        ];
                    }
                }else{
                    $dataArray  =   [];  
                }
                    echo json_encode($dataArray);

            }
        break;

        case "get_ShipsToBuy":
            if(!empty($ships->get_ShipsDeposit()) == true){
                foreach($ships->get_ShipsDeposit() as $ship){
                    $togo = $ship->price - $ship->donate;
                    $array[]    =   [
                        "donateuuid "   =>  "{$ship->donateuuid}",
                        "shipuuid"      =>  "{$ship->ship_uuid}",
                        "useruuid"      =>  "{$ship->useruuid}",
                        "name"          =>  "{$ship->ship_name}",
                        "price"         =>  !empty($ship->price) ? "aUEC ". number_format($ship->price , 2) : null,
                        "togo"         =>   !empty($togo) ? "aUEC ". number_format($togo , 2) : null,
                        "location"      =>  "{$ship->location}",
                        "username"      =>  "{$ship->username}",
                    ];
                }
            }else{
                    $array = [];
            }
                echo json_encode($array);

        break;

        case "get_currentbank":
            foreach($me->users() as $user){
                $array[] = [
                    "useruuid"      => "{$user->uuid}",
                    "sessionuuid"   => "{$session->get($_config->get("boann/user"))}",
                    "username"      => "{$user->username}",
                    "bank"          => "aUEC ". number_format($user->bank , 2),
                    "contribution"  => !empty($user->contribution) ?  "aUEC ". number_format($user->contribution , 2) :   "aUEC ". number_format(0 , 2),
                ];
            }
            
            echo json_encode($array);
        break;

        case "post_aUEC":
            if($input->exist()){
                $money          = !empty($input->get("data")["aUEC"]) ? replace_money($input->get("data")["aUEC"]) : NULL;
                
                if(empty(number_format($money, 2)) === true)    {   $error = ["incorect value"];  }  
                if($input->exist() > 0 and empty($error) === true){
                    $postUpdate = [
                        "uuid"      =>  "{$session->get($_config->get("boann/user"))}",
                        "bank"      =>  "{$money}",
                    ];

                    if($me->updateBank($postUpdate)){
                        $dataArray  =   [
                            "data"          =>  "success",
                            "dataContent"   =>  "Je gegevens zijn bijgewerkt!",
                        ];
                    }
                }else{
                    $dataArray  =   [
                        "data"          =>  "error",
                        "dataContent"   =>  "{$error[0]}",
                    ];
                }
                    echo json_encode($dataArray);
            }
        break;

        case "get_aUEC":
            $array = ["aUEC" => number_format($me->me()->bank , 2)];
            echo json_encode($array);
        break;
    }