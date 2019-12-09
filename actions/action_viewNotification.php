<?php
    include_once('../includes/session.php');
    include_once('../database/db_notifications.php');

    $notifID = $_GET['id'];
    $notification = getNotificationByID($notifID);
    if ($notification == false || $_SESSION['username'] != $notification['username']) {
        sendErrorMessage("This notification is not for you!");
        die(header('Location: ../pages/profile.php'));
    }

    setNotificationSeen($notifID);
    die(header('Location: ' . $notification['link']))    
?>