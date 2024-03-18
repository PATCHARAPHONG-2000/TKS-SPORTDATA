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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ตรวจสอบว่ามีการส่งค่า imageon และ isActive มา
    if (isset($_POST['imageon']) && isset($_POST['isActive'])) {
        // รับค่า imageon และ isActive
        $imageon = $_POST['imageon'];
        $isActive = $_POST['isActive'];

        // SQL query ในการอัปเดตข้อมูล
        $sql = "UPDATE data_all SET IsActive = :isActive WHERE id = :image";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':image', $imageon, PDO::PARAM_INT);
        $stmt->bindParam(':isActive', $isActive, PDO::PARAM_INT);

        // ทำการ execute query
        $result = $stmt->execute();

        if ($result) {
            // ตอบกลับด้วย JSON เมื่อสำเร็จ
            echo json_encode([
                'status' => true,
                'message' => 'Data updated successfully'
            ]);
        } else {
            // ถ้ามีข้อผิดพลาดในการ execute SQL
            respondError('Error updating data');
        }
    } else {
        // ถ้าไม่มีการส่งค่า imageon หรือ isActive มา
        respondError('Invalid imageon or isActive');
    }
} else {
    // ถ้าไม่ใช่ POST request
    http_response_code(400);
    echo json_encode([
        'status' => false,
        'message' => 'Invalid request'
    ]);
}
