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
  
  if(! addHouse($id,$country,$city,$address,$ownerId,$title,$description,round($price, 2),$capacity,$numRooms,$numBeds,$numBathrooms)){
    addErrorMessage('Adding place failed! Country is not valid!');
    die(header('Location: ../pages/profile.php#Add place'));
  }
    
  //save files
  mkdir( '../database/houseImages/' . $id);
  $target_dir = '../database/houseImages/' . $id .'/' ;
  if( isset($_FILES['fileUpload'])) {
    $total_files = count($_FILES['fileUpload']['name']);
    
    for($key = 0; $key < $total_files; $key++) {
      
      // Check if file is selected
      if(isset($_FILES['fileUpload']['name'][$key]) && $_FILES['fileUpload']['size'][$key] > 0) {
        /*
        $original_filename = $_FILES['fileUpload']['name'][$key];
        $target = $target_dir . basename($original_filename);
        $tmp  = $_FILES['fileUpload']['tmp_name'][$key];
        move_uploaded_file($tmp, $target);
        */
        $original_filename = $_FILES['fileUpload']['name'][$key]; 
       /* // Get the fileextension
        $ext = pathinfo($original_filename, PATHINFO_EXTENSION); */ 
        // Generate new filename
        $new_filename = $key; 
        // Upload the file with new name
        move_uploaded_file($_FILES['fileUpload']['tmp_name'][$key], $target_dir . $new_filename);
      }
      
    }
  }
  
  header('Location: ../pages/search_houses.php');

?>