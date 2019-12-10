<?php
  include_once('../includes/session.php');   
  include_once('../includes/sessionMessages.php');
  include_once('../database/db_houses.php');
  include_once('../database/db_users.php');
  
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
  
  print_r("HELLO");
  if($username != $house->ownerUsername){
    addErrorMessage('Editing place failed. You are not the owner! id: ' . $id . ' usernam' . $username . ' owner:' . $house->ownerUsername);
    die(header('Location: ../pages/house.php?id='.$id));
  }
  
  if ($price <= 0 || $price > 1000 || !is_numeric($price)) {
    addErrorMessage('Editing place failed! Price invalid!');
    die(header('Location: ../pages/house.php?id=${id}'));
  }

  if ($capacity <= 0 || !is_numeric($capacity)) {
    addErrorMessage('Editing place failed! Capacity invalid!');
    die(header('Location: ../pages/house.php?id=${id}'));
  }

  if ($numRooms <= 0 || !is_numeric($numRooms)) {
    addErrorMessage('Editing place failed! Number of rooms invalid!');
    die(header('Location: ../pages/house.php?id=${id}'));
  }

  if ($numBeds <= 0 || !is_numeric($numBeds)) {
    addErrorMessage('Editing place failed! Number of beds invalid!');
    die(header('Location: ../pages/house.php?id=${id}'));
  }

  if ($numBathrooms <= 0 || !is_numeric($numBathrooms)) {
    addErrorMessage('Editing place failed! Number of bathrooms invalid!');
    die(header('Location: ../pages/house.php?id=${id}'));
  }

  if(!editHouse($id,$country,$city,$address,$title,$description,round($price, 2),$capacity,$numRooms,$numBeds,$numBathrooms)){
    addErrorMessage('Editing place failed. Country is not valid!');
    die(header('Location: ../pages/house.php?id='.$id));
  }
    
  //save files
  if(isset($_FILES['fileUpload']))
    if(isset($_FILES['fileUpload']['name'][0]) && $_FILES['fileUpload']['size'][0] > 0){ //verifica se existe algum ficheiro , o total files da 1 com 1 ou 0 ficheiros n sei pq
    
        $total_files = count($_FILES['fileUpload']['name']);
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