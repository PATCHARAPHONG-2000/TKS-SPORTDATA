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

if (isset($_POST['team_gender']) && !empty($_POST['team_gender']) && isset($_POST['List_event']) && !empty($_POST['List_event'])) {
    $team_gender = $_POST['team_gender'];
    $List_event = $_POST['List_event'];

    // Check if the team_gender is either 'Male' or 'Female'
    if ($team_gender !== 'ชาย' && $team_gender !== 'หญิง') {
        respondError('Invalid team_gender.');
    }

    $statement = $conn->prepare("SELECT DISTINCT age_group FROM create_event WHERE gender = :team_gender AND List_event = :List_event");
    $statement->bindParam(':team_gender', $team_gender);
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
    respondError('team_gender and List_event are required.');
}
