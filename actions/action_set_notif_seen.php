<?php
    include_once('../includes/session.php');
    include_once('../database/db_notifications.php');


    $notification = getNotificationByID($_POST['notif_id']);
    if ($notification == false || $_SESSION['username'] != $notification['username']) {
        echo "This one is not for you";
        return;
    }

    setNotificationSeen($_POST['notif_id']);
    
?>