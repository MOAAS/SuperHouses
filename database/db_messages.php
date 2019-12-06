<?php
    include_once('../includes/database.php');
    include_once('../includes/messages.php');
    include_once('../database/db_users.php');
    include_once('../database/db_notifications.php');

    function sendMessage($senderUsername, $receiverUsername, $content) {
        $db = Database::instance()->db();

        $statement = $db->prepare('INSERT INTO UserMessage VALUES (NULL, ?, ?, 0, ?, ?)');

        $senderID = getUserID($senderUsername);
        $receiverID = getUserID($receiverUsername);

        $statement->execute(array($content, date('Y-m-d H:i:s'), $senderID, $receiverID));
        sendNotification($receiverUsername, "You received a message from " . $senderUsername . "!");
    }
    
    function setSeenMessagesBetween($otherUser, $username) {
        $db = Database::instance()->db();

        $otherID = getUserId($otherUser);
        $userID = getUserId($username);
        $statement = $db->prepare(
            'UPDATE UserMessage
            SET seen = 1
            WHERE (UserMessage.sender = ? AND UserMessage.receiver = ?)
               OR (UserMessage.sender = ? AND UserMessage.receiver = ?)'
        );

        $statement->execute(array($userID, $otherID, $otherID, $userID));
    }

    function getConversations($username) {
        $db = Database::instance()->db();

        $userID = getUserId($username);

        $statement = $db->prepare(
            'SELECT max(sendTime) AS sendTime, content, username, seen, wasSent
            FROM (
                SELECT max(sendTime) AS sendTime, content, username, seen, 0 AS wasSent
                FROM UserMessage JOIN User ON UserMessage.sender = User.id
                WHERE receiver = ?
                GROUP BY username

                UNION

                SELECT max(sendTime) AS sendTime, content, username, seen, 1 AS wasSent
                FROM UserMessage JOIN User ON UserMessage.receiver = User.id
                WHERE sender = ?
                GROUP BY username
            )
            GROUP BY username'            
        );

        $statement->execute(array($userID, $userID));

        $messages = array();
        foreach($statement->fetchAll() as $message)
            array_push($messages, new  UserMessage($message['content'], $message['seen'], $message['sendTime'], $message['wasSent'], $username, $message['username']));

        return $messages;
    }
    
    function getMessagesBetween($otherUsername, $username) {
        $db = Database::instance()->db();

        $userID = getUserId($username); // oi
        $otherID = getUserId($otherUsername); // marco

        $statement = $db->prepare(
            'SELECT id, sendTime, content, seen, 0 AS wasSent
            FROM UserMessage
            WHERE receiver = ? AND sender = ?

            UNION

            SELECT id, sendTime, content, seen, 1 AS wasSent
            FROM UserMessage
            WHERE receiver = ? AND sender = ?
            '
        );


        $statement->execute(array($userID, $otherID, $otherID, $userID));

        $messages = array();
        foreach($statement->fetchAll() as $message)
            array_push($messages, new  UserMessage($message['content'], $message['seen'], $message['sendTime'], $message['wasSent'], $username, $otherUsername));

        return $messages;
    }
?>