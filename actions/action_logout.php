<?php
  include_once('../includes/session.php');   
  include_once('../includes/sessionMessages.php');
  
  session_destroy();
  session_start();

  //addSuccessMessage('Successfully logged out!');

  header('Location: ../pages/login.php');
?>