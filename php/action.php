<?php 
session_start();
//header("Content-Type: application/json");
//requires
require_once('class/DB_class.php');

//function includes
include_once('userFunction.php');
include_once('postFunction.php');
 
//get data and fire function
if(isset($_GET["action"])){
    $data = json_decode(stripslashes(file_get_contents("php://input")),true);
    $funcName = $_GET["action"];    
    echo json_encode($funcName($data));
}