<?php
  session_start();
  //requires
  require_once('../../../.php/class/DB_class.php');
  
  //function includes
  include_once('../../../.php/userFunction.php');
  include_once('../../../.php/postFunction.php');
  $data = json_decode(stripslashes(file_get_contents("php://input")),true);

  $res = getSpecificUser(["uid"=>$_GET["uid"]]);
  if(!isset($res["user"])){
    $user = [];
    $user["alias"] = "";
    $user["image"] = "";
    $user["bio"] = "er is iets mis gegaan";
    ?>
      <script type="temp"> 
        showNoti("?user_does_not_exist","error");
        goToPage("posts");
      </script>
    <?php
  }else{
    $user = $res["user"];
  }
?>
  <div id="pageTitle" data-pagetitle="STLSHDWS <?php echo $user["alias"];?>'s profile"></div>
  <script type="temp">    
  </script>
  <div class="row justify-content-center">
    <div class="col-10">
      <div class="row m-2">
        <h1><?php echo $user["alias"];?>'s profile</h1>
        <image class="profile_image m-2" src="<?php echo $user["image"];?>">
      </div>
      <div class="row m-2">
        <p><?php echo $user["bio"];?></p>
      </div>
    </div>
  </div>
