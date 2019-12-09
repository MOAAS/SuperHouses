<?php
    include_once('../includes/database.php');
    include_once('../includes/reservation.php');
    include_once('../database/db_users.php');
    include_once('../database/db_houses.php');

    function makeReservationArray($rows) {
        $reservations = array();
        foreach($rows as $row)
            array_push($reservations, new Reservation($row['id'], $row['pricePerDay'], getHouseById($row['place']), $row['dateStart'], $row['dateEnd'], $row['username']));
        return $reservations;
    }
    
    function reservationOverlaps($placeID, $checkIn, $checkOut) {
        $db = Database::instance()->db();

        $statement = $db->prepare(
            'SELECT id
            FROM Reservation
            WHERE place = ? AND ? > dateStart AND ? < dateEnd
            LIMIT 1'
        );

        $statement->execute(array($placeID, $checkOut, $checkIn));

        return ($statement->fetch() != false);
    }

    function getFutureReservations($placeID) {
        $db = Database::instance()->db();
        
        $statement = $db->prepare(
            'SELECT dateStart, dateEnd
            FROM Reservation
            WHERE place = ?'
        );

        $statement->execute(array($placeID));

        return $statement->fetchAll();
    }

    function addReservation($pricePerDay, $from, $to, $userID, $placeID) {
        $db = Database::instance()->db();

        $statement = $db->prepare('INSERT INTO Reservation VALUES (NULL, ?, ?, ?, ?, ?)');

        $statement->execute(array($pricePerDay, $from, $to, $userID, $placeID));
    }

    function getReservationByID($id) {
        $db = Database::instance()->db();
       
        $statement = $db->prepare(
            'SELECT Reservation.id, dateStart, dateEnd, place, username
            FROM Reservation JOIN User ON Reservation.user = User.id
            WHERE Reservation.id = ?'
        );

        $statement->execute(array($id));

        $reservation = $statement->fetch();
        if ($reservation == false)
            return null;

        return makeReservationArray(array($reservation))[0];
    }

    function removeReservation($id) {
        $db = Database::instance()->db();
       
        $statement = $db->prepare(
            'DELETE FROM Reservation
            WHERE Reservation.id = ?'
        );

        $statement->execute(array($id));
    }

    
    function getGoingReservations($username) {
        $db = Database::instance()->db();
        
        $statement = $db->prepare(
            'SELECT * FROM (
                SELECT Reservation.id, Reservation.pricePerDay, dateStart, dateEnd, place, username
                FROM Reservation JOIN User ON Reservation.user = User.id
                WHERE User.username = ? AND dateEnd <= ?
                ORDER BY dateStart DESC
            )

            UNION ALL
            
            SELECT * FROM (
                SELECT Reservation.id, Reservation.pricePerDay, dateStart, dateEnd, place, username
                FROM Reservation JOIN User ON Reservation.user = User.id
                WHERE User.username = ? AND dateEnd > ?
                ORDER BY dateStart ASC
            )'
        );
        
        $now = date('Y-m-d');
        $statement->execute(array($username, $now, $username, $now));

        return makeReservationArray($statement->fetchAll());
    }


    function getComingReservations($username) {
        $db = Database::instance()->db();
        
        $statement = $db->prepare(
            'SELECT * FROM (
                SELECT Reservation.id, Reservation.pricePerDay, dateStart, dateEnd, place, username
                FROM Reservation JOIN User ON Reservation.user = User.id JOIN Place ON Reservation.place = Place.id 
                WHERE Place.owner = ? AND dateEnd <= ?
                ORDER BY dateStart DESC
            )
                        
            UNION ALL

            SELECT * FROM (
                SELECT Reservation.id, Reservation.pricePerDay, dateStart, dateEnd, place, username
                FROM Reservation JOIN User ON Reservation.user = User.id JOIN Place ON Reservation.place = Place.id 
                WHERE Place.owner = ? AND dateEnd > ?
                ORDER BY dateStart ASC
            )'
        );

        $userID = getUserID($username);
        $now = date('Y-m-d');
        $statement->execute(array($userID, $now, $userID, $now));

        return makeReservationArray($statement->fetchAll());
    }

    function getReservationHost($reservationID) {
        $db = Database::instance()->db();
       
        $statement = $db->prepare(
            'SELECT username
            FROM Reservation JOIN Place ON Reservation.place = Place.id JOIN User ON Place.owner = User.id
            WHERE Reservation.id = ?'
        );

        $statement->execute(array($reservationID));

        return $statement->fetch()['username'];
    }


?>