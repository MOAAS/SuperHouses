<?php
    include_once('../includes/database.php');
    
    function validCredentials($username, $password) {
        $db = Database::instance()->db();
        $statement = $db->prepare('SELECT password FROM User WHERE username = ?');
        $statement->execute(array($username));

        $user = $statement->fetch();
        return $user !== false && password_verify($password, $user['password']);
    }

    function addUser($username, $password, $name) {
        $db = Database::instance()->db();

        $statement = $db->prepare('SELECT * FROM User WHERE username = ?');
        $statement->execute(array($username));
        if ($statement->fetch() !== false)
            return false;

        $statement = $db->prepare('INSERT INTO User Values (?, ?, ?)');
        $statement->execute(array($username, password_hash($password, PASSWORD_DEFAULT), $name));
        return true;
    }

?>