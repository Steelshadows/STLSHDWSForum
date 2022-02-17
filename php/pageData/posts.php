<?php
  $data = json_decode(stripslashes(file_get_contents("php://input")),true);
?>
<div id="pageTitle" data-pagetitle="STLSHDWS post list"></div>
<script type="temp"> 
</script>    
<div class="row">
    <div class="col-10">
        <div class="create_post d-none">
            <h1>create post</h1>    
            <form id="newPostForm">
                <div class="row m-2"><label class="col-3">Post title:</label><input id="postTitle" name="postTitle" class="col-6" type="text"></div>
                <div class="row m-2"><label class="col-12">content:</label><textarea id="postContent" name="content" class="col-9" type="text" placeholder="Post contents"></textarea></div>
                <div class="row m-2"><input class="col-9" id="submitPost" name="p-submit" type="submit" value="submit post!"></div>
            </form>
        </div>
        <div class="view_post">
        </div>
    </div>
    <div class="col-2">
        <button class="m-2 view_post user_logged_in d-none" id="createPost">add post</button>
    </div>
</div>