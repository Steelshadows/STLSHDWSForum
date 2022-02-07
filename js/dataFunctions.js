function doRequest(url,arg1,arg2){
    message = "";
    error = "";
    xhttp = new XMLHttpRequest;
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            res = this.responseText;
            callback(res);
            if(res[0]=="{"){
                resParse = JSON.parse(res);
                console.log(resParse);
                message += (!!resParse["msg"])? "?" + resParse["msg"]:"";
                error += (!!resParse["error"])? "?" + resParse["error"]:"";
                if(message != "")showNoti(message,"");
                if(error != "")showNoti(error,"error");
            }
        }
    };
    var post;
    if(!!arg2){
        var method = "POST";
        var callback = arg2;
        post = JSON.stringify(arg1);
    }else{
        var method = "GET";
        var callback = arg1;
    }
    xhttp.open(method, url, true);
    xhttp.setRequestHeader('Content-Type', 'application/JSON');
    xhttp.send(post);
}
function goToUrl(url,data){
    console.log(data);
    getStr = "";
    if(!!data){
        if(typeof data == "string" && data[0] == "?"){
            getStr = data;
        }else{
            getStr = "?";
            for (item in data){
                getStr += item+"="+data[item]+"&";
                console.log(item,data[item])
            }
        }
    }
    console.log(getStr);
    doRequest(url+getStr,data,(res)=>{
        document.getElementById('content-box').innerHTML = res;
        document.querySelectorAll("script[type='temp']").forEach((item,key)=>{
            // console.log(key,item.innerHTML);
            eval(item.innerHTML);
        });
        document.querySelectorAll("hideOnUrlChange").forEach((item,key)=>{
            item.classList.add("d-none");
        });
        updateUserGUI();
        document.location.hash += getStr;
    });
}
function goToPage(url,data){
    $urls = {
        "login":"php/pageData/login.php",
        "myBioPage":"php/pageData/mybio.php",
        "posts":"php/pageData/posts.php",
        "post":"php/pageData/post.php",
        "guestBioPage":"php/pageData/user.php",
        "passwordReset":"php/pageData/passwordreset.php",
    };
    document.location.hash = url;
    goToUrl($urls[url],data);
}
function reloadPage(){
    if(document.location.hash != "undefined" && document.location.hash != "#undefined" && document.location.hash != ""){
        url = document.location.hash.split("?")[0];
        data = "?"+document.location.hash.split("?")[1];
        url = url.split("#")[1];
        goToPage(url,data);
    }else{
        goToPage("posts");
    }
}
function showNoti(message,type){
    if(message[0] != "?"){
        values = notiCodeToText(message)
        if (typeof values == "object")addNotificationHTML(values.msg,values.title,type)
        if (typeof values == "string")addNotificationHTML(values,"",type)
    }else if(message[0] == "?"){
        messages = message.split("?");
        messages.shift();
        messages.forEach((item)=>{
            console.log(item);
            //document.querySelector("#notification-box").innerHTML += notiCodeToText(item) +"<br>";
            values = notiCodeToText(item)
            if (typeof values == "object")addNotificationHTML(values.msg,values.title,type,item)
            if (typeof values == "string")addNotificationHTML(values,"",type,item)
        })
    }    
}
function addNotificationHTML(contentText, title, type, code){
    target = document.querySelector("#notification-box");
    titleText = (title != "" && typeof title != "undefined")?title:type;
    
    container = document.createElement('div');
    container.className = "row m-2 bg-light rounded-3 "+code;
    // container.addEventListener("click",(ev)=>{
    //     document.querySelector("#notification-box").innerHTML = "";
    // })

    closeBtn = document.createElement('div');
    closeBtn.innerHTML = "X";
    closeBtn.className = "closeBtn float-end";
    closeBtn.setAttribute("code",code);
    closeBtn.addEventListener("click",(ev)=>{
        code = ev.target.getAttribute("code");
        document.querySelectorAll("."+code).forEach((item)=>{
            item.remove();
        });
    })
    
    title = document.createElement('h1');
    if(type == "success"){
        title.className = "col-12 rounded-3 bg-success";
    }else if(type == "error"){
        title.className = "col-12 rounded-3 bg-danger";
    }else{
        title.className = "col-12 rounded-3";
    }

    title.innerText = titleText;
    content = document.createElement('p');
    content.className = "col-8";
    content.innerText = contentText;
    title.appendChild(closeBtn);
    container.appendChild(title);
    container.appendChild(content);
    if(document.querySelectorAll("."+code).length == 0){
        target.appendChild(container);
    }
}
function notiCodeToText(code){
    codeArray = {
        "msg":{
            "title":"Message",
            "msg":"Message Template",
        },
        "loading_posts_failed":{
            "title":"",
            "msg":"Failed to load posts",
        },
        "loading_reactions_failed":{
            "title":"",
            "msg":"Failed to load reactions",
        },
        "user_not_logged_in":{
            "title":"",
            "msg":"User is not logged in",
        },
        "login_check_passed":{
            "title":"",
            "msg":"User is now logged in",
        },
        "reaction_posted":{
            "title":"",
            "msg":"Reaction has been successfully posted",
        },
        "post_posted":{
            "title":"",
            "msg":"Post has been successfully posted",
        },
        "edits_saved":{
            "title":"",
            "msg":"Edits successfully applied",
        },
        "post_does_not_exist":{
            "title":"",
            "msg":"This post could not be found",
        },
        "user_does_not_exist":{
            "title":"",
            "msg":"This user could not be found",
        },
        "key_and_username_match":{
            "title":"",
            "msg":"key matches with username",
        },
    }

    // console.log(code);
    // console.log(codeArray[code]);
    // console.log(typeof codeArray[code]);
    // console.log(typeof codeArray[code] == "string");
    res = (typeof codeArray[code] == "object")?codeArray[code]:{"title":" ","msg":code};
    console.log(res);
    return res;
}