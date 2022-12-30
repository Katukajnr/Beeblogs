<?php

session_start();

 require "inc/process.php";
 require "inc/header.php";   
 // require "body.php"; 

 ?>

<div class="container">
   <?php require './pages/header-home.php'; ?>
   <div class="container-fluid my-3">
       <div class="row">
       <div class="px-4 py-5 my-5 text-center">
   <img class="d-block mx-auto mb-4" src="./images/bee.png" alt="" width="250" height="250">
   <div class="col-lg-6 mx-auto">
    <!--  <p class="lead mb-4">Quickly get access to all Pass Questions in different courses and sessions.</p> -->
     <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mt-1">
       <a href="body.php" class="btn btn-outline-secondary btn-md px-4" >Get Started</a>
     </div>
   </div>
   </div>
 </div>
</div>
<?php require './pages/footer-home.php'; ?>
</div>

 <?php 
 require "inc/footer.php"; 
 ?>

