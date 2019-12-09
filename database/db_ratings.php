<?php
    function getHouseAvgRating($houseID) {
        $db = Database::instance()->db();

        $statement = $db->prepare(
            "SELECT avg(rating) AS Avg
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
            "SELECT Rating.reservation AS reservation, rating, comment, reply, username, Reservation.dateEnd AS date
            FROM Rating JOIN Reservation ON Rating.reservation = Reservation.id JOIN User ON Reservation.user = User.id
            WHERE Reservation.place = ?
            ORDER BY date DESC"
        );
        $statement->execute(array($houseID));

        return $statement->fetchAll();
    }

    function getReservationRating($reservationID) {
        $db = Database::instance()->db();

        $statement = $db->prepare(
            "SELECT rating, comment, reply
            FROM Rating
            WHERE reservation = ?"
        );
        $statement->execute(array($reservationID));

        return $statement->fetch();
    }

    function setReservationReply($reservationID, $content) {
        $db = Database::instance()->db();
        $statement = $db->prepare("UPDATE Rating SET comment = ? WHERE reservation = ?");
        $statement->execute(array($content, $reservationID));
    }

    function addReservationRating($reservation, $rating, $comment) {
        $db = Database::instance()->db();
        
        $statement = $db->prepare("INSERT INTO Rating VALUES(?, ?, ?, NULL)");
        $statement->execute(array($reservation, $rating, $comment));
    }

    function isReviewed($reservationID) {
        $db = Database::instance()->db();

        $statement = $db->prepare(
            "SELECT reservation
            FROM Rating
            WHERE reservation = ?"
        );
        
        $statement->execute(array($reservationID));

        return ($statement->fetch() != false);
    }



?>