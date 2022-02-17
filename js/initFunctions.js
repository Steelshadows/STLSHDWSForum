function initDefault(){
    document.title = $("#pageTitle").data()["pagetitle"];    
    loadClickEvents();
    refreshLoggedinUserData();
}
function initLogin(){    
    initDefault(); 
    document.getElementById("signupForm").addEventListener("submit",(e)=>{
        e.preventDefault();
        
        formDataJson = [];
        document.forms['signupForm'].querySelectorAll("input").forEach((item,key)=>{
            itemObj = {};
            itemObj.name = item.name;
            itemObj.value = item.value;
            formDataJson.push(itemObj)
        })
        console.log(formDataJson);
  
        doRequest('../.php/action.php?action=saveNewUser',formDataJson,(res)=>{
            console.log(res);
            refreshLoggedinUserData();
            updateUserGUI();
        });
    });
    document.getElementById("loginForm").addEventListener("submit",(e)=>{
        e.preventDefault();
        
        formDataJson = [];
        document.forms['loginForm'].querySelectorAll("input").forEach((item,key)=>{
            itemObj = {};
            itemObj.name = item.name;
            itemObj.value = item.value;
            formDataJson.push(itemObj)
        });
        console.log(formDataJson);
  
        doRequest('../.php/action.php?action=userLoginCheck',formDataJson,(res)=>{
            console.log(res);
            results = JSON.parse(res);
            refreshLoggedinUserData();
            if(results.success)goToPage('myBioPage');
        });
    });
    document.getElementById("show_pass_reset").addEventListener("click",(e)=>{
        document.querySelectorAll(".sign_up , .log_in").forEach((item)=>{item.classList.add("d-none")});
        document.querySelectorAll(".forgot_password").forEach((item)=>{item.classList.remove("d-none")});
    });
    document.getElementById("password_reset").addEventListener("submit",(e)=>{
        e.preventDefault();
        
        formDataJson = [];
        document.forms['password_reset'].querySelectorAll("input").forEach((item,key)=>{
            itemObj = {};
            itemObj.name = item.name;
            itemObj.value = item.value;
            formDataJson.push(itemObj)
        })
        console.log(formDataJson);
        doRequest("../.php/action.php?action=forgotPasswordSend",formDataJson,(res)=>{
            console.log(res)
        })
    });    
}
function initMyBio(){    
    initDefault(); 
    refreshLoggedinUserData(function (){
        ClassicEditor
        .create( document.querySelector( '#bio_editor' ), {
            toolbar: [ 'Heading','Essentials','Autoformat','Bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote','Link','Table','TableToolbar' ]
        } )
        .then( editor => {
            console.log( editor );
            CKEditor = editor;
            editor.setData(sessionStorage.getItem("bio"));
        } )
        .catch( error => {
            console.error( error );
        } );     
    });  
    const reader = new FileReader();
    function previewProfileImage(){
        reader.readAsDataURL(document.getElementById("bio_image_upload").files[0]);
        reader.onload = () => {
            const preview = document.getElementsByClassName('display_image')[0];
            preview.src = reader.result;
        };
    }
    document.getElementById("editMyPage").addEventListener("click",(ev)=>{
        document.querySelectorAll(".bio-edit").forEach((item,key)=>{item.classList.remove('d-none')})
        document.querySelectorAll(".bio-view").forEach((item,key)=>{item.classList.add('d-none')})
    });
    document.getElementById("viewMyPage").addEventListener("click",(ev)=>{
        document.querySelectorAll(".bio-edit").forEach((item,key)=>{item.classList.add('d-none')})
        document.querySelectorAll(".bio-view").forEach((item,key)=>{item.classList.remove('d-none')})

        //refresh data
        document.querySelectorAll('.display_bio').forEach((item)=>{
            console.log(item.innerHTML = document.querySelector(".ck-content").innerHTML.replace(/"/g, '\\"'))
        });
    });
    document.getElementById("bio_editor").addEventListener("change",(ev)=>{
        document.getElementById("bio_container").innerHTML = document.getElementById("bio_editor").value;
    });
    document.getElementById("alias_editor").addEventListener("change",(ev)=>{
        document.querySelectorAll(".display_alias").forEach((item,key)=>{
            console.log(item,key);
            item.innerText = document.getElementById("alias_editor").value;
        });
    });
    document.getElementById("bio_image_upload").addEventListener("change",(ev)=>{
        previewProfileImage();
    });
    document.getElementById("submitChanges").addEventListener("click",(ev)=>{
        change_data = [];
        if(document.getElementById("bio_image_upload").files.length == 1){
          reader.readAsDataURL(document.getElementById("bio_image_upload").files[0]);
          reader.onload = () => {
            const preview = document.getElementsByClassName('display_image')[0];
            change_data.push({"type":"image","data":reader.result});
            change_data.push({"type":"bio","data":document.getElementById("bio_editor").value});
            change_data.push({"type":"alias","data":document.getElementById("alias_editor").value});
            doRequest('../.php/action.php?action=saveProfileEdits',change_data,(res)=>{
                console.log(res);
                refreshLoggedinUserData();
            });
        };
        }else{  
            change_data.push({"type":"bio","data":document.querySelector(".ck-content").innerHTML.replace(/"/g, '\\"')});
            change_data.push({"type":"alias","data":document.getElementById("alias_editor").value});
            console.log(change_data);
            doRequest('../.php/action.php?action=saveProfileEdits',change_data,(res)=>{
                console.log(res);
                refreshLoggedinUserData();
            });
        }
    });
}
function initPasswordReset(){    
    initDefault(); 
    document.getElementById("pwresetForm").addEventListener("submit",(e)=>{
        actionkey = $("#pageTitle").data()["actionkey"];
        e.preventDefault();
        
        formDataJson = [];
        document.forms['pwresetForm'].querySelectorAll("input").forEach((item,key)=>{
            itemObj = {};
            itemObj.name = item.name;
            itemObj.value = item.value;
            formDataJson.push(itemObj)
        })
        console.log(formDataJson);
        requestData = {
            'key':actionkey,
            'formData':formDataJson
        };
        doRequest('../.php/action.php?action=passKeyReset',requestData,(res)=>{
            console.log(res);
            goToPage('login');
        });
    });
}
function initPost(){    
    initDefault(); 
    refreshLoggedinUserData();
    loadReactions($("#pageTitle").data()["pid"]);
    document.getElementById("newReactionForm").addEventListener("submit",(ev)=>{
        ev.preventDefault();
        postData = {
            "pid":$("#pageTitle").data()["pid"],
            "content":document.querySelector("#reactionContent").value
        } ;
        document.querySelector("#reactionContent").value = "";
        console.log(postData);
        doRequest('../.php/action.php?action=saveNewReaction',postData,(res)=>{
            loadReactions($("#pageTitle").data()["pid"]);
        });
    });
    document.querySelector(".link.user_ref_link").addEventListener("click",(ev)=>{
        el = ev.target;
        path = el.getAttribute("url");
        data = {"uid":el.getAttribute("uid")};
        goToPage(path,data);
    });
    console.log(1);
    if(sessionStorage.getItem("uid") == $("#pageTitle").data()["pid"]){
        document.querySelector(".post-owner").classList.remove("d-none");
    }
}
function initPosts(){    
    initDefault(); 

    document.getElementById("createPost").addEventListener("click",(ev)=>{
        document.querySelectorAll(".create_post").forEach((item,key)=>{item.classList.remove('d-none')})
        document.querySelectorAll(".view_post").forEach((item,key)=>{item.classList.add('d-none')})
    });
    document.getElementById("submitPost").addEventListener("click",(ev)=>{
        ev.preventDefault();
        postData = {
            "title":document.getElementById("postTitle").value,
            "content":document.querySelector(".ck-content").innerHTML.replace(/"/g, '\\"')
        } ;
        console.log(postData);
        doRequest('../.php/action.php?action=saveNewPost',postData,(res)=>{
            console.log(res);
            document.getElementById("postTitle").innerHTML = "";
            document.querySelector(".ck-content").innerHTML = "";
            document.querySelectorAll(".view_post").forEach((item,key)=>{item.classList.remove('d-none')})
            document.querySelectorAll(".create_post").forEach((item,key)=>{item.classList.add('d-none')})
            loadPostsDate();
        });
    });

    ClassicEditor
    .create( document.querySelector( '#postContent' ), {
        toolbar: [ 'Heading','Essentials','Autoformat','Bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote','Link','Table','TableToolbar' ]
    } ).then( editor => {
        console.log( editor );
    } )
    .catch( error => {
        console.error( error );
    } );


    loadPostsDate();
}
