<?php
    include_once('../includes/database.php');
    include_once('../includes/notification.php');
    include_once('../database/db_users.php');

    function sendNotification($username, $content, $link) {
        $db = Database::instance()->db();

        $statement = $db->prepare('INSERT INTO UserNotification VALUES (NULL, ?, ?, ?, ?, 0)');

        $statement->execute(array($link, $content, date('Y-m-d'), getUserID($username)));
    }
    
    function setNotificationSeen($id) {
        $db = Database::instance()->db();

        $statement = $db->prepare(
            'UPDATE UserNotification
            SET seen = 1
            WHERE UserNotification.id = ?'
        );

        $statement->execute(array($id));
    }

    function getNotificationByID($id) {
        $db = Database::instance()->db();

        $statement = $db->prepare(
            'SELECT User.username, UserNotification.link
            FROM UserNotification JOIN User ON user = User.id
            WHERE UserNotification.id = ?'
        );

        $statement->execute(array($id));

        return $statement->fetch();
    }

    function getUnseenNotifications($username) {
        $db = Database::instance()->db();

        $statement = $db->prepare(
            'SELECT UserNotification.id, content, dateTime 
            FROM UserNotification JOIN User ON user = User.id
            WHERE username = ? AND seen = 0
            ORDER BY dateTime DESC'
        );

        $statement->execute(array($username));

        $rows = $statement->fetchAll();
        $notifs = array();
        foreach($rows as $row)
            array_push($notifs, new Notification($row['id'], $row['content'], $row['dateTime']));

        return $notifs;
    }
?>