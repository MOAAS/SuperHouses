<?php
  include_once('../includes/session.php');
  include_once('../database/db_auth.php');
  
  $username = $_POST['username'];
  $password = $_POST['password'];

  if (validCredentials($username, $password)) {
    $_SESSION['username'] = $username;
    $_SESSION['messages'][] = array('type' => 'success', 'content' => 'Successfully logged in!');
    header('Location: ../pages/houses.php');
  } 
  else {
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Login failed! Username and password do not match.');
    header('Location: ../pages/login.php');
  }
?>