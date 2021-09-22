<?php 
    define('_BOANN', 1);
    require_once dirname(dirname(dirname(__file__))).'/libraries/import.php';

    $_POST      =   json_decode(file_get_contents("php://input"), true)["0"];
    $action     =   !empty($_GET["action"]) ? $_GET["action"] : null;

    $input      =   NEW \classes\core\input;
    $session    =   NEW \classes\core\session;
    $setting    =   NEW \classes\core\settings;
    $_config    =   NEW \classes\core\config;
    
    $login      =   NEW \classes\view\loginView;
    
    $starcitzen =   NEW \api\starcitzen_api;


    switch($action){
        case  "register" :
            if($input->exist() > 0){
                $username       =   !empty($input->get("data")["name"])             ? escape($input->get("data")["name"])   : null;
                $email          =   !empty($input->get("data")["email"])            ? $input->get("data")["email"]          : null;
                $password       =   !empty($input->get("data")["password"])         ? $input->get("data")["password"]       : null;
                $password_again =   !empty($input->get("data")["password_again"])   ? $input->get("data")["password_again"] : null;
                
                //check user input on erros
                if(empty($username)     === true)                               { $error = ["Star Citzen naam is een verplichte veld"];}
                elseif(strlen($username) > 63)                                  { $error = ["Het opgegeven Star Citzen naam is te lang"];}
                elseif($login->userExist($username) > 0)                        { $error = ["Het opgegeven Star Citzen naam is al in gebruik"];}
                elseif($starcitzen->organization_member_exist($username) < 1)   { $error = ["Je kan je niet registren"];}
                elseif(empty($email) === true)                                  { $error = ["email adres is een verplichte veld"];}
                elseif(filter_var($email, FILTER_VALIDATE_EMAIL) === false)     { $error = ["Je hebt geen geldige email adres opgegevene"]; }
                elseif($login->emailExist($email) > 0)                          { $error = ["Het opgegeven email is al in gebruik"];}
                elseif(empty($password) === true)                               { $error = ["Wachtwoord is een verplichte veld"];}
                elseif(empty($password_again) === true)                         { $error = ["Herhaal je wachtwoord is een verplichte veld"];}
                elseif($password !== $password_again)                           { $error = ["Wachtwoorden komen niet overeen!"];}
                
                if($input->exist() > 0 and empty($error) === true){
                    $postArray =    [
                        "uuid"      =>  "{$setting->MakeUuid()}",
                        "username"  =>  "{$username}",
                        "password"  =>  "{$login->SetPassword($password)}",
                        "email"     =>  "{$email}",
                    ];

                    if($login->register($postArray) > 0){
                        $me =   $login->userData($username);
                        $session->put($_config->get("boann/user"), $me->uuid);
                        
                        $dataArray  =   [
                                "data"          =>  "success",
                                "dataMessinger" =>  "Je kan nu inloggen, we hebben GEEN email gestuurd",
                                "location"      =>  SITE,
                        ];
                        echo json_encode($dataArray); 
                    }else{
                        //database error
                    }                    
                }else{
                    if(!empty($error)){
                        $dataArray  =   [
                            "data"      =>  "error",
                            "dataError" =>  $error["0"],
                        ];
                        echo json_encode($dataArray);
                    }  
                }
            }
        break;
        
        case  "login" :
            if($input->exist() > 0){
                $username   =   !empty($input->get("data")["name"])     ? escape($input->get("data")["name"])   : null;
                $password   =   !empty($input->get("data")["password"]) ? $input->get("data")["password"]       : null;
                $remeber    =   !empty($input->get("data")["remeber"])  ? $input->get("data")["remeber"]        : null;
                
                //check user input on erros
                if(empty($username)     === true)                           { $error = ["Star Citzen naam is een verplichte veld"];}
                elseif(strlen($username) > 63)                              { $error = ["Het opgegeven naam is te lang"];}
                elseif($login->userExist($username) < 1)                    { $error = ["Het opgegeven naam is onjuist"];}
                elseif(empty($password) === true)                           { $error = ["Wachtwoord is een verplichte veld"];}
                elseif($login->passwordExist($username, $password) < 1)     { $error = ["Het opgegeven wachtwoord is onjuist"];}
                
                if($input->exist() > 0 and empty($error) === true){
                    //get user info
                    $me =   $login->userData($username);
                    
                    //chek rembere is set
                    if(!empty($remeber) === true){
                        //set cookies
                    }
                    
                    //set session
                    $session->put($_config->get("boann/user"), $me->uuid);
                    
                    //send rederect url in json
                    $dataArray  =   [
                        "data"      =>  "success",
                        "location"  =>  SITE,
                    ];
                    echo json_encode($dataArray); 
                }else{
                    if(!empty($error)){
                        $dataArray  =   [
                            "data"      =>  "error",
                            "dataError" =>  $error["0"],
                        ];
                        echo json_encode($dataArray);
                    }  
                }
            }
        break;

        default :
            //rederect to home page
        break;        
    }