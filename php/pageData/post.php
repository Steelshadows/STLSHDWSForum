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
    loadReactions(<?=$_GET["pid"]?>);
    
    document.getElementById("newReactionForm").addEventListener("submit",(ev)=>{
        ev.preventDefault();
        postData = {
            "pid":<?=$_GET["pid"]?>,
            "content":document.querySelector("#reactionContent").value
        } ;
        console.log(postData);
        doRequest('php/action.php?action=saveNewReaction',postData,(res)=>{
          console.log(res);
        });
    });
  </script>
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="row m-2">
      <h1>
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
            
            <p id="postContent">
            <?=$post["content"]?>
            </p>
            <?php 
              // var_dump($post);
            ?>
          
          </div>
          <div class="row col-12 reaction_box">
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
  </div>
