<?php
  include_once('../includes/session.php');   
  include_once('../includes/sessionMessages.php');
  include_once('../database/db_users.php');
  
  $username = $_POST['username'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirmPassword'];
  $fullName = $_POST['fullName'];


  if (strlen($username) < 8) {
    addErrorMessage('Sign up failed! Username must be at least 8 characters long!');
    header('Location: ../pages/signup.php');
  }
  else if ( !preg_match ("/^[a-zA-Z0-9]+$/", $username)) {
    addErrorMessage('Sign up failed! Username can only contain letters and numbers!');
    header('Location: ../pages/signup.php');
  }
  else if ($password != $confirmPassword) {
    addErrorMessage('Sign up failed! Passwords do not match!');
    header('Location: ../pages/signup.php');
  }
  else if (userExists($username)) {
    addErrorMessage('Sign up failed! Username already exists!');
    header('Location: ../pages/signup.php');
  }
  else {
    addUser($username, $password, $fullName);
    $_SESSION['username'] = $username;
    //addSuccessMessage('Successfully signed up!');
    header('Location: ../pages/main.php');
  }
?>