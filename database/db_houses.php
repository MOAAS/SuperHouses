<?php
    include_once('../includes/database.php');
    
    function getHouse($id) {
        $db = Database::instance()->db();
        
        $statement = $db->prepare(
            "SELECT Place.id, title, price, minPeople, maxPeople, countryName, city 
            FROM Place JOIN PlaceLocation ON Place.location=PlaceLocation.id JOIN Country ON PlaceLocation.country = Country.id
            WHERE Place.id = ?"       
        );

        $statement->execute(array($id));
        return $statement->fetchAll();        
    }

    function searchHouses($location, $startDate, $endDate, $maxPrice, $numGuests, $numBabies) {
        $db = Database::instance()->db();
        $statement = $db->prepare(
            "SELECT Place.id, title, price, minPeople, maxPeople, countryName, city 
            FROM Place JOIN PlaceLocation ON Place.location=PlaceLocation.id JOIN Country ON PlaceLocation.country = Country.id
            WHERE price < ? AND ? <= maxPeople AND (countryName LIKE ? OR city LIKE ?) AND Place.id NOT IN (
                SELECT id 
                FROM Reservation
                WHERE place = Place.id AND dateStart < ? AND dateEnd > ?
            )
            ORDER BY price
            "           
        );
        
        $statement->execute(array($maxPrice, $numGuests + $numBabies / 2, "%" . $location . "%", "%" . $location . "%", $endDate, $startDate));
        return $statement->fetchAll();
    }
?>