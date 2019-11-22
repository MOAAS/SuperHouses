<?php 
  include_once('../includes/session.php');
  include_once('../templates/tpl_common.php');
  include_once('../templates/tpl_houses.php');
  
  if (!isset($_SESSION['username']))
    die(header('Location: login.php'));

  draw_header($_SESSION['username']);
  draw_houselist();
  draw_footer();
?>