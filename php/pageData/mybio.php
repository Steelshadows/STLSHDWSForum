<?php
  $data = json_decode(stripslashes(file_get_contents("php://input")),true);
?>
  <script type="temp">    
    refreshLoggedinUserData();

    const reader = new FileReader();
    function previewProfileImage(){
      reader.readAsDataURL(document.getElementById("bio_image_upload").files[0]);
      reader.onload = () => {
        const preview = document.getElementsByClassName('display_image')[0];
        preview.src = reader.result;
      };
    }
    document.getElementById("editMyPage").addEventListener("click",(ev)=>{
      document.querySelectorAll(".bio-edit").forEach((item,key)=>{item.classList.remove('d-none')})
      document.querySelectorAll(".bio-view").forEach((item,key)=>{item.classList.add('d-none')})
    });
    document.getElementById("viewMyPage").addEventListener("click",(ev)=>{
      document.querySelectorAll(".bio-edit").forEach((item,key)=>{item.classList.add('d-none')})
      document.querySelectorAll(".bio-view").forEach((item,key)=>{item.classList.remove('d-none')})
    });
    document.getElementById("bio_editor").addEventListener("change",(ev)=>{
      document.getElementById("bio_container").innerText = document.getElementById("bio_editor").value;
    });
    document.getElementById("alias_editor").addEventListener("change",(ev)=>{
      document.querySelectorAll(".display_alias").forEach((item,key)=>{
        console.log(item,key);
        item.innerText = document.getElementById("alias_editor").value;
      });
    });
    document.getElementById("bio_image_upload").addEventListener("change",(ev)=>{
      previewProfileImage();
    });
    document.getElementById("submitChanges").addEventListener("click",(ev)=>{
      change_data = [];
      if(document.getElementById("bio_image_upload").files.length == 1){
        reader.readAsDataURL(document.getElementById("bio_image_upload").files[0]);
        reader.onload = () => {
          const preview = document.getElementsByClassName('display_image')[0];
          change_data.push({"type":"image","data":reader.result});
          change_data.push({"type":"bio","data":document.getElementById("bio_editor").value});
          change_data.push({"type":"alias","data":document.getElementById("alias_editor").value});
          doRequest('php/action.php?action=saveProfileEdits',change_data,(res)=>{
            console.log(res);
            refreshLoggedinUserData();
          });
        };
      }else{

        change_data.push({"type":"bio","data":document.getElementById("bio_editor").value});
        change_data.push({"type":"alias","data":document.getElementById("alias_editor").value});
        console.log(change_data);
        doRequest('php/action.php?action=saveProfileEdits',change_data,(res)=>{
          console.log(res);
          refreshLoggedinUserData();
        });
      }
    });

    
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
        <textarea id="bio_editor" class="display_bio bio-edit d-none">
        </textarea>
      </div>
    </div>
    <div class="col-2">
  	  <button class="m-2 bio-view" id="editMyPage">edit page</button>
  	  <button class="m-2 bio-edit d-none" id="viewMyPage">preview page</button>
  	  <button class="m-2 bio-edit d-none" id="submitChanges">submit changes</button>
    </div>
  </div>
