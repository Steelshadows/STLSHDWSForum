<?php
  $data = json_decode(stripslashes(file_get_contents("php://input")),true);
  $get = $_GET;
  var_dump($get);
?>
  <script type="temp">    
    refreshLoggedinUserData();

    
  </script>
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="row m-2">
        <h1><span class="display_alias"></span>'s profile</h1>
        <image class="display_image profile_image m-2">
      </div>
      <div class="row m-2 ">
        <div id="bio_container" class="display_bio bio-view"></div>
      </div>
    </div>
  </div>
