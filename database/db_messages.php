<?php
    include_once('../includes/database.php');
    include_once('../database/db_users.php');
    include_once('../database/db_notifications.php');
    function sendMessage($senderUsername, $receiverUsername, $content) {
        $db = Database::instance()->db();

        $statement = $db->prepare('INSERT INTO UserMessage VALUES (NULL, ?, ?, 0, ?, ?)');

        $statement->execute(array($content, date('Y-m-d H:i:s'), getUserID($senderUsername), getUserID($receiverUsername)));
        sendNotification($receiverUsername, "You received a message from " . $senderUsername . "!");
    }
    
    function setSeenMessagesFrom($senderUsername, $username) {
        $db = Database::instance()->db();

        $senderID = getUserId($senderUsername);
        $receiverID = getUserId($username);
        $statement = $db->prepare(
            'UPDATE UserMessage
            SET seen = 1
            WHERE UserMessage.sender = ? AND UserMessage.receiver = ?'
        );

        $statement->execute(array($senderID, $receiverID));
    }

    function getLatestMessages($username) {
        $db = Database::instance()->db();

        $userID = getUserId($username);

        $statement = $db->prepare(
            'SELECT max(sendTime) AS sendTime, id, content, sender AS person, seen, 0 AS wasSent
            FROM UserMessage
            WHERE receiver = ?
            GROUP BY sender

            UNION

            SELECT max(sendTime) AS sendTime, id, content, receiver AS person, seen, 1 AS wasSent
            FROM UserMessage
            WHERE sender = ?
            GROUP BY receiver
            '
        );

        $statement->execute(array($userID, $userID));

        return $statement->fetchAll();
    }
    
    function getMessagesFrom($senderUsername, $username) {
        $db = Database::instance()->db();

        $senderID = getUserId($senderUsername);
        $receiverID = getUserId($username);
        $statement = $db->prepare(
            'SELECT id, content, sendTime, seen,
            FROM UserMessage
            WHERE sender = ? AND receiver = ?'
        );

        $statement->execute(array($senderID, $receiverID));

        return $statement->fetchAll();
    }
    //SELECT UserMessage.id, UserMessage.content, UserSender.username, UserReceiver.username, sendTime, seen FROM UserMessage JOIN User AS UserSender ON UserSender.id = UserMessage.sender JOIN User AS UserReceiver ON UserReceiver.id = UserMessage.receiver;
    //SELECT Receiver FROM Message Where Sender = 1 UNION SELECT Sender FROM Message Where Receiver = 1
?>