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
function saveNewReaction($data){

    //return ['success'=>false,"data"=>$data];
    if(isset($_SESSION['userData']["uid"])){
        
        $db_connection = new db_connection();

        $uid = $_SESSION['userData']["uid"];
        $pid = $data["pid"];
        $content = $data["content"];
        
        $sql = "INSERT INTO `reactions` (`pid`, `uid`, `content`, `date`) VALUES (?, ?, ?, current_timestamp())";
        $params = [$pid,$uid,$content];
        if($db_connection->Query($sql,$params)){                
            return ['success'=>true,"msg"=>"reaction_posted"];
        }else{
            return ['success'=>false,"error"=>"creating_post_failed"];
        }
    }
}
function getPosts($data){
    //sort on type -> kan via de javascript
    //search type -> kan ook via js
    //search value -> kan ook via js

    if(isset($_SESSION['userData']["uid"])){
        
        $db_connection = new db_connection();
        
        $sql = "SELECT posts.pid,posts.uid,posts.title,posts.content,posts.date, users.alias, users.image FROM `posts` LEFT JOIN users ON posts.uid = users.uid ORDER BY date DESC";
        $params = [];
        $results = $db_connection->fetchAllQuery($sql,$params);
        if(count($results) >= 1){                
            return ['success'=>true,"posts"=>$results];
        }else{
            return ['success'=>false,"error"=>"loading_posts_failed"];
        }
    }else{
        return ['success'=>false,"error"=>"user_not_logged_in"];
    }
}
function getSpecificPost($data){
    $pid = $data["pid"];
    if(isset($_SESSION['userData']["uid"])){
        
        $db_connection = new db_connection();
        
        $sql = "SELECT posts.pid,posts.uid,posts.title,posts.content,posts.date, users.alias, users.image FROM `posts` LEFT JOIN users ON posts.uid = users.uid WHERE posts.pid = ? ORDER BY date DESC";
        $params = [$pid];
        $result = $db_connection->fetchQuery($sql,$params);
        if(!!$result){                
            return ['success'=>true,"post"=>$result];
        }else{
            return ['success'=>false,"error"=>"loading_post_failed"];
        }
    }else{
        return ['success'=>false,"error"=>"user_not_logged_in"];
    }
}
function getReactions($data){
    $pid = $data["pid"];
    if(isset($_SESSION['userData']["uid"])){
        
        $db_connection = new db_connection();
        
        $sql = "SELECT reactions.uid, reactions.content, reactions.date, users.alias, users.image FROM `reactions` LEFT JOIN users ON reactions.uid = users.uid WHERE reactions.pid = ? ORDER BY date DESC";
        $params = [$pid];
        $results = $db_connection->fetchAllQuery($sql,$params);
        if(count($results) >= 1){                
            return ['success'=>true,"reactions"=>$results];
        }else{
            return ['success'=>false,"error_ignore"=>"loading_reactions_failed"];
        }
    }else{
        return ['success'=>false,"error"=>"user_not_logged_in"];
    }
}