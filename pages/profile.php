<?php 
  include_once('../includes/session.php');
  include_once('../includes/htmlcleaner2000.php');
  include_once('../templates/tpl_common.php');
  include_once('../templates/tpl_profile.php');
  include_once('../database/db_users.php');
  include_once('../database/db_countries.php');

  if (!isset($_SESSION['username']))
    die(header('Location: login.php'));

  $user = getUserInfo($_SESSION['username']);
  $countryOptions = getAllCountries();

  draw_header($user->username, null);
  draw_profile($user, $countryOptions);
  draw_footer();
?>