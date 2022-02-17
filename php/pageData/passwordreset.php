<?php
  $data = json_decode(stripslashes(file_get_contents("php://input")),true);
?>
  <div id="pageTitle" data-pagetitle="STLSHDWS password reset" data-actionkey="<?php echo $_GET["actionkey"];?>"></div>
  <script type="temp">    
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
