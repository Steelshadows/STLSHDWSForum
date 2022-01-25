<?php
function saveNewPost($data){
    if(isset($_SESSION['userData']["uid"])){
        
        $db_connection = new db_connection();

        $uid = $_SESSION['userData']["uid"];
        $title = $data["title"];
        $content = $data["content"];
        
        $sql = "INSERT INTO `posts` (`uid`, `title`, `content`, `date`) VALUES (?, ?, ?, current_timestamp())";
        $params = [$uid,$title,$content];
        if($db_connection->Query($sql,$params)){                
            return ['success'=>true];
        }else{
            return ['success'=>false,"error"=>"creating_post_failed"];
        }
    }
}