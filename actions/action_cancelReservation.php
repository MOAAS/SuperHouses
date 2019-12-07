<?php
    include_once('../includes/session.php');
    include_once('../database/db_reservations.php');

    $reservation_id = $_POST['reservationID'];

    $reservation = getReservationByID($reservation_id);
    if ($reservation->isApproaching()) {
        echo "Reservation is approaching";
        return;
    }

    if ($reservation->getGuest() != $_SESSION['username'] && $reservation->getPlace()->ownerUsername != $_SESSION['username']) {
        echo "No permission to remove reservation, Mr. " . $_SESSION['username'];
        return;
    }

    removeReservation($reservation_id);

    
?>