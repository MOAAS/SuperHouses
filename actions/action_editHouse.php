<?php
  include_once('../includes/session.php');   
  include_once('../includes/sessionMessages.php');
  include_once('../database/db_houses.php');
  include_once('../database/db_users.php');
  
  if ($_SESSION['csrf'] !== $_POST['csrf']) {
    addErrorMessage('Illegitimate request!');
    die(header('Location: ../pages/main.php'));
  }
  
  $id = $_POST['placeID'];
  $title = $_POST['title'];
  $description = $_POST['description'];
  $country = $_POST['country'];
  $city = $_POST['city'];
  $address = $_POST['address'];
  $price = $_POST['price'];
  $capacity = $_POST['capacity'];
  $numRooms = $_POST['numRooms'];
  $numBeds = $_POST['numBeds'];
  $numBathrooms = $_POST['numBathrooms'];

  $username = $_SESSION['username'];
  $ownerId = getUserId($username);
  $house = getHouseById($id);

  if ($house == NULL) {
    addErrorMessage('Editing place failed! Invalid house!');
    die(header('Location: ../pages/profile.php#Add place'));
  }
  
  if($username != $house->ownerUsername){
    addErrorMessage('Editing place failed. You are not the owner!');
    die(header('Location: ../pages/profile.php#Your%20places'));
  }

  if ($title == NULL || $title == "") {
    addErrorMessage('Editing place failed! Invalid title!');
    die(header('Location: ../pages/profile.php#Add place'));
  }
  
  if ($description == NULL || $description == "") {
    addErrorMessage('Editing place failed! Invalid description!');
    die(header('Location: ../pages/profile.php#Add place'));
  }
  
  if ($city == NULL || $city == "") {
    addErrorMessage('Editing place failed! Invalid city!');
    die(header('Location: ../pages/profile.php#Add place'));
  }
  
  if ($address == NULL || $address == "") {
    addErrorMessage('Editing place failed! Invalid address!');
    die(header('Location: ../pages/profile.php#Add place'));
  }
  
  if ($price <= 0 || $price > 1000 || !is_numeric($price)) {
    addErrorMessage('Editing place failed! Price invalid!');
    die(header('Location: ../pages/profile.php#Your%20places'));
  }

  if ($capacity <= 0 || !is_numeric($capacity)) {
    addErrorMessage('Editing place failed! Capacity invalid!');
    die(header('Location: ../pages/profile.php#Your%20places'));
  }

  if ($numRooms <= 0 || !is_numeric($numRooms)) {
    addErrorMessage('Editing place failed! Number of rooms invalid!');
    die(header('Location: ../pages/profile.php#Your%20places'));
  }

  if ($numBeds <= 0 || !is_numeric($numBeds)) {
    addErrorMessage('Editing place failed! Number of beds invalid!');
    die(header('Location: ../pages/profile.php#Your%20places'));
  }

  if ($numBathrooms <= 0 || !is_numeric($numBathrooms)) {
    addErrorMessage('Editing place failed! Number of bathrooms invalid!');
    die(header('Location: ../pages/profile.php#Your%20places'));
  }

  //check files
  $no_uploaded_files = (UPLOAD_ERR_NO_FILE == $_FILES['fileUpload']['error'][0]);
  if(! $no_uploaded_files){
    $total_files = count($_FILES['fileUpload']['name']);
    for($key = 0; $key < $total_files; $key++){
     if ($_FILES['fileUpload']['error'][$key] !== UPLOAD_ERR_OK) {
      addErrorMessage("Editing place failed!Upload failed with error code " . $_FILES['file']['error'][$key]);
       die(header('Location: ../pages/house.php?id='.$id));
     }     
     $info = getimagesize($_FILES['fileUpload']['tmp_name'][$key]);
     if ($info === FALSE) {
      addErrorMessage("Editing place failed! Unable to determine image type of uploaded file");
       die(header('Location: ../pages/house.php?id='.$id));
     }

     if (($info[2] !== IMAGETYPE_GIF) && ($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) {
      addErrorMessage("Editing place failed!Not a gif/jpeg/png");
       die(header('Location: ../pages/house.php?id='.$id));
     }
    } 
  }



  if(!editHouse($id,$country,$city,$address,$title,$description,round($price, 2),$capacity,$numRooms,$numBeds,$numBathrooms)){
    addErrorMessage('Editing place failed. Country is not valid!');
    die(header('Location: ../pages/house.php?id='.$id));
  }
    
  //save files
  if(isset($_FILES['fileUpload']))
    if(! $no_uploaded_files){
        $target_dir = '../database/houseImages/' . $id .'/' ;
        $files = glob($target_dir . '*'); 
        foreach($files as $file){  //deletes all previous files
            if(is_file($file))
            unlink($file); 
        }
        for($key = 0; $key < $total_files; $key++) {
            if(isset($_FILES['fileUpload']['name'][$key]) && $_FILES['fileUpload']['size'][$key] > 0) {
                $original_filename = $_FILES['fileUpload']['name'][$key]; 
                $new_filename = $key; 
                move_uploaded_file($_FILES['fileUpload']['tmp_name'][$key], $target_dir . $new_filename);
            }
        }
    }
  header('Location: ../pages/house.php?id='.$id);

?>