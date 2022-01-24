function userLogout(){
    doRequest('php/action.php?action=userLogout',(res)=>{
        sessionStorage.removeItem("uid")
        sessionStorage.removeItem("username")
        sessionStorage.removeItem("alias")
        sessionStorage.removeItem("image")
        refreshLoggedinUserData();
        updateUserGUI();
    }); 
}
function refreshLoggedinUserData(){
    doRequest('php/action.php?action=getUserFromSession',(res)=>{
        res = JSON.parse(res);
        if(res.success){
            sessionStorage.setItem("uid",res.data.uid)
            sessionStorage.setItem("username",res.data.username)
            sessionStorage.setItem("alias",res.data.alias)
            sessionStorage.setItem("image",res.data.image)
            updateUserGUI();
        }        
    });
}
function updateUserGUI(){
    // START: show/hide elements based on login status
    if(sessionStorage.getItem("uid") != null){
        document.querySelectorAll(".user_logged_out").forEach((item,key)=>{
            item.classList.add("d-none")    
        })
        document.querySelectorAll(".user_logged_in").forEach((item,key)=>{
            item.classList.remove("d-none")    
        })
    }else{
        document.querySelectorAll(".user_logged_out").forEach((item,key)=>{
            item.classList.remove("d-none")    
        })
        document.querySelectorAll(".user_logged_in").forEach((item,key)=>{
            item.classList.add("d-none")    
        })
    }
    // END: show/hide elements based on login status
    // START: fill data tags
    if(sessionStorage.getItem("uid") != null){

    }
    // END: fill data tags
}