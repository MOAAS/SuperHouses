<?php
    include_once('../includes/session.php');
    include_once('../database/db_notifications.php');


    if ($_SESSION['username'] != getNotificationUsername($_POST['notif_id'])) {
        echo "You filthy animal trying to hack this very secure website";
        return;
    }

    setNotificationSeen($_POST['notif_id']);

    
?>