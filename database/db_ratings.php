<?php
    function getHouseRatings($houseID) {
        $db = Database::instance()->db();

        $statement = $db->prepare(
            "SELECT avg(rating) AS Avg, sum(rating) AS Sum
            FROM Rating JOIN Reservation ON Rating.reservation = Reservation.id
            WHERE Reservation.place = ?"
        );
        $statement->execute(array($houseID));

        $ratings = $statement->fetch();

        if ($ratings['Avg'] == null)
            return 0;
        return $ratings['Avg'];
    }

    function getHouseComments($houseID) {       
        $db = Database::instance()->db();

        $statement = $db->prepare(
            "SELECT rating, comment, username
            FROM Rating JOIN Reservation ON Rating.reservation = Reservation.id JOIN User ON Reservation.user = User.id
            WHERE Reservation.place = ?"
        );
        $statement->execute(array($houseID));

        return $statement->fetchAll();
    }
    /*
    function getNumRatings($id) {
        $db = Database::instance()->db();

        $statement = $db->prepare(
            "SELECT sum(rating) AS Sum
            FROM Rating JOIN Reservation ON Rating.reservation = Reservation.id
            WHERE Reservation.place = ?"
        );
        $statement->execute(array($houseID));

        $ratings = $statement->fetch();

        if ($ratings['Sum'] == null)
            return 0;
        return $ratings['Sum'];
    }
    */
/*
    function getUserRating($userid, $placeid) {
        $db = Database::instance()->db();

        $statement = $db->prepare(
            "SELECT rating FROM Rating WHERE place = ? AND user = ?"
        );
        $statement->execute(array($placeid, $userid));

        $rating = $statement->fetch();
        return $rating['rating'];
    }
    */

    function addReservationRating($reservation, $rating, $comment) {
        $db = Database::instance()->db();
        
        $statement = $db->prepare("INSERT INTO Rating VALUES(?, ?, ?)");
        $statement->execute(array($reservation, $rating, $comment));
    }

?>