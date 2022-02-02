<?php
function saveNewUser($data){
    $username = $data[0]["value"];
    $email = $data[1]["value"];
    $alias = $data[2]["value"];
    $password = $data[3]["value"];
    $passwordAgain = $data[4]["value"];
    $passwordEncode = password_hash($password,PASSWORD_BCRYPT);

    if($password == $passwordAgain){
        $db_connection = new db_connection();

        $sql = "SELECT * FROM `users` WHERE `username` = ?";
        $params = [$username];
        $exists = $db_connection->fetchQuery($sql,$params);
        if($exists == false){
            $sql = "INSERT INTO `users` (`username`, `alias`, `image`, `password`, `email`) VALUES (?, ?, ?, ?, ?)";
            $params = [$username,$alias,"img/path.jpg",$passwordEncode,$email];
            $db_connection->Query($sql,$params);
            
            return ['success'=>true,"loginCheck"=>userLoginCheck([["value"=>$username],["value"=>$password]]),"msg"=>"signup_complete"];
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
?>