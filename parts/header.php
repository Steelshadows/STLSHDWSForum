<?php
    session_start();
    $urls = [
        "login"=>"php/pageData/login.php",
        "myBioPage"=>"php/pageData/mybio.php",
    ];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STLSHDWS Forms</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>

<script src="js/dataFunctions.js"></script>
<script src="js/userFunctions.js"></script>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">STLSHDWS Forms</a>

      <ul class="navbar-nav me-auto mb-2 mb-lg-0">


        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>


      </ul>
      <!-- <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form> -->
    <ul class="navbar-nav mb-2 mb-lg-0  align-self-end">
        <li class="nav-item">
            <a class="nav-link active user_logged_out" aria-current="page" onclick="goToUrl('<?=$urls['login']?>')">Log in</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active user_logged_in" aria-current="page" onclick="goToUrl('<?=$urls['myBioPage']?>')">Welcome, <span class="display_alias"></span></a>
        </li>
    </ul>
  </div>
</nav>
<div class="container">
    <div id="content-box" class="content-box"></div>
</div>