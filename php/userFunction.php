<?php
function saveNewUser($data){
    $username = $data[0]["value"];
    $email = $data[1]["value"];
    $alias = $data[2]["value"];
    $password = $data[3]["value"];
    $passwordAgain = $data[4]["value"];
    $passwordEncode = password_hash($password,PASSWORD_BCRYPT);

    $email_check = filter_var($email, FILTER_VALIDATE_EMAIL);
    if(!$email_check){
        return ['success'=>false,"error"=>"email_not_valid"];
    }
    if($password == $passwordAgain){
        $db_connection = new db_connection();

        $sql_un = "SELECT * FROM `users` WHERE `username` = ?";
        $params_un = [$username];
        
        $exists_un = $db_connection->fetchQuery($sql_un,$params_un);
        if($exists_un == false){
            if($exists_un == false){
                $sql = "INSERT INTO `users` (`username`, `alias`, `image`, `password`, `email`) VALUES (?, ?, ?, ?, ?)";
                $params = [$username,$alias,"img/path.jpg",$passwordEncode,$email];
                if($success = $db_connection->Query($sql,$params)){
                    return ['success'=>true,"loginCheck"=>userLoginCheck([["value"=>$username],["value"=>$password]]),"msg"=>"signup_complete"];
                }else{
                    return ['success'=>false,"error"=>"signup_failed"];
                }
            }else{
                return ['success'=>false,"error"=>"email_exists"];
            }
        }else{
            return ['success'=>false,"error"=>"username_exists"];
        }
    }
    return ['success'=>false,"error"=>"passwords_dont_match"];
} 
function userLoginCheck($data){
    $username = $data[0]["value"];
    $password = $data[1]["value"];
    
    $db_connection = new db_connection();

    $sql = "SELECT `uid`,`username`,`alias`,`image`,`password` FROM `users` WHERE `username` = ?";
    $params = [$username];
    $userData = $db_connection->fetchQuery($sql,$params);
    // var_dump($userData);
    if($userData != false){
        if(password_verify($password,$userData["password"])){        
            return ['success'=>true,"loginStatus"=>setSessionUser($userData['uid']),"msg"=>"login_check_passed"];
        }else{
            return ['success'=>false,"error"=>"passwords_dont_match"];
        }
    }else{
        return ['success'=>false,"error"=>"username_not_found"];
    }
}
function setSessionUser($uid){
    $uid = (int) $uid;

    $db_connection = new db_connection();
    
    if(is_int( $uid )){
        $sql = "SELECT `uid`,`username`,`alias`,`image`,`bio`,`email` FROM `users` WHERE `uid` = ?";
        $params = [$uid];
        $userData = $db_connection->fetchQuery($sql,$params);
        $_SESSION['userData']=$userData;
        return ['success'=>true];
    }else{        
        return ['success'=>false,"error_ignore"=>"uid_not_a_number"];
    }
}
function getUserFromSession(){
    if(isset($_SESSION['userData']["uid"])){
        setSessionUser($_SESSION['userData']["uid"]);
        if(isset($_SESSION['userData'])){
            return ['success'=>true,'data'=>$_SESSION['userData']] ;
        }else{
            return ['success'=>false,'error_ignore'=>"userdata_not_set"] ;
        }
    }else{
        return ['success'=>false,'error_ignore'=>"uid_not_set"] ;
    }
}
function userLogout(){
    session_destroy();
}
function saveProfileEdits($data){

    $db_connection = new db_connection();

    foreach($data as $key=>$edit){
        $value = $edit["data"];
        $uid = $_SESSION['userData']["uid"];
        switch($edit["type"]){
            case "bio":
                $sql = "UPDATE `users` SET `bio` = ? WHERE `users`.`uid` = ?";
                break;
            case "image":
                $sql = "UPDATE `users` SET `image` = ? WHERE `users`.`uid` = ?";
                //TODO:
                // edit this function so images get saved as files instead of base64 strings
                // file_put_contents($output_file, file_get_contents($base64_string));
                // https://stackoverflow.com/questions/15153776/convert-base64-string-to-an-image-file
                break;
            case "alias":
                $sql = "UPDATE `users` SET `alias` = ? WHERE `users`.`uid` = ?";
                break;
            default:
                $sql = "";
                
        }
        $params = [$value,$uid];
        $userData = $db_connection->Query($sql,$params);
        if(count($data)-1 == $key){
            return ["success"=>true,"msg"=>"edits_saved"];
        }
    }
    return ["success"=>false,"error"=>"edits_could_not_be_saved","data"=>$data];
}
function getSpecificUser($data){
    $uid = $data["uid"];
    if(isset($_SESSION['userData']["uid"])){
        
        $db_connection = new db_connection();
        
        $sql = "SELECT `username`,`email`,`alias`,`image`,`bio` FROM `users` WHERE `uid` = ?";
        $params = [$uid];
        $result = $db_connection->fetchQuery($sql,$params);
        if(!!$result){                
            return ['success'=>true,"user"=>$result];
        }else{
            return ['success'=>false,"error"=>"user_not_found"];
        }
    }else{
        return ['success'=>false,"error"=>"user_not_logged_in"];
    }
}
function generate_action_key($data){

    $db_connection = new db_connection();
    
    $action = $data["action"];
    $uid = $data["uid"];
    $action_key = uniqid();
    
    $sql = "INSERT INTO `actionkeys` (`user_id`, `action`, `action_key`) VALUES (?, ?, ?)";
    $params = [$uid,$action,$action_key];
    $success = $db_connection->Query($sql,$params);
    
    return ['success'=>$success,"action_key"=>$action_key,];  
}
function forgotPasswordSend($data){
    
    $db_connection = new db_connection();
    
    //generates key and sends an email
    if (isset($data["uid"])){
        $uid = $data["uid"];
    }else if(isset($data[0]["value"])){
        $sql = "SELECT `uid`,`username`,`alias`,`image`,`bio`,`email` FROM `users` WHERE `username` = ?";
        $params = [$data[0]["value"]];
        $userData = $db_connection->fetchQuery($sql,$params);
        $uid = (isset($userData["uid"]))?$userData["uid"]:0;
    }else{
        $uid = 0;
    }
    $key = generate_action_key(["uid"=>$uid,"action"=>"passwordReset"])["action_key"];
    
    if($uid == 0){
        return ["success"=>false,"error"=>"user_doesnt_exist"];
    }else{
        $msg = "go to the following URL to complete your password reset: \nhttps://stlshdws.com/steelshadowsForms/#passwordReset?actionkey=$key";
        mail($userData["email"],"password reset link",$msg);
        return ["success"=>true,"mail_content"=>$msg];
    }
    
}
function passKeyReset($data){

    $db_connection = new db_connection();
    
    $sql = "SELECT `key_id`,`user_id`,`action`,`action_key` FROM `actionkeys` LEFT JOIN `users` ON `user_id` = `uid` WHERE `action_key` = ? AND `username` = ?";
    $params = [$data["key"],$data["formData"][0]["value"]];
    $action = $db_connection->fetchQuery($sql,$params);
    
    
    if($action != false){
        if($data["formData"][1]["value"] == $data["formData"][2]["value"]){
            $password = $data["formData"][1]["value"];
            $passwordEncode = password_hash($password,PASSWORD_BCRYPT);
            
            $sql = "UPDATE `users` SET `password`= ? WHERE `username` = ?";
            $params = [$passwordEncode,$data["formData"][0]["value"]];
            $success = $db_connection->Query($sql,$params);
            
            $sql_delete = "DELETE FROM `actionkeys` WHERE `action_key` = ?";
            $params_delete = [$data["key"]];
            $delete = $db_connection->Query($sql_delete,$params_delete);

            return ["success"=>$success,"msg"=>"password_changed_".$success];
        }else{            
            return ["success"=>true,'error'=>'passwords_dont_match'];
        }
    }else{
        return ["success"=>false,"error"=>"key_and_username_dont_match"];
    }
}
?>