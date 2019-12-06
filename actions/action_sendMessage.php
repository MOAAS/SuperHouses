<?php
    include_once('../includes/session.php');
    
    include_once('../database/db_users.php');
    include_once('../database/db_messages.php');


    $sender = $_SESSION['username'];
    $receiver = $_POST['receiverUsername'];
    $content = $_POST['content'];

    if ($content == "")
        return;

    if (getUserID($sender == false)) {
        echo "Couldn't find sender user: $sender";
    }
    
    if (getUserID($receiver == false)) {
        echo "Couldn't find receiver user: $receiver";
    }
    
    sendMessage($sender, $receiver, $content);    
?>