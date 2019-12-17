<?php
    include_once('../includes/session.php');
    
    include_once('../database/db_reservations.php');
    include_once('../database/db_ratings.php');
    include_once('../database/db_notifications.php');

    $username = $_SESSION['username'];
    $reservationID = $_POST['reservationID'];
    $content = $_POST['content'];
    $numStars = $_POST['numStars'];

    if ($content == "" || $content == null) {
        echo "Can't send empty comments";
        return;
    }

    if (!is_numeric($numStars) || $numStars < 1 || $numStars > 5) {
        echo "Must rate from 1 to 5, rated $numStars";
        return;
    }

    $reservation = getReservationByID($reservationID);
    if ($reservation == null) {
        echo "Reservation does not exist";
        return;
    }  

    if (!$reservation->hasEnded()) {
        echo "Reservation must have ended to be reviewed";
        return;
    }
    
    if (getReservationHost($reservationID) == $username) {
        echo "The host cannot review his own house";
        return;
    }

    if ($reservation->getGuest() != $username) {
        echo "This is not your reservation!";
        return;        
    }
    
    $rating = getReservationRating($reservationID);

    if ($rating != false) {
        echo "Reservation has already been rated!";
        return;
    }

    addReservationRating($reservationID, $numStars, $content);    
    sendNotification(
        $reservation->getPlace()->ownerUsername, 
        $_SESSION['username'] . " rated a place you listed!",
        "../pages/house.php?id=" . $reservation->getPlace()->place_id . '#' . $reservationID);

?>