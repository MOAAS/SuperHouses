<?php 
    include_once('../includes/session.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_houses.php');
    include_once('../database/db_users.php');
    include_once('../database/db_countries.php');

    // Verify if user is logged in
    if (!isset($_SESSION['username']))
        die(header('Location: login.php'));

    $countryOptions = getAllCountries();
    $user = getUserInfo($_SESSION['username']);
    draw_header($user->username, null);

    draw_addHouse($countryOptions);
    draw_footer();
?>