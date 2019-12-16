<?php
  include_once('../includes/session.php');   
  include_once('../includes/sessionMessages.php');
  include_once('../database/db_users.php');
  
  if ($_SESSION['csrf'] !== $_POST['csrf']) {
    addErrorMessage('Illegitimate request!');
    die(header('Location: ../pages/main.php'));
  }
  
  $username = $_SESSION['username'];
  $currPassword = $_POST['currPassword'];
  $newUsername = $_POST['newUsername'];

  if ( !preg_match ("/^[a-zA-Z0-9]+$/", $username)) {
    addErrorMessage('Edit failed! Username can only contain letters and numbers!');
    header('Location: ../pages/signup.php');
  }  
  else if (!validCredentials($username, $currPassword)) {
    addErrorMessage('Edit failed! Incorrect password!');
    header('Location: ../pages/profile.php');
  }
  else if (userExists($newUsername)) {
    addErrorMessage('Edit failed! Username already exists!');
    header('Location: ../pages/profile.php');
  }
  else {
    editUsername($username, $newUsername);
    $_SESSION['username'] = $newUsername;
    addSuccessMessage('Successfully changed username!');
    header('Location: ../pages/profile.php');
  }
?>