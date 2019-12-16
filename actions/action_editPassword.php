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
  $newPassword = $_POST['newPassword'];
  $confirmPassword = $_POST['confirmPassword'];
  
  if ($newPassword != $confirmPassword) {
    addErrorMessage('Edit failed! Passwords do not match!');
    header('Location: ../pages/profile.php#Profile');
  }
  else if (!validCredentials($username, $currPassword)) {
    addErrorMessage('Edit failed! Incorrect password!');
    header('Location: ../pages/profile.php#Profile');
  }
  else {
    editPassword($username, $newPassword);
    addSuccessMessage('Successfully edited password!');
    header('Location: ../pages/profile.php#Profile');
  }
?>