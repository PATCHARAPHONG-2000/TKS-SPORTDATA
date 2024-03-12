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

if (isset($_POST['age']) && !empty($_POST['age'])) {
    $age = $_POST['age'];

    $statement = $conn->prepare("SELECT DISTINCT weight FROM create_event WHERE age_group = :age");
    $statement->bindParam(':age', $age);
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
?>