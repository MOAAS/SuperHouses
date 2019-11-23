<?php
  include_once('../includes/session.php');
  include_once('../database/db_users.php');
  
  $username = $_SESSION['username'];
  $currPassword = $_POST['currPassword'];
  $newUsername = $_POST['newUsername'];
  
  if (!validCredentials($username, $currPassword)) {
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Edit failed! Incorrect password!');
    header('Location: ../pages/editprofile.php');
  }
  else if (userExists($newUsername)) {
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Edit failed! Username already exists!');
    header('Location: ../pages/editprofile.php');
  }
  else {
    editUsername($username, $newUsername);
    $_SESSION['username'] = $newUsername;
    $_SESSION['messages'][] = array('type' => 'success', 'content' => 'Successfully changed username!');
    header('Location: ../pages/editprofile.php');
  }
?>