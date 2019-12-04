<?php
  include_once('../includes/session.php');   
  include_once('../includes/messages.php');
  include_once('../database/db_users.php');
  
  $username = $_SESSION['username'];
  $currPassword = $_POST['currPassword'];
  $newPassword = $_POST['newPassword'];
  $confirmPassword = $_POST['confirmPassword'];
  
  if ($newPassword != $confirmPassword) {
    addErrorMessage('Edit failed! Passwords do not match!');
    header('Location: ../pages/editprofile.php');
  }
  else if (!validCredentials($username, $currPassword)) {
    addErrorMessage('Edit failed! Incorrect password!');
    header('Location: ../pages/editprofile.php');
  }
  else {
    editPassword($username, $newPassword);
    addSuccessMessage('Successfully edited password!');
    header('Location: ../pages/editprofile.php');
  }
?>