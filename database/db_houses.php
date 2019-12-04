<?php
    include_once('../includes/database.php');
    include_once('../includes/place.php');
    include_once('../database/db_countries.php');

    function getAllHouses() {
        $db = Database::instance()->db();

        $statement = $db->prepare(
            "SELECT Place.id,countryName,PlaceLocation.city,username,displayname,title,description,price,minPeople,maxPeople
            FROM Place, PlaceLocation, Country, User 
            WHERE Place.location=PlaceLocation.id AND PlaceLocation.country = Country.id"
        );
        $statement->execute();

        $places = array();
        foreach($statement->fetchAll() as $place) {
            array_push($places, new Place($place['id'], $place['countryName'], $place['city'], $place['address'], $place['username'], $place['displayname'], $place['title'], $place['description'], $place['price'], $place['minPeople'], $place['maxPeople']));
        }

        return $places;
    }

    function getHousesFromOwner($username) {
        $db = Database::instance()->db();

        $statement = $db->prepare(
            "SELECT Place.id,countryName,PlaceLocation.city,address,username,displayname,title,description,price,minPeople,maxPeople
            FROM Place, PlaceLocation, Country, User 
            WHERE Place.location = PlaceLocation.id AND PlaceLocation.country = Country.id AND Place.owner = User.id AND User.username = ?"
        );
        $statement->execute(array($username));

        $places = array();
        foreach($statement->fetchAll() as $place) {
            array_push($places, new Place($place['id'], $place['countryName'], $place['city'], $place['address'], $place['username'], $place['displayname'], $place['title'], $place['description'], $place['price'], $place['minPeople'], $place['maxPeople']));
        }

        return $places;
    }

    function getHouseById($house_id) {
        $db = Database::instance()->db();

        $statement = $db->prepare(
            "SELECT countryName,PlaceLocation.city,address,username,displayname,title,description,price,minPeople,maxPeople
            FROM Place, PlaceLocation, Country, User 
            WHERE Place.location = PlaceLocation.id AND PlaceLocation.country = Country.id AND Place.owner = User.id AND Place.id = ?"
        );
        $statement->execute(array($house_id));

        $place = $statement->fetch();
        
        if ($place == false)
            return null;

        return new Place($house_id, $place['countryName'], $place['city'], $place['address'], $place['username'], $place['displayname'], $place['title'], $place['description'], $place['price'], $place['minPeople'], $place['maxPeople']);
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

    function searchHouses($location, $startDate, $endDate, $maxPrice, $numGuests, $numBabies) {
        $db = Database::instance()->db();
        $statement = $db->prepare(
            "SELECT Place.id, title, price, minPeople, maxPeople, countryName, PlaceLocation.city, address, description, username, displayname
            FROM Place JOIN PlaceLocation ON Place.location=PlaceLocation.id JOIN Country ON PlaceLocation.country = Country.id JOIN User ON Place.owner = User.id
            WHERE price < ? AND ? <= maxPeople AND (countryName LIKE ? OR PlaceLocation.city LIKE ?) AND Place.id NOT IN (
                SELECT id 
                FROM Reservation
                WHERE place = Place.id AND dateStart < ? AND dateEnd > ?
            )
            ORDER BY price
            "           
        );

        $location = str_replace("\\", "\\\\", $location);;
        $location = str_replace("%", "\%", $location);;
        $location = str_replace("_", "\_", $location);;
        
        $statement->execute(array($maxPrice, $numGuests + $numBabies / 2, "%" . $location . "%", "%" . $location . "%", $endDate, $startDate));
        
        $results = $statement->fetchAll();
        $places = array();
        foreach($results as $place) {
            array_push($places, new Place($place['id'], $place['countryName'], $place['city'], $place['address'], $place['username'], $place['displayname'], $place['title'], $place['description'], $place['price'], $place['minPeople'], $place['maxPeople']));
        }

        return $places;
    }

    function getNewHouseId() {
        $db = Database::instance()->db();

        $statement = $db->prepare( "SELECT max(ID) FROM Place;");
        $statement->execute();
        $id = $statement->fetch();
        if($id['max(ID)']==null)
            return 0;
        return $id['max(ID)']+1;
    }
    
    function getNewPlaceLocId() {
        $db = Database::instance()->db();

        $statement = $db->prepare( "SELECT max(ID) FROM PlaceLocation;");
        $statement->execute();
        $maxplaceid = $statement->fetch();
        if($maxplaceid['max(ID)']==null)
            return 0;
        return $maxplaceid['max(ID)']+1;
    }

    function addHouse($id, $country, $city, $address, $owner, $title, $description, $price, $min,  $max) {
        $db = Database::instance()->db();

        $newplaceid = getNewPlaceLocId();

        $countryID = getCountryID($country);
        if ($countryID == false)
            return false;
       // echo $countryID;

        $statement2 = $db->prepare('INSERT INTO PlaceLocation Values (?, ?, ?, ?)');
        $statement2->execute(array($newplaceid,$countryID,$city,$address));
        //$statement2->execute(array(5,1,'teste','23sadas'));

        $statement3 = $db->prepare('INSERT INTO Place Values (?, ?, ?, ?, ?, ?, ?, ?)');
        $statement3->execute(array($id, $newplaceid, $owner, $title, $description, $price, $min, $max));
        //$statement3->execute(array(12, 1, 1, 'casa','sssss', 32, 1, 2));
    }
?>