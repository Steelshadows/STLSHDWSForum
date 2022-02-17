<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STLSHDWS Forms</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script src="js/dataFunctions.js"></script>
<script src="js/notiFunctions.js"></script>
<script src="js/userFunctions.js"></script>
<script src="js/postFunctions.js"></script>
<script src="js/initFunctions.js"></script>

<script src="js/ckeditor/ckeditor.js"></script>


<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" onclick="goToPage('posts')">STLSHDWS Forms</a>

      <ul class="navbar-nav me-auto mb-2 mb-lg-0">


      <li class="nav-item">
            <a class="nav-link" aria-current="page" onclick="goToPage('posts')">posts</a>
        </li>



      </ul>
      <!-- <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form> -->
    <ul class="navbar-nav mb-2 mb-lg-0  align-self-end">
        <li class="nav-item">
            <a class="nav-link user_logged_out" aria-current="page" onclick="goToPage('login')">Log in</a>
        </li>
        <li class="nav-item">
            <a class="nav-link user_logged_in" aria-current="page" onclick="goToPage('myBioPage')">Welcome, <span class="display_alias"></span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link user_logged_in" aria-current="page" onclick="userLogout()">log out</a>
        </li>
    </ul>
  </div>
</nav>
<div class="container">
    <div id="notification-box" class="notification-box"></div>
    <div id="content-box" class="content-box"></div>
</div>