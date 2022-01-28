<?php
    session_start();
    //requires
    require_once('../class/DB_class.php');
    
    //function includes
    include_once('../userFunction.php');
    include_once('../postFunction.php');
    $data = json_decode(stripslashes(file_get_contents("php://input")),true);
  
    $user = getSpecificUser(["uid"=>$_GET["uid"]])["user"];
    var_dump($user);
?>
  <script type="temp">    
    refreshLoggedinUserData();
  </script>
  <div class="row justify-content-center">
    <div class="col-10">
      <div class="row m-2">
        <h1><?=$user["alias"]?>'s profile</h1>
        <image class="profile_image m-2" src="<?=$user["image"]?>">
      </div>
      <div class="row m-2">
        <p><?=$user["bio"]?></p>
      </div>
    </div>
  </div>
