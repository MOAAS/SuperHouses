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
  $min = $_POST['min'];
  $max = $_POST['max'];

  $username = $_SESSION['username'];
  $ownerId = getUserId($username);
  // verificar se price > 0
  // verificar se price min max sao numeros
  // verificar se min <= max
  // verificar se addhouse retorna false
  addHouse($id,$country,$city,$address,$ownerId,$title,$description,$price,$min,$max);


  //print_r($ownerId);
  //echo $ownerId;

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