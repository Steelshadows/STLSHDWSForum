<?php
  $data = json_decode(stripslashes(file_get_contents("php://input")),true);
?>
  <div id="pageTitle" data-pagetitle="STLSHDWS my bio"></div>
  <script type="temp">    
  </script>
  <div class="row justify-content-center">
    <div class="col-10">
      <div class="row m-2">
        <h1><span class="display_alias"></span>'s profile</h1>
        <image class="display_image profile_image m-2">
        <input class="bio-edit d-none" type="file" id="bio_image_upload" name="new_bio_image" accept=".jpg, .jpeg, .png">
      </div>
      <div class="row m-2 ">
        <label class="bio-edit d-none">Alias:</label>
        <textarea id="alias_editor" class="display_alias bio-edit d-none">
        </textarea>
      </div>
      <div class="row m-2 ">
        <div id="bio_container" class="display_bio bio-view"></div>
        <label class="bio-edit d-none">Bio text:</label>
        <div id="" class="bio-edit d-none editor_box">
          <textarea id="bio_editor" class="display_bio bio-edit d-none">
          </textarea>
        </div>
      </div>
    </div>
    <div class="col-2">
  	  <button class="m-2 bio-view" id="editMyPage">edit page</button>
  	  <button class="m-2 bio-edit d-none" id="viewMyPage">preview page</button>
  	  <button class="m-2 bio-edit d-none" id="submitChanges">submit changes</button>
    </div>
  </div>
