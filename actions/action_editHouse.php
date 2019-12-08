<?php
  include_once('../includes/session.php');   
  include_once('../includes/sessionMessages.php');
  include_once('../database/db_houses.php');
  include_once('../database/db_users.php');
  
  $id = $_GET['id'];

  $title = $_POST['title'];
  $description = $_POST['description'];
  $country = $_POST['country'];
  $city = $_POST['city'];
  $address = $_POST['address'];
  $price = $_POST['price'];
  $min = $_POST['min'];
  $max = $_POST['max'];
  $numRooms = $_POST['numRooms'];
  $numBeds = $_POST['numBeds'];
  $numBathrooms = $_POST['numBathrooms'];

  $username = $_SESSION['username'];
  $ownerId = getUserId($username);
  // verificar se price > 0
  if ($price <= 0 || !is_numeric($price)) {
    addErrorMessage('Editing place failed! Price invalid!');
    die(header('Location: ../pages/house.php?id=${id}'));
  }
  if ($min <= 0 || !is_numeric($min)) {
    addErrorMessage('Editing place failed! Minimum capacity invalid!');
    die(header('Location: ../pages/house.php?id=${id}'));
  }

  if ($max <= 0 || !is_numeric($max)) {
    addErrorMessage('Editing place failed! Maximum capacity invalid!');
    die(header('Location: ../pages/house.php?id=${id}'));
  }

  if ($min > $max) {
    addErrorMessage('Editing place failed! Minimum capacity is bigger than Maximum!');
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

  editHouse($id,$country,$city,$address,$title,$description,$price,$min,$max,$numRooms,$numBeds,$numBathrooms);
    
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