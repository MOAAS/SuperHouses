<?php 
  include_once('../includes/session.php');
  include_once('../includes/htmlcleaner2000.php');
  include_once('../templates/tpl_common.php');
  include_once('../templates/tpl_houses.php');
  include_once('../database/db_houses.php');
  include_once('../database/db_notifications.php');

  if (!isset($_SESSION['username']))
    die(header('Location: login.php'));

  $id = $_GET['id'];
  $house = getHouseByID($id);
  if($house ==null)
    die(header('Location: search_houses.php'));
    
  $pictures = getHousePhotoPathsByID($id);

  draw_header($_SESSION['username'], "../js/house.js");
  draw_house($house, $pictures);
  draw_footer();
?>