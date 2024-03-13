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

if (isset($_POST['Poomse_age']) && !empty($_POST['Poomse_age']) && isset($_POST['Poomse_gender']) && !empty($_POST['Poomse_gender'])) {
    $Poomse_age = $_POST['Poomse_age']; // แก้ชื่อตัวแปร Poomse_age ให้ตรงกับการรับค่าจาก JavaScript
    $Poomse_gender = $_POST['Poomse_gender']; // แก้ชื่อตัวแปร Poomse_gender ให้ตรงกับการรับค่าจาก JavaScript

    $statement = $conn->prepare("SELECT DISTINCT colorse FROM create_event WHERE age_group = :Poomse_age AND gender = :Poomse_gender"); // แก้ชื่อตารางของฐานข้อมูลให้ตรงกับการใช้งาน
    $statement->bindParam(':Poomse_age', $Poomse_age); // แก้ชื่อตัวแปรใน bindParam
    $statement->bindParam(':Poomse_gender', $Poomse_gender); // แก้ชื่อตัวแปรใน bindParam
    $statement->execute();

    $colorse = [];
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        if ($row['colorse'] !== NULL) {
            $colorse[] = $row['colorse'];
        }
    }

    echo json_encode($colorse);
} else {
    echo json_encode([]);
}
