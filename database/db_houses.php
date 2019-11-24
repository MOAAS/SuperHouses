<?php
    include_once('../includes/database.php');
    include_once('../includes/place.php');

    function getAllHouses() {
        $db = Database::instance()->db();

        $statement = $db->prepare('SELECT countryName,PlaceLocation.city,address,owner,title,description,price FROM Place, PlaceLocation, Country, User WHERE Place.location=PlaceLocation.id AND PlaceLocation.country = Country.id AND Place.owner=User.id');
        $statement->execute();

        return $statement->fetchAll();
    }

    function getHouseByID($house_id) {
        $db = Database::instance()->db();

        $statement = $db->prepare('SELECT countryName,PlaceLocation.city,address,owner,title,description,price FROM Place, PlaceLocation, Country, User WHERE Place.location=PlaceLocation.id AND PlaceLocation.country = Country.id AND Place.owner=User.id AND Place.id = ?');
        $statement->execute(array($house_id));

        $place = $statement->fetch();

        return new Place($house_id, $place['countryName'], $place['city'], $place['address'], $place['owner'], $place['title'], $place['description'], $place['price']);
    }

    function getHousePhotoPathsByID($house_id) {
        $paths = array();
        $dir = new DirectoryIterator("../database/houseImages/".$house_id);
        foreach ($dir as $fileinfo) {
            if ($fileinfo->isDot()) continue;
            array_push($paths, "../database/houseImages/".$house_id."/".$fileinfo->getFileName());
        }
        return $paths;
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