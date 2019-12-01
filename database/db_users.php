<?php
    include_once('../includes/database.php');
    include_once('../includes/userinfo.php');
    include_once('../database/db_countries.php');

    function getUserID($username) {
        $db = Database::instance()->db();

        $statement = $db->prepare('SELECT id FROM User WHERE username = ?');
        $statement->execute(array($username));

        return $statement->fetch()['id'];
    }
    
    function updateUserInfo($userInfo) {
        $db = Database::instance()->db();

        $countryID = getCountryID($userInfo->country);

        if ($countryID == false)
            $countryID = NULL;

        $statement = $db->prepare('UPDATE User SET displayname = ?, country = ?, city = ? WHERE username = ?');
        $statement->execute(array($userInfo->displayname, $countryID, $userInfo->city, $userInfo->username));
    }

    function getUserInfo($username) {
        $db = Database::instance()->db();

        $statement = $db->prepare('SELECT username, displayname, country, city FROM User WHERE username = ?');
        $statement->execute(array($username));

        $user = $statement->fetch();

        if ($user['country'] == NULL)
            $country = "";
        else $country = getCountryByID($user['country']);

        return new UserInfo($user['username'], $user['displayname'], $country, $user['city']);
    }

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

        $statement = $db->prepare('INSERT INTO User Values (?, ?, ?, ?, NULL, NULL)');
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