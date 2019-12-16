<?php 
  include_once('../includes/session.php');
  include_once('../includes/htmlcleaner2000.php');
  include_once('../templates/tpl_common.php');
  include_once('../templates/tpl_houses.php');
  include_once('../templates/tpl_search.php');
  include_once('../database/db_houses.php');
  include_once('../database/db_notifications.php');

  if (!isset($_SESSION['username']))
    die(header('Location: login.php'));
  
  draw_header('mainPage',$_SESSION['username'], ["../dependencies/pikaday/pikaday.js", "../js/search.js"]);
  draw_main();
  draw_footer();