<?php
  include_once('../includes/session.php');
  include_once('../database/db_auth.php');
  
  $username = $_POST['username'];
  $password = $_POST['password'];
  $fullName = $_POST['fullName'];

  if (addUser($username, $password, $fullName)) {
    $_SESSION['username'] = $username;
    $_SESSION['messages'][] = array('type' => 'success', 'content' => 'Successfully signed up!');
    header('Location: ../pages/houses.php');
  }
  else {
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Sign up failed! Username already exists!');
    header('Location: ../pages/signup.php');
  }
?>