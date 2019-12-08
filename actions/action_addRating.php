<?php
    include_once('../includes/session.php');
    
    include_once('../database/db_reservations.php');
    include_once('../database/db_ratings.php');


    $username = $_SESSION['username'];
    $reservationID = $_POST['reservationID'];
    $content = $_POST['content'];
    $numStars = $_POST['numStars'];

    if ($content == "" || $content == null) {
        echo "Can't send empty comments";
        return;
    }

    if ($numStars < 1 || $numStars > 5) {
        echo "Must rate from 1 to 5, rated $numStars";
        return;
    }

    $reservation = getReservationByID($reservationID);
    if (!$reservation->recentlyEnded()) {
        echo "Reservation must have been recently ended to be reviewed";
        return;
    }

    if ($reservation == null) {
        echo "Reservation does not exist";
        return;
    }
    
    if (getReservationHost($reservationID) == $username) {
        echo "The host cannot review his own house";
        return;
    }
    
    $rating = getReservationRating($reservationID);

    if ($rating != false) {
        echo "Reservation has already been rated!";
        return;
    }

    addReservationRating($reservationID, $numStars, $content);    
?>