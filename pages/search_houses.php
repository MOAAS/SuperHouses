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

  if (!isset($_GET['location'])) $_GET['location'] = "";
  if (!isset($_GET['startDate'])) $_GET['startDate'] = "";
  if (!isset($_GET['endDate'])) $_GET['endDate'] = "";
  if (!isset($_GET['maxPrice'])) $_GET['maxPrice'] = 500;  
  if (!isset($_GET['numAdults'])) $_GET['numAdults'] = 0;
  if (!isset($_GET['numChildren'])) $_GET['numChildren'] = 0;
  if (!isset($_GET['numBabies'])) $_GET['numBabies'] = 0;

  $location = $_GET['location'];
  $startDate = $_GET['startDate'];
  $endDate = $_GET['endDate'];
  $maxPrice = $_GET['maxPrice'];
  $numAdults = $_GET['numAdults'];
  $numChildren = $_GET['numChildren'];
  $numBabies = $_GET['numBabies'];

  if (!is_numeric($maxPrice)) $maxPrice = 500;
  if (!is_numeric($numAdults)) $numAdults = 0;
  if (!is_numeric($numChildren)) $numChildren = 0;
  if (!is_numeric($numBabies)) $numBabies = 0;

  $places = searchHouses($location, $startDate, $endDate, $maxPrice, $numAdults + $numChildren, $numBabies);

  draw_header("searchHousesPage",$_SESSION['username'], ["../dependencies/pikaday/pikaday.js", "../js/search.js"]);
  draw_searchPage($location, $startDate, $endDate, $maxPrice, $numAdults, $numChildren, $numBabies);
  draw_houselist($places,false);
  draw_footer();
?>