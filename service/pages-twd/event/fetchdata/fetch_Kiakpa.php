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
    if (isset($_POST['Kiakpa_gender']) && isset($_POST['List_event'])) {
        $Kiakpa_gender = $_POST['Kiakpa_gender'];
        $List_event = $_POST['List_event'];

        $statement = $conn->prepare("SELECT DISTINCT Kiakpa_type FROM create_event WHERE gender = :Kiakpa_gender AND List_event = :List_event");
        $statement->bindParam(':Kiakpa_gender', $Kiakpa_gender);
        $statement->bindParam(':List_event', $List_event);
        $statement->execute();

        $Kiakpa_type_list = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            if ($row['Kiakpa_type'] !== NULL) {
                $Kiakpa_type_list[] = $row['Kiakpa_type'];
            }
        }

        echo json_encode($Kiakpa_type_list);
    } else if (isset($_POST['Kiakpa_gender']) && isset($_POST['Kiakpa_type'])) {
        $Kiakpa_gender = $_POST['Kiakpa_gender'];
        $Kiakpa_type = $_POST['Kiakpa_type'];

        $statement = $conn->prepare("SELECT DISTINCT age_group FROM create_event WHERE gender = :Kiakpa_gender AND Kiakpa_type = :Kiakpa_type");
        $statement->bindParam(':Kiakpa_gender', $Kiakpa_gender);
        $statement->bindParam(':Kiakpa_type', $Kiakpa_type);
        $statement->execute();

        $Kiakpa_age_list = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            if ($row['age_group'] !== NULL) {
                $Kiakpa_age_list[] = $row['age_group'];
            }
        }

        echo json_encode($Kiakpa_age_list);
    } else {
        respondError('Kiakpa_gender and Kiakpa_type are required.');
    }
} else {
    respondError('Invalid request method.');
}
