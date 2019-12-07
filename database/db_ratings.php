<?php
    function getHouseRating($id) {
        $db = Database::instance()->db();

        $statement = $db->prepare(
            "SELECT rating FROM Rating WHERE place = ?"
        );
        $statement->execute(array($id));

        $ratings = $statement->fetchAll();
        $numRatings = count($ratings);
        if($numRatings == 0) {
            $avgRating = 0;
        } else {
            $totalRating = 0;

            foreach($ratings as $rating) {
                $totalRating += $rating['rating'];
            }

            $avgRating = $totalRating / $numRatings;
        }
        return $avgRating;
    }

    function getNumRatings($id) {
        $db = Database::instance()->db();

        $statement = $db->prepare(
            "SELECT rating FROM Rating WHERE place = ?"
        );
        $statement->execute(array($id));

        $ratings = $statement->fetchAll();
        $numRatings = count($ratings);

        return $numRatings;
    }

    function getUserRating($userid, $placeid) {
        $db = Database::instance()->db();

        $statement = $db->prepare(
            "SELECT rating FROM Rating WHERE place = ? AND user = ?"
        );
        $statement->execute(array($placeid, $userid));

        $rating = $statement->fetch();
        return $rating['rating'];
    }

    function addUserRating($userid, $placeid, $rating) {
        $db = Database::instance()->db();

        $prevRating = getUserRating($userid, $placeid);

        if($prevRating != false) {
            $updatePrevRatingStatement = $db->prepare(
                "UPDATE Rating SET rating = ? WHERE place = ? AND user = ?"
            );
            $updatePrevRatingStatement->execute(array($rating, $placeid, $userid));
        } else {
            $addNewRatingStatement = $db->prepare(
                "INSERT INTO Rating VALUES(?, ?, ?)"
            );
            $addNewRatingStatement->execute(array($userid, $placeid, $rating));
        }
    }
?>