<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PP-HOME</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"/>
    <?php require('inc/links.php'); ?>
    
<style>
       .availability-form {
        margin-top: -50px;
        z-index: 2;
        position: relative;
     }
     @media screen and (max-width: 575px) {
        .availability-form {
        margin-top: 25px;
        padding: 0 35px;
     } }
         </style>
</head>
  <body class="bg-light">
 
<?php
session_name('user');
session_start();
?>
  <!--Navbar-->
    <nav id="nav-bar" class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
    <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="images/logo.png" alt="paradisperdu" width="50" height="40">
    </a>
    <?php
    if (isset($_SESSION['full_name'])) {

      echo ' <div class="btn-group">
         <button type="button" class="btn btn-outline-dark shadow-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
         <img src="profil/'.$_SESSION['profile'].'" style="width: 25px; height: 25px;" class="me-1">
         '.$_SESSION["full_name"].'
         </button>
         <ul class="dropdown-menu">
         <li><a class="dropdown-item" href="profile.php">Action</a></li>
         <li><a class="dropdown-item" href="bookings.php">Bookings</a></li>
         <li><a class="dropdown-item" href="logout.php">Logout</a></li>
      </ul>
    </div>';
    }
    else{
      echo '
        <div class="d-flex align-items-center justify-content-between mb-2">
        <button type="submit" class="btn btn-dark shadow-none" name="login">LOGIN</button>
        </div>
          <div class="text-center my-1">
          <button type="submit" class="btn btn-dark shadow-none">REGISTER</button>
        </div>
      ';
    }


    ?>
    </div>
  </div>
</nav>
 
 <?php require('inc/footer.php');?> 
</body>
</html>