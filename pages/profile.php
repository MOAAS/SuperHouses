<?php 
  include_once('../includes/session.php');
  include_once('../includes/htmlcleaner2000.php');
  include_once('../templates/tpl_common.php');
  include_once('../templates/tpl_profile.php');
  include_once('../templates/tpl_houses.php');
  include_once('../database/db_users.php');
  include_once('../database/db_countries.php');
  include_once('../database/db_houses.php');
  include_once('../database/db_messages.php');
  include_once('../database/db_notifications.php');

  if (!isset($_SESSION['username']))
    die(header('Location: login.php'));

  draw_header($_SESSION['username'], "../js/profile.js");
  draw_profile($_SESSION['username']);
  draw_footer();
?>