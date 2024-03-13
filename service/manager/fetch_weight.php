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

if (isset($_POST['age']) && !empty($_POST['age']) && isset($_POST['gender']) && !empty($_POST['gender'])) {
    $age = $_POST['age'];
    $gender = $_POST['gender'];

    $statement = $conn->prepare("SELECT DISTINCT weight FROM create_event WHERE age_group = :age AND gender = :gender");
    $statement->bindParam(':age', $age);
    $statement->bindParam(':gender', $gender);
    $statement->execute();

    $weights = [];
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        if ($row['weight'] !== NULL) {
            $weights[] = $row['weight'];
        }
    }

    echo json_encode($weights);
} else {
    echo json_encode([]);
}
