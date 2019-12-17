<?php
include_once('../includes/session.php');
include_once('../includes/sessionMessages.php');
include_once('../database/db_houses.php');
include_once('../database/db_reservations.php');
include_once('../database/db_notifications.php');

if ($_SESSION['csrf'] !== $_POST['csrf']) {
    addErrorMessage('Illegitimate request!');
    die(header('Location: ../pages/main.php'));
}

$house_id = $_POST['houseID'];

$house = getHouseById($house_id);

if ($house == NULL) {
    echo json_encode('House does not exist!');
    return;
}

$ownerUsername = $house->ownerUsername;

if ($ownerUsername != $_SESSION['username']) {
    echo json_encode('No permission!');
} else if (count(getFutureReservations($house_id)) > 0) {
    echo json_encode('Pending reservations!');
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
    echo json_encode(null);
}

?>