<?php
  include_once('../includes/session.php');
  include_once('../database/db_users.php');
  
  $username = $_SESSION['username'];
  $currPassword = $_POST['currPassword'];
  $newPassword = $_POST['newPassword'];
  $confirmPassword = $_POST['confirmPassword'];
  
  if ($newPassword != $confirmPassword) {
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Edit failed! Passwords do not match!');
    header('Location: ../pages/editprofile.php');
  }
  else if (!validCredentials($username, $currPassword)) {
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Edit failed! Incorrect password!');
    header('Location: ../pages/editprofile.php');
  }
  else {
    editPassword($username, $newPassword);
    $_SESSION['messages'][] = array('type' => 'success', 'content' => 'Successfully edited password!');
    header('Location: ../pages/editprofile.php');
  }
?>