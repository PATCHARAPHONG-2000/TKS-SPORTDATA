<?php
header('Content-Type: application/json');
require_once '../../../connect.php';

$Database = new Database();
$conn = $Database->connect();

function respondError($message)
{
    echo json_encode(['error' => $message]);
    exit();
}

if (isset($_POST['Poomse_gender']) && !empty($_POST['Poomse_gender']) && isset($_POST['List_event']) && !empty($_POST['List_event'])) {
    $Poomse_gender = $_POST['Poomse_gender'];
    $List_event = $_POST['List_event'];

    if ($Poomse_gender !== 'ชาย' && $Poomse_gender !== 'หญิง') {
        respondError('Invalid Poomse_gender.');
    }

    $statement = $conn->prepare("SELECT DISTINCT age_group FROM create_event WHERE gender = :gender AND List_event = :List_event");
    $statement->bindParam(':gender', $Poomse_gender);
    $statement->bindParam(':List_event', $List_event);
    $statement->execute();

    $ageGroups = [];
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        if ($row['age_group'] !== NULL) {
            $ageGroups[] = $row['age_group'];
        }
    }

    echo json_encode($ageGroups);
} else {
    respondError('gender is required.');
}
