function createPostBlock(target,pid,uid,titleText,contentText,date,userAlias,userImageSrc){
    container = document.createElement('div');
    container.className = "row m-2 bg-light";
    
    title = document.createElement('h1');
    title.className = "col-12";
    title.innerText = titleText;

    userBox = document.createElement('div');
    userBox.className = "row col-4";
    
    
    userImageBox = document.createElement('div');
    userImageBox.className = "col-4";
    userImage = document.createElement('img');
    userImage.className = "post_user_image";
    userImage.setAttribute("src", userImageSrc);
    userImageBox.appendChild(userImage);
    
    
    userTextBox = document.createElement('div');
    userTextBox.className = "col-8";

    userLink = document.createElement('p');
    userLink.className = "link";
    userLinkUrl = 'user.php?uid='+uid;
    userLink.setAttribute("url", userLinkUrl);
    userLink.addEventListener("click",(ev)=>{
        console.log(ev.target);
    });
    userLink.innerText = userAlias;
    userTextBox.appendChild(userLink);
    
    content = document.createElement('p');
    content.className = "col-8";
    content.innerText = contentText + contentText.length;

    postLink = document.createElement('p');
    postLink.className = "link";
    postLinkUrl = 'post.php?pid='+pid;
    postLink.setAttribute("url", postLinkUrl);
    postLink.addEventListener("click",(ev)=>{
        console.log(ev.target);
    });
    postLink.innerText = "read more...";
    
    userBox.appendChild(userImageBox);
    userBox.appendChild(userTextBox);
    content.appendChild(userBox);
    content.appendChild(postLink);

    container.appendChild(title);
    container.appendChild(userBox);
    container.appendChild(content);
    target.appendChild(container);
}
function loadPostsDate(){
    doRequest('php/action.php?action=getPosts',(res)=>{
        results = JSON.parse(res);
        if(results["success"]){
            posts = results["posts"];
            posts.forEach((item)=>{
                createPostBlock(document.querySelector("div.view_post"),item.pid,item.uid,item.title,item.content,item.date,item.alias,item.image)
                console.log(item);
            });

        }else if(results["error"] == "user_not_logged_in"){
            goToPage("login");
        }

    }); 
}