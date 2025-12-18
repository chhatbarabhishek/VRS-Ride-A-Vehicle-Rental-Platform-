<?php
   // Start the session
   session_start();

   if(!isset($_SESSION['login_user'])){
      header("location: index1.php");
      die();
   }
   $login_session = $_SESSION['login_user'];
?>