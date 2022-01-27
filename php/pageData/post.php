<?php
  session_start();
  //requires
  require_once('../class/DB_class.php');
  
  //function includes
  include_once('../userFunction.php');
  include_once('../postFunction.php');
  $data = json_decode(stripslashes(file_get_contents("php://input")),true);

  $post = getSpecificPost(["pid"=>$_GET["pid"]])
?>
  <script type="temp">    
    refreshLoggedinUserData();

    
  </script>
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="row m-2">
        <h1>post</h1>
      </div>
      <div class="row m-2">
        <div id="post">
          <?php 
            var_dump($post);
          ?>
        </div>
      </div>
    </div>
  </div>
