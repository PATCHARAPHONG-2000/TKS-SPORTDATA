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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ตรวจสอบค่า ID
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if ($id === false || $id <= 0) {
        respondError('Invalid ID');
    }

    // ตรวจสอบค่า class และ weigth
    $class = trim(filter_input(INPUT_POST, 'class'));
    $weigth = trim(filter_input(INPUT_POST, 'weigth'));
    if (empty($class) && empty($weigth)) {
        respondError('Both class and weigth cannot be empty');
    }

    // ทำการอัปเดตเฉพาะเมื่อมีค่า class หรือ weigth ไม่ว่างเปล่า
    if (!empty($class) || !empty($weigth)) {
        // เตรียมคำสั่ง SQL และพารามิเตอร์สำหรับการอัปเดต
        $sql = "UPDATE `event` SET ";
        $params = array();
        
        if (!empty($class)) {
            $sql .= "`class` = :class";
            $params[':class'] = $class;
        }

        if (!empty($weigth)) {
            if (!empty($class)) {
                $sql .= ", ";
            }
            $sql .= "`weigth` = :weigth";
            $params[':weigth'] = $weigth;
        }

        // เพิ่มเงื่อนไข WHERE เพื่ออัปเดตเฉพาะรายการที่ต้องการ
        $sql .= " WHERE `id` = :id";
        $params[':id'] = $id;

        // เตรียมและ execute คำสั่ง SQL
        $stmt = $conn->prepare($sql);
        if ($stmt->execute($params)) {
            echo json_encode(array(
                'status' => true,
                'message' => 'Update successful'
            ));
        } else {
            respondError('Failed to update the record');
        }
    } else {
        // กรณีไม่มีการร้องขอการอัปเดต class หรือ weigth ไม่ต้องทำอะไร
        respondError('No data to update');
    }
}
?>