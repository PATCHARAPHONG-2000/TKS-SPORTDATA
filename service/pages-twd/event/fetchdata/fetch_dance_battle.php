<?php
header('Content-Type: application/json');
require_once '../../../connect.php';

$Database = new Database();
$conn = $Database->connect();

if (isset($_POST['Dance_battle_gender']) && isset($_POST['List_event'])) {
    $Dance_battle_gender = $_POST['Dance_battle_gender'];
    $List_event = $_POST['List_event'];

    $statement = $conn->prepare("SELECT DISTINCT age_group FROM create_event WHERE List_event = :List_event AND gender = :Dance_battle_gender");
    $statement->bindParam(':List_event', $List_event);
    $statement->bindParam(':Dance_battle_gender', $Dance_battle_gender);
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
