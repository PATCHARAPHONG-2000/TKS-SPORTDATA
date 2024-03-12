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

    $statement = $conn->prepare("SELECT DISTINCT sp_class FROM create_event WHERE age_group = :age");
    $statement->bindParam(':age', $age);
    $statement->execute();

    $classes = [];
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        if ($row['sp_class'] !== NULL) {
            $classes[] = $row['sp_class'];
        }
    }

    echo json_encode($classes);
} else {
    echo json_encode([]);
}