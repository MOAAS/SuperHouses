<?php
    include_once('../includes/session.php');   
    include_once('../includes/sessionMessages.php');
    include_once('../database/db_users.php');
  
    updateUserInfo(new UserInfo($_SESSION['username'], $_POST['displayname'], $_POST['country'], $_POST['city']));

    if(isset($_FILES['imageUpload'])){
    $uploaddir = "../database/profileImages/";
    $user = getUserInfo($_SESSION['username']);
    $id = getUserID($user->username);
    move_uploaded_file($_FILES['imageUpload']['tmp_name'], $uploaddir . $id);
    }

    
    addSuccessMessage('Successfully updated profile!');
    header('Location: ../pages/profile.php'); //?

?>