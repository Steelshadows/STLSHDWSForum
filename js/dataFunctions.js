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
function goToUrl(url,data,callback){
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

        if (typeof callback == "function")callback();

    });
}
function goToPage(url,data){
    $urls = {
        "login":{"url":"php/pageData/login.php","init":"initLogin"},
        "myBioPage":{"url":"php/pageData/mybio.php","init":"initMyBio"},
        "posts":{"url":"php/pageData/posts.php","init":"initPosts"},
        "post":{"url":"php/pageData/post.php","init":"initPost"},
        "guestBioPage":{"url":"php/pageData/user.php"},
        "passwordReset":{"url":"php/pageData/passwordreset.php","init":"initPasswordReset"},
    };
    document.location.hash = url;
    if (typeof window[$urls[url]["init"]] == "function")callback = window[$urls[url]["init"]];
    else callback = initDefault;

    goToUrl($urls[url]["url"],data,callback);
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
function loadClickEvents(){
    $(".clickEvent.noArg").on("click",(ev)=>{
        window[$(ev.target).attr("data-function")]();
    });
    $(".clickEvent.arg").on("click",(ev)=>{
        window[$(ev.target).attr("data-function")]($(ev.target).attr("data-args"));
    });
}