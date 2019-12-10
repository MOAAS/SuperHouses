<?php
    include_once('../includes/session.php');
    include_once('../database/db_reservations.php');
    include_once('../database/db_notifications.php');

    $reservation_id = $_POST['reservationID'];

    $reservation = getReservationByID($reservation_id);

    $guestUsername = $reservation->getGuest();
    $hostUsername = $reservation->getPlace()->ownerUsername;

    if ($reservation->isApproaching()) {
        echo "Reservation is approaching";
        return;
    }

    if ($guestUsername != $_SESSION['username'] && $hostUsername != $_SESSION['username']) {
        echo "No permission to remove reservation, Mr./Mrs. " . $_SESSION['username'];
        return;
    }

    removeReservation($reservation_id);
    
    if ($guestUsername == $_SESSION['username']) { 
        // If guest cancelled
        echo 'guest CANCELLD';
        sendNotification(
            $hostUsername, 
            $guestUsername . " cancelled a reservation for " . $reservation->getStartString() . " (" . $reservation->getPlace()->title . ")", 
            "../pages/profile.php#Conversation%20" . $guestUsername
        );
    }
    else {
        // If host cancelled
        echo 'HOST CANCELLD';
        sendNotification(
            $guestUsername, 
            $hostUsername . " cancelled your reservation for " . $reservation->getStartString() . " (" . $reservation->getPlace()->title . ")", 
            "../pages/profile.php#Conversation%20" . $guestUsername
        );
    }

    
?>