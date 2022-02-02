<?php
  session_start();
  //requires
  require_once('../class/DB_class.php');
  
  //function includes
  include_once('../userFunction.php');
  include_once('../postFunction.php');
  $data = json_decode(stripslashes(file_get_contents("php://input")),true);

  if(isset($_GET["pid"])){
    $res = getSpecificPost(["pid"=>$_GET["pid"]]);
    if(isset($res["post"])){
      $post = $res["post"];
    }else{
      noData();
    }
  }else{
    noData();
  }
  function noData(){
    $post = [];
    $post["title"] = " ";
    $post["image"] = "";
    $post["uid"] = 0;
    $post["alias"] = "";
    $post["date"] = "";
    $post["content"] = "er is iets mis gegaan";
    ?>
      <script type="temp"> 
        showNoti("?post_does_not_exist","error");
        goToPage("posts");
      </script>
    <?php
  }
  ?>
  <script type="temp">    
    refreshLoggedinUserData();
    loadReactions(<?=$_GET["pid"]?>);
    document.getElementById("newReactionForm").addEventListener("submit",(ev)=>{
      ev.preventDefault();
      postData = {
        "pid":<?=$_GET["pid"]?>,
        "content":document.querySelector("#reactionContent").value
        } ;
        document.querySelector("#reactionContent").value = "";
        console.log(postData);
        doRequest('php/action.php?action=saveNewReaction',postData,(res)=>{
          loadReactions(<?=$_GET["pid"]?>);
        });
      });
    document.querySelector(".link.user_ref_link").addEventListener("click",(ev)=>{
      el = ev.target;
      path = el.getAttribute("url");
        data = {"uid":el.getAttribute("uid")};
        goToPage(path,data);
      });
    console.log(1);
    if(sessionStorage.getItem("uid") == '<?=$post["uid"]?>'){
      document.querySelector(".post-owner").classList.remove("d-none");
    }
  </script>
  <div class="row justify-content-center">
    <div class="col-10">
      <div class="row m-2">
      <h1 class="display_title">
        <?=($post["title"] != "")?$post["title"]:"Titleless post";?>
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
            <p class="date"><?=$post["date"]?></p>
            </div>
          </div>
          <div class="col-8">
            
            
            <div class="row m-2 ">
              <label class="post-edit d-none">title:</label>
              <textarea id="title_editor" class="display_title post-edit d-none">
                <?=($post["title"] != "")?$post["title"]:"Titleless post";?>
              </textarea>
            </div>
            <div class="row m-2 ">
              <div id="post_container" class="display_post post-view">
                <?=$post["content"]?>
              </div>
              <label class="post-edit d-none">Post:</label>
              <div id="" class="post-edit d-none editor_box">
                <textarea id="post_editor" class="display_post post-edit d-none">
                  </textarea>
                </div>
              </div>
              
            </div>
          <div class="row col-12 post-view reaction_box">
            <div class="col-12 reaction_creation_box">
              <form id="newReactionForm">
                <div class="row m-2"><textarea id="reactionContent" name="content" class="col-6" type="text" placeholder="Reaction contents"></textarea></div>
                <div class="row m-2"><input class="col-6" id="submitReaction" name="r-submit" type="submit" value="Submit reaction!"></div>
              </form>
            </div>
            <div class="col-12 reaction_view_box">
              </div>
            </div>
          </div>
        </div>
    </div>
    <div class="col-2">
      <button class="m-2 user-<?=$post["uid"]?> post-view d-none" id="editMyPost">edit page</button>
  	  <button class="m-2 post-edit d-none" id="viewMyPost">preview page</button>
  	  <button class="m-2 post-edit d-none" id="delete">delete post</button>
  	  <button class="m-2 post-edit d-none" id="submitChanges">submit changes</button>
      <script type="temp"> 
        document.getElementById("editMyPost").addEventListener("click",(ev)=>{
          document.querySelectorAll(".post-edit").forEach((item,key)=>{item.classList.remove('d-none')})
          document.querySelectorAll(".post-view").forEach((item,key)=>{item.classList.add('d-none')})
        });   
        document.getElementById("viewMyPost").addEventListener("click",(ev)=>{
          document.querySelectorAll(".post-edit").forEach((item,key)=>{item.classList.add('d-none')})
          document.querySelectorAll(".post-view").forEach((item,key)=>{item.classList.remove('d-none')})
          document.querySelectorAll('.display_post').forEach((item)=>{
            item.innerHTML = document.querySelector(".ck-content").innerHTML.replace(/"/g, '\\"');
          });
        });   
        document.getElementById("title_editor").addEventListener("change",(ev)=>{
          document.querySelectorAll(".display_title").forEach((item,key)=>{
            console.log(item,key);
            item.innerText = document.getElementById("title_editor").value;
          });
        });
        document.getElementById("submitChanges").addEventListener("click",(ev)=>{

          change_data = [];
          change_data.push({"type":"title","data":document.getElementById("title_editor").value});
          change_data.push({"type":"content","data":document.querySelector(".ck-content").innerHTML.replace(/"/g, '\\"')});
          postData = {"pid":<?=$_GET["pid"]?>,"edits":change_data}
          console.log(postData);
          doRequest('php/action.php?action=savePostEdits',postData,(res)=>{
            console.log(res);
            refreshLoggedinUserData();
          });

        });
        document.getElementById("delete").addEventListener("click",(ev)=>{

          postData = {"pid":<?=$_GET["pid"]?>}
          console.log(postData);
          doRequest('php/action.php?action=hidePost',postData,(res)=>{
            console.log(res);
            refreshLoggedinUserData();
            goToPage("posts");
          });

        });
        refreshLoggedinUserData(function (){
          ClassicEditor
          .create( document.querySelector( '#post_editor' ) )
          .then( editor => {
              console.log( editor );
              CKEditor = editor;
              editor.setData('<?=$post["content"]?>');
          } )
          .catch( error => {
              console.error( error );
          } ); 
        });
      </script>
    </div>
  </div>
  