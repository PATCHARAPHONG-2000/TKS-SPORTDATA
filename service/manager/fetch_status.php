<?php
header('Content-Type: application/json');
require_once '../connect.php';

$Database = new Database();
$conn = $Database->connect();

function respondError($message)
{
    echo json_encode(['error' => $message]);
    exit();
}

if (isset($_POST['gender']) && !empty($_POST['gender']) && isset($_POST['List_event']) && !empty($_POST['List_event'])) {
    $gender = $_POST['gender'];
    $List_event = $_POST['List_event'];

    if ($gender !== 'ชาย' && $gender !== 'หญิง') {
        respondError('Invalid gender.');
    }

    $statement = $conn->prepare("SELECT DISTINCT age_group FROM create_event WHERE gender = :gender AND List_event = :List_event");
    $statement->bindParam(':gender', $gender);
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
