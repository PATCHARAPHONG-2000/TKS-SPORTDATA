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
    if (isset($_POST['Poomse_gender_team']) && !empty($_POST['Poomse_gender_team']) && isset($_POST['List_event']) && !empty($_POST['List_event'])) {
        $Poomse_gender_team = $_POST['Poomse_gender_team'];
        $List_event = $_POST['List_event'];

        if ($Poomse_gender_team !== 'ชาย' && $Poomse_gender_team !== 'หญิง') {
            respondError('Invalid Poomse_gender_team.');
        }

        $statement = $conn->prepare("SELECT DISTINCT age_group FROM create_event WHERE gender = :gender AND List_event = :List_event");
        $statement->bindParam(':gender', $Poomse_gender_team);
        $statement->bindParam(':List_event', $List_event);
        $statement->execute();

        $ageGroups = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            if ($row['age_group'] !== NULL) {
                $ageGroups[] = $row['age_group'];
            }
        }

        echo json_encode($ageGroups);
    } else if (isset($_POST['Poomse_age_team']) && !empty($_POST['Poomse_age_team']) && isset($_POST['Poomse_gender_team']) && !empty($_POST['Poomse_gender_team'])) {
        $Poomse_age_team = $_POST['Poomse_age_team'];
        $Poomse_gender_team = $_POST['Poomse_gender_team'];

        $statement = $conn->prepare("SELECT DISTINCT colorse FROM create_event WHERE age_group = :Poomse_age_team AND gender = :Poomse_gender_team");
        $statement->bindParam(':Poomse_age_team', $Poomse_age_team);
        $statement->bindParam(':Poomse_gender_team', $Poomse_gender_team);
        $statement->execute();

        $colors = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            if ($row['colorse'] !== NULL) {
                $colors[] = $row['colorse'];
            }
        }

        echo json_encode($colors);
    } else {
        respondError('Missing parameters.');
    }
} else {
    respondError('Invalid request method.');
}
