<?php
  $data = json_decode(stripslashes(file_get_contents("php://input")),true);
?>
  <div id="pageTitle" data-pagetitle="STLSHDWS login"></div>
  <script type="temp">    
  </script>
  <div class="row justify-content-center">
    <div class="col log_in">
      <h1>log in</h1>
      <form id="loginForm">
        <div class="row m-2"><label class="col-3">Username:</label><input name="username" class="col-6" type="text" placeholder="Username"></div>
        <div class="row m-2"><label class="col-3">Password:</label><input name="pass" class="col-6" type="password" placeholder="Password"></div>
        <div class="row m-2"><input class="col-9" name="l-submit" type="submit" value="Log in!"></div>
        <div class="row m-2"><a id="show_pass_reset" class="col-12 text-justify show_pass_reset" name="forgotPassword">?forgot your password?</a></div>
      </form>
    </div>
    <div class="col sign_up">
      <h1>sign up</h1>
      <form id="signupForm">
        <div class="row m-2"><label class="col-3">Username:</label><input name="username" class="col-6" type="text" placeholder="Username"></div>
        <div class="row m-2"><label class="col-3">Email:</label><input name="email" class="col-6" type="text" placeholder="Email"></div>
        <div class="row m-2"><label class="col-3">Alias:</label><input name="alias" class="col-6" type="text" placeholder="Alias"></div>
        <div class="row m-2"><label class="col-3">Password:</label><input name="pass" class="col-6" type="password" placeholder="Password"></div>
        <div class="row m-2"><label class="col-3">Password again:</label><input name="passagain" class="col-6" type="password" placeholder="Password again"></div>
        <div class="row m-2"><input class="col-9" name="s-submit" type="submit" value="Sign up!"></div>
      </form>
    </div>
    <div class="col-12 forgot_password d-none">
      <h1>forgot password</h1>
      <form id="password_reset">
        <div class="row m-2"><label class="col-3">Username:</label><input name="username" class="col-6" type="text" placeholder="Username"></div>
        <!-- <div class="row m-2"><label class="col-3">Alias:</label><input name="alias" class="col-6" type="text" placeholder="Alias"></div>
        <div class="row m-2"><label class="col-3">Password:</label><input name="pass" class="col-6" type="password" placeholder="Password"></div>
        <div class="row m-2"><label class="col-3">Password again:</label><input name="passagain" class="col-6" type="password" placeholder="Password again"></div> -->
        <div class="row m-2"><input class="col-9" name="s-submit" type="submit" value="reset password"></div>
      </form>
    </div>
  </div>
