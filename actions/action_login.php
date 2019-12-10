<?php
  include_once('../includes/session.php');   
  include_once('../includes/sessionMessages.php');
  include_once('../database/db_users.php');
  
  $username = $_POST['username'];
  $password = $_POST['password'];

  if (validCredentials($username, $password)) {
    $_SESSION['username'] = $username;
    //addSuccessMessage('Successfully logged in!');
    header('Location: ../pages/main.php');
  } 
  else {
    addErrorMessage('Login failed! Username and password do not match.');
    header('Location: ../pages/login.php');
  }
?>