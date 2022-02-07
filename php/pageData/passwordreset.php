<?php
  $data = json_decode(stripslashes(file_get_contents("php://input")),true);
?>
  <script type="temp">    
    console.log("oi");
    document.title = "STLSHDWS login";
    document.getElementById("pwresetForm").addEventListener("submit",(e)=>{
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
        'key':'<?=$_GET["actionkey"]?>',
        'formData':formDataJson
      };
      doRequest('php/action.php?action=passKeyReset',requestData,(res)=>{
        console.log(res);
        goToPage('login');
      });
    });
  </script>
  <div class="row justify-content-center">
    <div class="col">
      <form id="pwresetForm">
        <div class="row m-2"><label class="col-3">Username:</label><input name="username" class="col-6" type="text" placeholder="Username"></div>
        <div class="row m-2"><label class="col-3">Password:</label><input name="pass" class="col-6" type="password" placeholder="Password"></div>
        <div class="row m-2"><label class="col-3">Password again:</label><input name="pass2" class="col-6" type="password" placeholder="Password again"></div>
        <div class="row m-2"><input class="col-9" name="l-submit" type="submit" value="Reset your password!"></div>  
      </form>
    </div>
  </div>
