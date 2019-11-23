<?php
    include_once('../includes/database.php');
    
    function getCountryByID($id) {
        $db = Database::instance()->db();

        $statement = $db->prepare('SELECT countryName FROM Country WHERE id = ?');
        $statement->execute(array($id));

        return $statement->fetch()['countryName'];
    }

    function getCountryID($name) {
        $db = Database::instance()->db();

        $statement = $db->prepare('SELECT id FROM Country WHERE countryName = ?');
        $statement->execute(array($name));

        return $statement->fetch()['id'];
    }

    function getAllCountries() {
        $db = Database::instance()->db();
       
        $statement = $db->prepare('SELECT countryName FROM Country ORDER BY countryName');
        $statement->execute();

        return array_column($statement->fetchAll(), 'countryName');
    }

?>