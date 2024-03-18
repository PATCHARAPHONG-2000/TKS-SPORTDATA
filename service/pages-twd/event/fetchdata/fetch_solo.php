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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
    } else if (isset($_POST['gender']) && !empty($_POST['gender']) && isset($_POST['List_event']) && !empty($_POST['List_event'])) {
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
    } else if (isset($_POST['age']) && !empty($_POST['age'])) {
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
        respondError('Missing parameters.');
    }
} else {
    respondError('Invalid request method.');
}
