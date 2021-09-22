<?php 
    define('_BOANN', 1);
    require_once dirname(dirname(dirname(__file__))).'/libraries/import.php';

    $_POST      =   json_decode(file_get_contents("php://input"), true)["0"];

    $action     =   !empty($_GET["action"]) ? $_GET["action"] : null;
    $input      =   NEW \classes\core\input;
    $login      =   NEW \classes\view\loginView;
    $users      =   NEW \classes\view\accountView;

    $starcitzen =   NEW \api\starcitzen_api;

    switch($action){
        case "updateUser" :
            if($input->exist()){
                $uuid       = !empty($input->get("data")["uuid"])       ? $input->get("data")["uuid"]       : NULL;
                $username   = !empty($input->get("data")["username"])   ? $input->get("data")["username"]   : NULL;
                $email      = !empty($input->get("data")["email"])      ? $input->get("data")["email"]      : NULL;
                $premission = !empty($input->get("data")["premission"]) ? $input->get("data")["premission"] : NULL;
                
                //errors
                if($username !== $users->me($uuid)->username){
                    if(empty($username)     === true)                               { $error = ["Star Citzen naam is een verplichte veld"];}
                    elseif(strlen($username) > 63)                                  { $error = ["Het opgegeven Star Citzen naam is te lang"];}
                    elseif($login->userExist($username) > 0)                        { $error = ["Het opgegeven Star Citzen naam is al in gebruik"];}
                    elseif($starcitzen->organization_member_exist($username) < 1)   { $error = ["Je kan je niet registren"];}
                }

                if(empty($email) === true)                                      { $error = ["email adres is een verplichte veld"];}
                elseif(filter_var($email, FILTER_VALIDATE_EMAIL) === false)     { $error = ["Je hebt geen geldige email adres opgegevene"]; }
                elseif($email !== $users->me($uuid)->email){
                    if($login->emailExist($email) > 0)                          { $error = ["Het opgegeven email is al in gebruik"];}
                }

                if($input->exist() > 0 and empty($error) === true){
                   $PostArray   =   [
                        "uuid"          =>  "{$uuid}",
                        "username"      =>  escape("{$username}"),
                        "email"         =>  "{$email}",
                        "premission"    =>  "{$premission}",
                   ]; 
                   if($users->updateUserAdmin($PostArray)){
                        $dataArray  =   [
                            "data"          =>  "success",
                            "dataContent"   =>  "User is updated!",
                        ];
                   };
                }else{
                    if(!empty($error)){
                        $dataArray  =   [
                            "data"      =>  "error",
                            "dataError" =>  $error["0"],
                        ];
                    }  
                }
                        echo json_encode($dataArray);                
            }
        break;

        case "GetPremission" :
            $array[]  =   [
                "value"         =>  "1200",
                "premission"    =>  "admin",
            ];

            $array[]  =   [
                "value"         =>  "",
                "premission"    =>  "user",
            ];

            echo json_encode($array);
        break;
        case "GetUsers" :
            foreach($users->users() as $user){
                $array[]  =   [
                    "uuid"          =>  "{$user->uuid}",
                    "username"      =>  "{$user->username}",
                    "email"         =>  "{$user->email}",
                    "bank"          =>  "{$user->bank}",
                    "contribution"  =>  "{$user->contribution}",
                    "premission"    =>  "{$user->premissions}",
                    "premissions"   =>  "{$users->premissions($user->uuid)}",
                ];
            };
            echo json_encode($array);
        break;
    }