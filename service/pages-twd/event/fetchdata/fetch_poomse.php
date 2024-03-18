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

// ตรวจสอบว่ามีข้อมูลที่จำเป็นทั้งหมดที่จำเป็นและไม่ว่างเปล่าหรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['Poomse_gender']) && !empty($_POST['Poomse_gender']) && isset($_POST['List_event']) && !empty($_POST['List_event'])) {
        $Poomse_gender = $_POST['Poomse_gender'];
        $List_event = $_POST['List_event'];

        if ($Poomse_gender !== 'ชาย' && $Poomse_gender !== 'หญิง') {
            respondError('Invalid Poomse_gender.');
        }

        $statement = $conn->prepare("SELECT DISTINCT age_group FROM create_event WHERE gender = :Poomse_gender AND List_event = :List_event");
        $statement->bindParam(':Poomse_gender', $Poomse_gender);
        $statement->bindParam(':List_event', $List_event);
        $statement->execute();

        $ageGroups = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            if ($row['age_group'] !== NULL) {
                $ageGroups[] = $row['age_group'];
            }
        }

        echo json_encode($ageGroups);
    } else if (isset($_POST['Poomse_age']) && !empty($_POST['Poomse_age']) && isset($_POST['Poomse_gender']) && !empty($_POST['Poomse_gender'])) {
        $Poomse_age = $_POST['Poomse_age'];
        $Poomse_gender = $_POST['Poomse_gender'];

        $statement = $conn->prepare("SELECT DISTINCT colorse FROM create_event WHERE age_group = :Poomse_age AND gender = :Poomse_gender");
        $statement->bindParam(':Poomse_age', $Poomse_age);
        $statement->bindParam(':Poomse_gender', $Poomse_gender);
        $statement->execute();

        $colorse = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            if ($row['colorse'] !== NULL) {
                $colorse[] = $row['colorse'];
            }
        }

        echo json_encode($colorse);
    } else if (isset($_POST['Poomse_colorse']) && !empty($_POST['Poomse_colorse']) && isset($_POST['Poomse_age']) && !empty($_POST['Poomse_age'])) {
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
        respondError('Missing parameters.');
    }
} else {
    respondError('Invalid request method.');
}
