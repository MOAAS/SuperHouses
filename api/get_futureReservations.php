<?php
    include_once('../includes/session.php');
    include_once('../database/db_reservations.php');

    echo json_encode(getFutureReservations($_GET['placeID']));
?>