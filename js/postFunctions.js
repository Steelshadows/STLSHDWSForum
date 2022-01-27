function createPostBlock(target,id,uid,titleText,contentText,date,userAlias,userImage){
    container = document.createElement('div');
    container.className = "row m-2 bg-light";

    link = document.createElement('p');
    linkUrl = 'post.php?pid='+id;
    link.setAttribute("url", linkUrl);
    link.addEventListener("click",(item)=>{
        console.log(item);
    });
    link.innerText = "read more...";

    title = document.createElement('h1');
    title.className = "col-12";
    title.innerText = titleText;

    content = document.createElement('p');
    content.className = "col-12";
    content.innerText = contentText;

    container.appendChild(title);
    container.appendChild(content);
    container.appendChild(link);
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

        }

    }); 
}