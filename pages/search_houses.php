<?php 
  include_once('../includes/session.php');
  include_once('../templates/tpl_common.php');
  include_once('../templates/tpl_houses.php');
  include_once('../templates/tpl_search.php');
  include_once('../database/db_houses.php');

  if (!isset($_SESSION['username']))
    die(header('Location: login.php'));

  $location = $_GET['location'];
  $startDate = $_GET['startDate'];
  $endDate = $_GET['endDate'];
  $maxPrice = $_GET['maxPrice'];
  $numGuests = $_GET['numAdults'] + $_GET['numChildren'];
  $numBabies = $_GET['numBabies'];
  $places = getHouses($location, $startDate, $endDate, $maxPrice, $numGuests, $numBabies);

  draw_header($_SESSION['username']);
  draw_search();
  draw_houselist($places);
  draw_footer();
?>