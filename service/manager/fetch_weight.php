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
    // Sanitize input age
    $age = $_POST['age'];

    // Prepare statement to select distinct weights based on selected age
    $statement = $conn->prepare("SELECT DISTINCT weigth FROM create_event WHERE age_group = :age");
    $statement->bindParam(':age', $age);
    $statement->execute();

  
    $weights = [];
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $weights[] = $row['weigth'];
    }

    echo json_encode($weights);
} else {
    // Return empty array if age is not set or empty
    echo json_encode([]);
}
?>