<?php
    include_once('../includes/session.php');   
    include_once('../includes/sessionMessages.php');
    include_once('../database/db_users.php');

    if ($_SESSION['csrf'] !== $_POST['csrf']) {
        addErrorMessage('Illegitimate request!');
        die(header('Location: ../pages/main.php'));
    }
  
    updateUserInfo(new UserInfo($_SESSION['username'], $_POST['displayname'], $_POST['country'], $_POST['city'], null));

    if(isset($_FILES['imageUpload']) && UPLOAD_ERR_NO_FILE != $_FILES['imageUpload']['error']){
        if ($_FILES['imageUpload']['error'] !== UPLOAD_ERR_OK) {
          addErrorMessage("Profile Image update failed! Upload failed with error code " . $_FILES['file']['error']);
          die(header('Location: ../pages/profile.php#Profile'));
        }     
        $info = getimagesize($_FILES['imageUpload']['tmp_name']);
        if ($info === FALSE) {
          addErrorMessage("Profile Image update failed! Unable to determine image type of uploaded file");
          die(header('Location: ../pages/profile.php#Profile'));
        }

        if (($info[2] !== IMAGETYPE_GIF) && ($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) {
          addErrorMessage("Profile Image update failed! Not a gif/jpeg/png");
          die(header('Location: ../pages/profile.php#Profile'));
        }
        if($_FILES['imageUpload']['size']> 5242880) { //5 MB  
          addErrorMessage("Profile Image update failed! Image size above 5MB");
          die(header('Location: ../pages/profile.php#Profile'));
        }
        $uploaddir = "../database/profileImages/";
        $user = getUserInfo($_SESSION['username']);
        $id = getUserID($user->username);
        move_uploaded_file($_FILES['imageUpload']['tmp_name'], $uploaddir . $id);
    }


    addSuccessMessage('Successfully updated profile!');
    header('Location: ../pages/profile.php#Profile');

?>