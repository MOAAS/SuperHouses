<?php
include_once('../includes/database.php');
include_once('../includes/place.php');
include_once('../database/db_countries.php');

function makePlaceArray($rows)
{
    $places = array();
    foreach ($rows as $place) {
        array_push(
            $places,
            new Place(
                $place['id'],
                $place['countryName'],
                $place['city'],
                $place['address'],
                $place['ownerUsername'],
                $place['ownerName'],
                $place['title'],
                $place['description'],
                $place['pricePerDay'],
                $place['capacity'],
                $place['numRooms'],
                $place['numBeds'],
                $place['numBathrooms']
            )
        );
    }

    return $places;
}

function getHousesFromOwner($username)
{
    $db = Database::instance()->db();

    $statement = $db->prepare(
        "SELECT *
            FROM PlaceComplete
            WHERE ownerUsername = ?"
    );
    $statement->execute(array($username));

    return makePlaceArray($statement->fetchAll());
}

function getHouseById($house_id)
{
    $db = Database::instance()->db();

    $statement = $db->prepare(
        "SELECT *
            FROM PlaceComplete
            WHERE id = ?"
    );
    $statement->execute(array($house_id));

    $place = $statement->fetch();

    if ($place == false)
        return null;

    return makePlaceArray(array($place))[0];
}

function getHousePhotoPathsByID($house_id)
{
    $paths = array();
    $dir = new DirectoryIterator("../database/houseImages/" . $house_id);
    foreach ($dir as $fileinfo) {
        if ($fileinfo->isDot()) continue;
        array_push($paths, "../database/houseImages/" . $house_id . "/" . $fileinfo->getFileName());
    }
    return $paths;
}

function searchHouses($location, $startDate, $endDate, $maxPrice, $numGuests, $numBabies)
{
    $db = Database::instance()->db();
    $statement = $db->prepare(
        "SELECT *
            FROM PlaceComplete
            WHERE pricePerDay <= ? AND ? <= capacity AND (countryName LIKE ? OR city LIKE ?) AND PlaceComplete.id NOT IN (
                SELECT place
                FROM Reservation
                WHERE place = PlaceComplete.id AND dateStart < ? AND dateEnd > ?
            )
            ORDER BY pricePerDay
            "
    );

    $location = str_replace("\\", "\\\\", $location);;
    $location = str_replace("%", "\%", $location);;
    $location = str_replace("_", "\_", $location);;
    $location = "%" . $location . "%";

    $statement->execute(array($maxPrice, $numGuests + $numBabies / 2, $location, $location, $endDate, $startDate));

    return makePlaceArray($statement->fetchAll());
}

function getNewHouseId()
{
    $db = Database::instance()->db();

    $statement = $db->prepare("SELECT max(ID) FROM Place;");
    $statement->execute();
    $id = $statement->fetch();
    if ($id['max(ID)'] == null)
        return 0;
    return $id['max(ID)'] + 1;
}

function getNewPlaceLocId()
{
    $db = Database::instance()->db();

    $statement = $db->prepare("SELECT max(ID) FROM PlaceLocation;");
    $statement->execute();
    $maxplaceid = $statement->fetch();
    if ($maxplaceid['max(ID)'] == null)
        return 0;
    return $maxplaceid['max(ID)'] + 1;
}

function addHouse($id, $country, $city, $address, $owner, $title, $description, $price, $capacity, $numRooms, $numBeds, $numBathrooms)
{
    $db = Database::instance()->db();

    $newplaceid = getNewPlaceLocId();

    $countryID = getCountryID($country);
    if ($countryID == false)
        return false;

    $statement = $db->prepare('INSERT INTO PlaceLocation Values (?, ?, ?, ?)');
    $statement->execute(array($newplaceid, $countryID, $city, $address));

    $statement = $db->prepare('INSERT INTO Place Values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $statement->execute(array($id, $newplaceid, $owner, $title, $description, $price, $capacity, $numRooms, $numBeds, $numBathrooms));
    return true;
}

function editHouse($id, $country, $city, $address, $title, $description, $price, $capacity, $numRooms, $numBeds, $numBathrooms)
{
    $db = Database::instance()->db();

    $countryID = getCountryID($country);
    echo $countryID;
    if ($countryID == false)
        return false;

    $statement = $db->prepare(
        "SELECT location
            FROM Place
            WHERE id = ? 
           "
    );
    $statement->execute(array($id));
    $placeId = $statement->fetch()['location'];

    $statement = $db->prepare('UPDATE PlaceLocation 
                                SET country = ?, city = ?, address = ?
                                WHERE id = ?');

    $statement->execute(array($countryID, $city, $address, $placeId));

    $statement = $db->prepare('UPDATE Place 
                                 SET title = ?, description = ?, pricePerDay = ?, capacity = ?, numRooms = ?, numBeds = ?, numBathrooms = ?
                                 WHERE id = ?');

    $statement->execute(array($title, $description, $price, $capacity, $numRooms, $numBeds, $numBathrooms, $id));
    return true;
}

function deleteHouse($house_id)
{
    $db = Database::instance()->db();

    $statement1 = $db->prepare("SELECT location FROM Place WHERE id = ?");
    $statement1->execute(array($house_id));
    $location_id = $statement1->fetch()['location'];

    $statement2 = $db->prepare("DELETE FROM Place WHERE id = ?");
    $statement2->execute(array($house_id));

    $statement3 = $db->prepare("DELETE FROM PlaceLocation WHERE id = ?");
    $statement3->execute(array($location_id));
}
