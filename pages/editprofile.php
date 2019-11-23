<?php 
  include_once('../includes/session.php');
  include_once('../templates/tpl_common.php');
  include_once('../templates/tpl_profile.php');

  if (!isset($_SESSION['username']))
    die(header('Location: login.php'));

  draw_header($_SESSION['username']);
  draw_profileedit($_SESSION['username']);
  draw_footer();
?>