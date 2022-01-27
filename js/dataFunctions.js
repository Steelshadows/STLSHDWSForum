function doRequest(url,arg1,arg2){
    xhttp = new XMLHttpRequest;
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            res = this.responseText
            callback(res);
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
    };
    document.location.hash = url;
    goToUrl($urls[url],data);
}
function reloadPage(){
    url = document.location.hash.split("?")[0];
    data = "?"+document.location.hash.split("?")[1];
    url = url.split("#")[1];
    goToPage(url,data);
}