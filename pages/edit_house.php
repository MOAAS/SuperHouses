<?php 
  include_once('../includes/session.php');
  include_once('../includes/htmlcleaner2000.php');
  include_once('../templates/tpl_common.php');
  include_once('../templates/tpl_houses.php');
  include_once('../templates/tpl_profile.php');
  include_once('../database/db_houses.php');
  include_once('../database/db_ratings.php');
  include_once('../database/db_notifications.php');

  if (!isset($_SESSION['username']))
    die(header('Location: login.php'));
  
  
  $id = $_GET['id'];
  $house = getHouseByID($id);

  $pictures = getHousePhotoPathsByID($id);

  draw_header($_SESSION['username'], null);
  draw_editHouse($house, $pictures);
  draw_footer();
  ?>