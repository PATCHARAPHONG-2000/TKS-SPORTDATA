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

if (isset($_POST['List_event']) && !empty($_POST['List_event'])) {
    $List_event = $_POST['List_event'];

    $statement = $conn->prepare("SELECT DISTINCT age_group FROM create_event WHERE List_event = :List_event");
    $statement->bindParam(':List_event', $List_event);
    $statement->execute();

    $age_group = [];
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        if ($row['age_group'] !== NULL) {
            $age_group[] = $row['age_group'];
        }
    }

    echo json_encode($age_group);
} else {
    echo json_encode([]);
}
