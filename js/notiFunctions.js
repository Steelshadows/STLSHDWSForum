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
        "post_posted":{
            "title":"",
            "msg":"Post has been successfully posted",
        },
        "reaction_posted":{
            "title":"",
            "msg":"Reaction has been successfully posted",
        },
        "creating_post_failed":{
            "title":"",
            "msg":"Something went wrong.\nYour post has not been posted",
        },
        "creating_reaction_failed":{
            "title":"",
            "msg":"Something went wrong.\nYour reaction has not been posted",
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
        "post_edits_saved":{
            "title":"",
            "msg":"Edits successfully applied",
        },
        "post_edits_could_not_be_saved":{
            "title":"",
            "msg":"Edits could not be applied",
        },
        "profile_edits_saved":{
            "title":"",
            "msg":"Edits successfully applied",
        },
        "profile_edits_could_not_be_saved":{
            "title":"",
            "msg":"Edits could not be applied",
        },
        "login_check_passed":{
            "title":"",
            "msg":"User is now logged in",
        },
        "post_does_not_exist":{
            "title":"",
            "msg":"This post could not be found",
        },
        "user_does_not_exist":{
            "title":"",
            "msg":"This user could not be found",
        },
        "key_and_username_dont_match":{
            "title":"",
            "msg":"Key does not match with username",
        },
        "key_and_username_match":{
            "title":"",
            "msg":"Key matches with username",
        },
        "user_not_owner":{
            "title":"",
            "msg":"You dont have permission to do this",
        },
        "post_hidden":{
            "title":"",
            "msg":"This post has been hidden successfully",
        },
        "post_could_not_be_hidden":{
            "title":"",
            "msg":"Something went wrong.\nThis post has not been hidden",
        },
        "signup_failed":{
            "title":"",
            "msg":"Something went wrong.\nYour account could not be made",
        },
        "passwords_dont_match":{
            "title":"",
            "msg":"Something went wrong.\nPasswords do not match",
        },
        "username_not_found":{
            "title":"",
            "msg":"Something went wrong.\nThis username could not be found",
        },
        "user_not_found":{
            "title":"",
            "msg":"Something went wrong.\nThis user could not be found",
        },
        "password_changed_1":{
            "title":"",
            "msg":"Password successfully changed",
        },
        "password_changed_0":{
            "title":"",
            "msg":"Something went wrong.\nPassword could not be changed",
        },
        "email_not_valid":{
            "title":"",
            "msg":"This email is not valid",
        },
        "signup_complete":{
            "title":"",
            "msg":"Signup was completed successfully\nWelcome to our forum",
        },
        "signup_failed":{
            "title":"",
            "msg":"Something went wrong.\nSignup could not be completed",
        },
        "username_exists":{
            "title":"",
            "msg":"Something went wrong.\nThis username is already in use",
        },
        "email_exists":{
            "title":"",
            "msg":"Something went wrong.\nThis email is already in use",
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