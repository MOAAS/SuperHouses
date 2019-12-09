<?php 
  include_once('../includes/session.php');
  include_once('../includes/htmlcleaner2000.php');
  include_once('../includes/sessionMessages.php');
  include_once('../templates/tpl_common.php');
  include_once('../templates/tpl_houses.php');
  include_once('../database/db_houses.php');
  include_once('../database/db_ratings.php');
  include_once('../database/db_notifications.php');
  include_once('../includes/sessionMessages.php');

  if (!isset($_SESSION['username']))
    die(header('Location: login.php'));

  $id = $_GET['id'];
  $house = getHouseByID($id);
  if($house == null) {
    addErrorMessage('The house you searched for is no longer available.');
    die(header('Location: search_houses.php'));
  }
    
  $pictures = getHousePhotoPathsByID($id);

  draw_header($_SESSION['username'], "../js/house.js");
  draw_house($_SESSION['username'], $house, $pictures);
  draw_footer();
?>