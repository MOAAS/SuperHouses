<?php
    include_once('../includes/session.php');   
    include_once('../includes/messages.php');
    include_once('../database/db_users.php');
  
    updateUserInfo(new UserInfo($_SESSION['username'], $_POST['displayname'], $_POST['country'], $_POST['city']));
    addSuccessMessage('Successfully updated profile!');
    header('Location: ../pages/editprofile.php');

?>