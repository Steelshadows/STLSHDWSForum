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
            
            return ['success'=>true,"loginCheck"=>userLoginCheck([["value"=>$username],["value"=>$password]])];
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
        return ['success'=>true,"loginStatus"=>userLogin($userData['uid'])];
    }else{
        return ['success'=>false,"error"=>"passwords_dont_match"];
    }
}
function userLogin($uid){
    $uid = (int) $uid;

    $db_connection = new db_connection();
    
    if(is_int( $uid )){
        $sql = "SELECT `uid`,`username`,`alias`,`image` FROM `users` WHERE `uid` = ?";
        $params = [$uid];
        $userData = $db_connection->fetchQuery($sql,$params);
        $_SESSION['userData']=$userData;
        return ['success'=>true,$_SESSION];
    }else{        
        return ['success'=>false,"error"=>"uid_not_a_number"];
    }
}
function getUserFromSession(){
    if(isset($_SESSION['userData'])){
        return ['success'=>true,'data'=>$_SESSION['userData']] ;
    }else{
        return ['success'=>false,'error'=>"userdata_not_set"] ;
    }
}
function userLogout(){
    session_destroy();
}
?>