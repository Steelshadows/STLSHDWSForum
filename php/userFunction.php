<?php
function saveNewUser($data){
    $username = $data[0]["value"];
    $alias = $data[1]["value"];
    $password = $data[2]["value"];
    $passwordAgain = $data[3]["value"];
    $passwordEncode = password_hash($password,PASSWORD_BCRYPT);

    if($password == $passwordAgain){
        $db_connection = new db_connection();

        $sql = "SELECT * FROM `users` WHERE `username` = ?";
        $params = [$username];
        $exists = $db_connection->fetchQuery($sql,$params);
        if($exists == false){
            $sql = "INSERT INTO `users` (`username`, `alias`, `image`, `password`) VALUES (?, ?, ?, ?)";
            $params = [$username,$alias,"img/path.jpg",$passwordEncode];
            $db_connection->Query($sql,$params);
            
            return ['success'=>true,"loginCheck"=>setSessionUserCheck([["value"=>$username],["value"=>$password]])];
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
    
    if(password_verify($password,$userData["password"])){        
        return ['success'=>true,"loginStatus"=>setSessionUser($userData['uid'])];
    }else{
        return ['success'=>false,"error"=>"passwords_dont_match"];
    }
}
function setSessionUser($uid){
    $uid = (int) $uid;

    $db_connection = new db_connection();
    
    if(is_int( $uid )){
        $sql = "SELECT `uid`,`username`,`alias`,`image`,`bio` FROM `users` WHERE `uid` = ?";
        $params = [$uid];
        $userData = $db_connection->fetchQuery($sql,$params);
        $_SESSION['userData']=$userData;
        return ['success'=>true];
    }else{        
        return ['success'=>false,"error"=>"uid_not_a_number"];
    }
}
function getUserFromSession(){
    if(isset($_SESSION['userData']["uid"])){
        setSessionUser($_SESSION['userData']["uid"]);
        if(isset($_SESSION['userData'])){
            return ['success'=>true,'data'=>$_SESSION['userData']] ;
        }else{
            return ['success'=>false,'error'=>"userdata_not_set"] ;
        }
    }else{
        return ['success'=>false,'error'=>"uid not set"] ;
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
            return ["success"=>true];
        }
    }
    return ["success"=>false,"error"=>"edits_could_not_be_saved","data"=>$data];
}
?>