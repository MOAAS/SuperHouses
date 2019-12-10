<?php
include_once('../includes/session.php');
include_once('../includes/sessionMessages.php');
include_once('../database/db_houses.php');
include_once('../database/db_reservations.php');
include_once('../database/db_notifications.php');

$house_id = $_POST['houseID'];

$house = getHouseById($house_id);

$ownerUsername = $house->ownerUsername;

if ($ownerUsername != $_SESSION['username']) {
    addErrorMessage("No permission to delete House, Mr./Mrs. " . $_SESSION['username']);
    header('Location: ../pages/profile.php#Your%20place');
} else if (count(getFutureReservations($house_id)) > 0) {
    addErrorMessage("You can't delete a house with pending reservations!");
    header('Location: ../pages/profile.php#Future%20guests');
} else {

    deleteHouse($house_id);

    $files = glob('../database/houseImages/' . $house_id . '/*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            self::deleteDir($file);
        } else {
            unlink($file);
        }
    }
    rmdir('../database/houseImages/' . $house_id);

    addSuccessMessage($house->title . " was successfully deleted!");
    header('Location: ../pages/main.php');
}

?>