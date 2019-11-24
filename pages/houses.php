<?php 
  include_once('../includes/session.php');
  include_once('../templates/tpl_common.php');
  include_once('../templates/tpl_houses.php');
  include_once('../database/db_houses.php');
  
  if (!isset($_SESSION['username']))
    die(header('Location: login.php'));

  draw_header($_SESSION['username']);
  $places = getAllHouses();
  draw_houselist($places);
  draw_footer();
?>