//this function creates the html elements needed to view all posts
function createPostBlock(target,pid,uid,titleText,contentText,date,userAlias,userImageSrc){
    var div = document.createElement("div");
    div.innerHTML = contentText;
    var text = div.textContent || div.innerText || "";

    contentText = text;
    titleText = (titleText != "")?titleText:"Titleless post";

    container = document.createElement('div');
    container.className = "row m-2 bg-light";
    container.setAttribute("date",date)
    
    title = document.createElement('h1');
    title.className = "col-12";
    title.innerText = titleText;

    userBox = document.createElement('div');
    userBox.className = "row col-4";
    
    
    userImageBox = document.createElement('div');
    userImageBox.className = "col-5";
    userImage = document.createElement('img');
    userImage.className = "post_user_image";
    userImage.setAttribute("src", userImageSrc);
    userImageBox.appendChild(userImage);
    
    
    userTextBox = document.createElement('div');
    userTextBox.className = "col-7";

    userLink = document.createElement('p');
    userLink.className = "link";
    userLinkUrl = 'guestBioPage';
    userLink.setAttribute("url", userLinkUrl);
    userLink.setAttribute("uid", uid);
    userLink.addEventListener("click",(ev)=>{
        //console.log(ev.target);
        el = ev.target;
        path = el.getAttribute("url");
        data = {"uid":el.getAttribute("uid")};
        goToPage(path,data);
    });
    userLink.innerText = userAlias;
    userTextBox.appendChild(userLink);
    
    content = document.createElement('p');
    content.className = "col-8";
    content.innerText = contentText;
    contentAllowedLength = 10;
    if(contentText.length > contentAllowedLength){
        content.innerText = '';
        for(x=0;x<contentAllowedLength;x++){
            content.innerText += contentText[x];
            
        }
        content.innerText += "...";
    }

    postLink = document.createElement('p');
    postLink.className = "link";
    postLinkUrl = 'post';
    postLink.setAttribute("url", postLinkUrl);
    postLink.setAttribute("pid",pid);
    postLink.addEventListener("click",(ev)=>{
        //console.log(ev.target);
        el = ev.target;
        path = el.getAttribute("url");
        data = {"pid":el.getAttribute("pid")};
        goToPage(path,data);
    });
    postLink.innerText = "read more...";
    
    userBox.appendChild(userImageBox);
    userBox.appendChild(userTextBox);
    //content.appendChild(userBox);
    content.appendChild(postLink);

    container.appendChild(title);
    container.appendChild(userBox);
    container.appendChild(content);
    target.appendChild(container);
}
function createReactionBlock(target,uid,contentText,date,userAlias,userImageSrc){
    contentText = contentText.replace(/<br>/g, '\n')

    container = document.createElement('div');
    container.className = "row m-2 bg-light";
    container.setAttribute("date",date)
    
    userBox = document.createElement('div');
    userBox.className = "row col-4";
    
    userImageBox = document.createElement('div');
    userImageBox.className = "col-5";
    userImage = document.createElement('img');
    userImage.className = "post_user_image";
    userImage.setAttribute("src", userImageSrc);
    userImageBox.appendChild(userImage);
    
    userTextBox = document.createElement('div');
    userTextBox.className = "col-7";

    userLink = document.createElement('p');
    userLink.className = "link";
    userLinkUrl = 'guestBioPage';
    userLink.setAttribute("url", userLinkUrl);
    userLink.setAttribute("uid", uid);
    userLink.addEventListener("click",(ev)=>{
        //console.log(ev.target);
        el = ev.target;
        path = el.getAttribute("url");
        data = {"uid":el.getAttribute("uid")};
        goToPage(path,data);
    });
    userLink.innerText = userAlias;
    userTextBox.appendChild(userLink);
    
    content = document.createElement('p');
    content.className = "col-8";
    content.innerText = contentText;
    
    userBox.appendChild(userImageBox);
    userBox.appendChild(userTextBox);
    content.appendChild(userBox);

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
                //console.log(item);
            });

        }else if(results["error"] == "user_not_logged_in"){
            goToPage("login");
        }

    }); 
}
function loadReactions($pid){
    doRequest('php/action.php?action=getReactions',{"pid":$pid},(res)=>{
        results = JSON.parse(res);
        if(results["success"]){
            reactions = results["reactions"];
            reactions.forEach((item)=>{
                console.log(item);
                createReactionBlock(document.querySelector("div.reaction_view_box"),item.uid,item.content,item.date,item.alias,item.image)
            });

        }else if(results["error"] == "user_not_logged_in"){
            goToPage("login");
        }

    }); 
}