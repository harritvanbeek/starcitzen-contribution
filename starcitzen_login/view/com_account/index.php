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
    $me         =   NEW \classes\view\accountView;

    $starcitzen =   NEW \api\starcitzen_api;

    switch($action){
        case "updatePassword" :
            if($input->exist()){
                $new_password       =   !empty($input->get("data")["new_password"])     ? $input->get("data")["new_password"]   : NULL;
                $password_again     =   !empty($input->get("data")["password_again"])   ? $input->get("data")["password_again"] : NULL;
                
                if(empty($new_password) === true)                               { $error = ["New Password is een verplichte veld"];}
                elseif(empty($password_again) === true)                         { $error = ["Repeat password is een verplichte veld"];}
                elseif($new_password !== $password_again)                       { $error = ["Wachtwoorden komen niet overeen!"];}
                
                if($input->exist() > 0 and empty($error) === true){
                    
                    $postUpdate = [
                        "uuid"      =>  "{$session->get($_config->get("boann/user"))}",
                        "password"  =>  "{$login->SetPassword($new_password)}",
                    ];

                    if($me->updatePassword($postUpdate)){
                        $dataArray  =   [
                            "data"          =>  "success",
                            "dataContent"   =>  "Je wachtwoord is bijgewerkt!",
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
        
        case "updateUsername" :
            if($input->exist()){
                $username   =   !empty($input->get("data")["username"]) ? escape($input->get("data")["username"]) : null;
                
                if(strlen($username) > 63)                                      { $error = ["Het opgegeven Star Citzen naam is te lang"];}
                elseif($login->userExist($username) > 0)                        { $error = ["Het opgegeven Star Citzen naam is al in gebruik"];}
                elseif($starcitzen->organization_member_exist($username) < 1)   { $error = ["Je kan je niet registren"];}
                
                if($input->exist() > 0 and empty($error) === true){
                    $postUpdate = [
                        "uuid"      =>  "{$session->get($_config->get("boann/user"))}",
                        "username"  =>  "{$username}",
                    ];
                    
                    if($me->updateUsername($postUpdate) > 0){
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

        case "updateEmail" : 
            if($input->exist()){
                $new_email       =   !empty($input->get("data")["new_email"])     ? escape($input->get("data")["new_email"])   : NULL;
                $email_again     =   !empty($input->get("data")["email_again"])   ? escape($input->get("data")["email_again"]) : NULL;
                
                if(empty($new_email) === true)                                      { $error = ["New email is een verplichte veld"];}
                elseif(filter_var($new_email, FILTER_VALIDATE_EMAIL) === false)     { $error = ["Je nieuwe email adres  is geen geldige adres"]; }
                elseif($login->emailExist($new_email) > 0)                          { $error = ["Het opgegeven email is al in gebruik"];}
                
                elseif(empty($email_again) === true)                                { $error = ["Repeat email is een verplichte veld"];}
                elseif($new_email !== $email_again)                                 { $error = ["emails komen niet overeen!"];}
                
                if($input->exist() > 0 and empty($error) === true){
                    
                    $postUpdate = [
                        "uuid"      =>  "{$session->get($_config->get("boann/user"))}",
                        "email"     =>  "{$new_email}",
                    ];

                    if($me->updateEmail($postUpdate)){
                        $dataArray  =   [
                            "data"          =>  "success",
                            "dataContent"   =>  "Je email is bijgewerkt!",
                        ];
                    }
                    //debug($input->get("data"));
                }else{
                    $dataArray  =   [
                        "data"          =>  "error",
                        "dataContent"   =>  "{$error[0]}",
                    ];
                }  
                    echo json_encode($dataArray);  
            }
        break;

        case "me" :
            $sc_user = json_decode($starcitzen->user($me->me()->username))->data->profile;
            $date = new DateTime($sc_user->enlisted);
            $array  =  [
                "uuid"          =>  "{$me->me()->uuid}",
                "premissions"   =>  "{$me->premissions()}",
                "username"      =>  "{$me->me()->username}",
                "email"         =>  "{$me->me()->email}",
                "image"         =>  "{$sc_user->image}",
                "enlisted"      =>  "{$date->format('F d, Y')}",
                "fluency"       =>  implode(", ", $sc_user->fluency),
                "website"       =>  "{$sc_user->website}",
                "bio"           =>  nl2br("{$sc_user->bio}"),
                "badge"         =>  "{$sc_user->badge}",
                "badge_image"   =>  "{$sc_user->badge_image}",
            ];
            echo json_encode( $array );
        break;
    }