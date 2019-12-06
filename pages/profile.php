<?php 
  include_once('../includes/session.php');
  include_once('../includes/htmlcleaner2000.php');
  include_once('../templates/tpl_common.php');
  include_once('../templates/tpl_profile.php');
  include_once('../database/db_users.php');
  include_once('../database/db_countries.php');
  include_once('../templates/tpl_houses.php');
  include_once('../database/db_houses.php');

  if (!isset($_SESSION['username']))
    die(header('Location: login.php'));

  $user = getUserInfo($_SESSION['username']);
  $houseList = getHousesFromOwner($user->username);
  $countryOptions = getAllCountries();
  
  
  $ppic = getUserPPic($user->username);

  draw_header($user->username, "../js/profile.js");
  draw_profile($user, $ppic, $countryOptions,$houseList);
  draw_footer();
?>