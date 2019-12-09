<?php
    include_once('../includes/session.php');
    
    include_once('../database/db_reservations.php');
    include_once('../database/db_ratings.php');
    include_once('../database/db_notifications.php');


    $username = $_SESSION['username'];
    $reservationID = $_POST['reservationID'];
    $content = $_POST['content'];

    if ($content == "" || $content == null) {
        echo "Can't send empty comments";
        return;
    }

    $rating = getReservationRating($reservationID);

    if ($rating == false) {
        echo "Rating does not exist!";
        return;
    }

    if ($rating['reply'] != NULL) {
        echo "Reservation already has a reply";
        return;
    }

    if ($username == null || getReservationHost($reservationID) != $username) {
        echo "You're not this reservation's host";
        return;
    }

    setReservationReply($reservationID, $content);    
    sendNotification(
        $reservation->getGuest(), 
        $_SESSION['username'] . " replied to your comment on " . $reservation->getPlace()->title . "!",
        "../pages/house.php?id=" . $reservation->getPlace()->place_id);
?>