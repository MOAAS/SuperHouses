<?php
    include_once('../includes/database.php');

    function userExists($username) {
        $db = Database::instance()->db();

        $statement = $db->prepare('SELECT * FROM User WHERE username = ?');
        $statement->execute(array($username));
        return $statement->fetch() !== false;
    }

    function validCredentials($username, $password) {
        $db = Database::instance()->db();
        $statement = $db->prepare('SELECT passwordHash FROM User WHERE username = ?');
        $statement->execute(array($username));

        $user = $statement->fetch();
        return $user !== false && password_verify($password, $user['passwordHash']);
    }

    function addUser($username, $password, $name) {
        $db = Database::instance()->db();

        $statement = $db->prepare('INSERT INTO User Values (?, ?, ?, ?)');
        $statement->execute(array(NULL, $username, password_hash($password, PASSWORD_DEFAULT), $name));
    }

    function editUsername($username, $newUsername) {
        $db = Database::instance()->db();

        $statement = $db->prepare('UPDATE User SET username = ? WHERE username = ?');
        $statement->execute(array($newUsername, $username));
    }

    function editPassword($username, $newPassword) {
        $db = Database::instance()->db();

        $statement = $db->prepare('UPDATE User SET passwordHash = ? WHERE username = ?');
        $statement->execute(array(password_hash($newPassword, PASSWORD_DEFAULT), $username));
    }

?>