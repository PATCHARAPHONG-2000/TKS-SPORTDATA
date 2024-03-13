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

if (isset($_POST['Poomse_colorse']) && !empty($_POST['Poomse_colorse']) && isset($_POST['Poomse_age']) && !empty($_POST['Poomse_age'])) {
    $Poomse_colorse = $_POST['Poomse_colorse'];
    $Poomse_age = $_POST['Poomse_age'];

    $statement = $conn->prepare("SELECT DISTINCT pattern FROM create_event WHERE age_group = :Poomse_age AND colorse = :Poomse_colorse");
    $statement->bindParam(':Poomse_age', $Poomse_age);
    $statement->bindParam(':Poomse_colorse', $Poomse_colorse);
    $statement->execute();

    $pattern = [];
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        if ($row['pattern'] !== NULL) {
            $pattern[] = $row['pattern'];
        }
    }

    echo json_encode($pattern);
} else {
    echo json_encode([]);
}
