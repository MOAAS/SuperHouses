<?php
    include_once('../includes/database.php');

    function getAllHouses() {
        $db = Database::instance()->db();

        //$statement = $db->prepare('SELECT title,price,countryName,city,address FROM Place NATURAL JOIN PlaceLocation NATURAL JOIN Country');
        $statement = $db->prepare('SELECT title,price,countryName,city,address FROM Place JOIN PlaceLocation ON Place.location=PlaceLocation.id JOIN Country ON PlaceLocation.country = Country.id');
        $statement->execute();

        return $statement->fetchAll();
    }
/*
    function getAllHousesLocation($location){
        $db = Database::instance()->db();

        $statement = $db->prepare('SELECT title,price,countryName,city,address FROM Place NATURAL JOIN PlaceLocation NATURAL JOIN Country WHERE
        countryName LIKE '%?%' OR city LIKE '%?%' OR address LIKE '%?%'');
        $statement->execute(array($location));

        return $statement->fetchAll();
    }
*/
?>