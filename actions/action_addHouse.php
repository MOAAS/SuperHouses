<?php
  include_once('../includes/session.php');   
  include_once('../includes/sessionMessages.php');
  include_once('../database/db_houses.php');
  include_once('../database/db_users.php');
  
  $id = getNewHouseId();

  $title = $_POST['title'];
  $description = $_POST['description'];
  $country = $_POST['country'];
  $city = $_POST['city'];
  $address = $_POST['address'];
  $price = $_POST['price'];
  $capacity = $_POST['capacity'];
  $numRooms = $_POST['numRooms'];
  $numBeds = $_POST['numBeds'];
  $numBathrooms =$_POST['numBathrooms'];

  $username = $_SESSION['username'];
  $ownerId = getUserId($username);

  if ($ownerId == NULL) {
    addErrorMessage('Adding place failed! Invalid user!');
    die(header('Location: ../pages/profile.php#Add place'));
  }

  if ($title == NULL || $title == "") {
    addErrorMessage('Adding place failed! Invalid title!');
    die(header('Location: ../pages/profile.php#Add place'));
  }
  
  if ($description == NULL || $description == "") {
    addErrorMessage('Adding place failed! Invalid description!');
    die(header('Location: ../pages/profile.php#Add place'));
  }
  
  if ($city == NULL || $city == "") {
    addErrorMessage('Adding place failed! Invalid city!');
    die(header('Location: ../pages/profile.php#Add place'));
  }
  
  if ($address == NULL || $address == "") {
    addErrorMessage('Adding place failed! Invalid address!');
    die(header('Location: ../pages/profile.php#Add place'));
  }
  

  if ($price <= 0 || $price > 1000 || !is_numeric($price)) {
    addErrorMessage('Adding place failed! Price invalid!');
    die(header('Location: ../pages/profile.php#Add place'));
  }

  if ($capacity <= 0 || !is_numeric($capacity)) {
    addErrorMessage('Adding place failed! Capacity invalid!');
    die(header('Location: ../pages/profile.php#Add place'));
  }

  if ($numRooms <= 0 || !is_numeric($numRooms)) {
    addErrorMessage('Adding place failed! Number of rooms invalid!');
    die(header('Location: ../pages/profile.php#Add place'));
  }

  if ($numBeds <= 0 || !is_numeric($numBeds)) {
    addErrorMessage('Adding place failed! Number of beds invalid!');
    die(header('Location: ../pages/profile.php#Add place'));
  }

  if ($numBathrooms <= 0 || !is_numeric($numBathrooms)) {
    addErrorMessage('Adding place failed! Number of bathrooms invalid!');
    die(header('Location: ../pages/profile.php#Add place'));
  }
  
  //checkfiles
  if(!isset($_FILES['fileUpload']) || UPLOAD_ERR_NO_FILE == $_FILES['fileUpload']['error'][0]){
    addErrorMessage("Adding place failed! No images uploaded");
    die(header('Location: ../pages/profile.php#Add place'));
  }
  $total_files = count($_FILES['fileUpload']['name']);
  if($total_files >= 30){
    addErrorMessage("Adding place failed! Maximum of 30 photos exceded");
    die(header('Location: ../pages/profile.php#Add place'));
  }
  for($key = 0; $key < $total_files; $key++){
   if ($_FILES['fileUpload']['error'][$key] !== UPLOAD_ERR_OK) {
    addErrorMessage("Adding place failed! Upload failed with error code " . $_FILES['file']['error'][$key]);
    die(header('Location: ../pages/profile.php#Add place'));
   }     
   $info = getimagesize($_FILES['fileUpload']['tmp_name'][$key]);
   if ($info === FALSE) {
    addErrorMessage("Adding place failed! Unable to determine image type of uploaded file");
    die(header('Location: ../pages/profile.php#Add place'));
   }
   
   if (($info[2] !== IMAGETYPE_GIF) && ($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) {
    addErrorMessage("Adding place failed! Not a gif/jpeg/png");
    die(header('Location: ../pages/profile.php#Add place'));
   }

   if($_FILES['fileUpload']['size'][$key] > 5242880) { //5 MB  
    addErrorMessage("Adding place failed! Image size above 5MB");
    die(header('Location: ../pages/profile.php#Add place'));
   }
  } 

  
  if(! addHouse($id,$country,$city,$address,$ownerId,$title,$description,round($price, 2),$capacity,$numRooms,$numBeds,$numBathrooms)){
    addErrorMessage('Adding place failed! Country is not valid!');
    die(header('Location: ../pages/profile.php#Add place'));
  }
    
  //save files
  $target_dir = '../database/houseImages/' . $id .'/' ;
  mkdir( '../database/houseImages/' . $id);
  for($key = 0; $key < $total_files; $key++) {
    if(isset($_FILES['fileUpload']['name'][$key]) && $_FILES['fileUpload']['size'][$key] > 0) {
      $original_filename = $_FILES['fileUpload']['name'][$key]; 
      $new_filename = $key; 
      move_uploaded_file($_FILES['fileUpload']['tmp_name'][$key], $target_dir . $new_filename);
    }
    
  }

  
 header('Location: ../pages/search_houses.php');

?>