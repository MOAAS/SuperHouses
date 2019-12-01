<?php
    include_once('../includes/database.php');
    
    function getUnseenNotifications($username) {
        $db = Database::instance()->db();

        $statement = $db->prepare(
            'SELECT * 
            FROM UserNotification JOIN User ON user = User.id
            WHERE username = ? AND seen = 0'
        );

        $statement->execute(array($username));

        return $statement->fetchAll();
    }
?>