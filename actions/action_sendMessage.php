<?php
    include_once('../includes/session.php');
    
    include_once('../database/db_users.php');
    include_once('../database/db_messages.php');
    include_once('../database/db_notifications.php');


    $sender = $_SESSION['username'];
    $receiver = $_POST['receiverUsername'];
    $content = $_POST['content'];

    if ($content == "")
        return;

    if (getUserID($sender) == false) {
        echo "Couldn't find sender user: $sender";
        return;
    }
    
    if (getUserID($receiver) == false) {
        echo "Couldn't find receiver user: $receiver";
        return;
    }

    if ($receiver == $sender) {
        echo "Sender can't be receiver!";
        return;
    }
    
    sendMessage($sender, $receiver, $content);      
    sendNotification($receiver, "You received a message from " . $sender . "!", "../pages/profile.php#Conversation%20" . $sender);
    
?>