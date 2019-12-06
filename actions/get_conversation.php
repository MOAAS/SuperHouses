<?php
    include_once('../includes/session.php');
    include_once('../database/db_messages.php');

    if (getUserID($_GET['otherUser']) == false)
        return;

    echo json_encode(getMessagesBetween($_GET['otherUser'], $_SESSION['username']));

    setSeenMessagesFrom($_GET['otherUser'], $_SESSION['username']);
?>