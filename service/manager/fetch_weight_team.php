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

// ตรวจสอบว่ามีข้อมูลที่จำเป็นทั้งหมดที่จำเป็นและไม่ว่างเปล่าหรือไม่
if (isset($_POST['team_age'], $_POST['team_gender']) && !empty($_POST['team_age']) && !empty($_POST['team_gender'])) {
    $team_age = $_POST['team_age'];
    $team_gender = $_POST['team_gender'];

    // เตรียมและ execute คำสั่ง SQL
    $statement = $conn->prepare("SELECT DISTINCT weight FROM create_event WHERE age_group = :age AND gender = :team_gender");
    $statement->bindParam(':age', $team_age);
    $statement->bindParam(':team_gender', $team_gender);
    $statement->execute();

    // สร้าง array เพื่อเก็บข้อมูลน้ำหนัก
    $weights = [];
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        if ($row['weight'] !== NULL) {
            $weights[] = $row['weight'];
        }
    }

    // ส่งข้อมูลเป็น JSON กลับไปยัง client
    echo json_encode($weights);
} else {
    respondError('team_age and team_gender are required.'); // แก้ข้อความของข้อผิดพลาดให้ตรงกับที่ต้องการ
}
