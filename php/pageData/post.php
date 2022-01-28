<?php
  session_start();
  //requires
  require_once('../class/DB_class.php');
  
  //function includes
  include_once('../userFunction.php');
  include_once('../postFunction.php');
  $data = json_decode(stripslashes(file_get_contents("php://input")),true);

  $post = getSpecificPost(["pid"=>$_GET["pid"]])["post"]
?>
  <script type="temp">    
    refreshLoggedinUserData();

    
  </script>
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="row m-2">
      <h1>
        <?=$post["title"]?>
      </h1>
      </div>
      <div class="row m-2">
        <div id="post">
          


          <div class="row col-4 user_box">
            <div class="col-5">
              <img class="post_user_image" src="<?=$post["image"]?>">
            </div>
            <div class="col-7">
              <p class="link user_ref_link" url="guestBioPage" uid="<?=$post["uid"]?>"><?=$post["alias"]?></p>
            </div>
          </div>
          <div class="col-8">
            
            <p id="postContent">
            <?=$post["content"]?>
            </p>
            <?php 
              var_dump($post);
            ?>
          
          </div>
        </div>
      </div>
    </div>
  </div>
