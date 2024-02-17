<?php
require_once '../connect.php';

$Database = new Database();
$conn = $Database->connect();

function respondError($message)
{
    echo json_encode(['error' => $message]);
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $ids = $_POST['id'];

    // เช็คว่า $ids เป็นอาร์เรย์หรือไม่
    if (!is_array($ids)) {
        $ids = [$ids];
    }

    // ตรวจสอบและลบรายการทีละรายการ
    foreach ($ids as $id) {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if ($id === false || $id <= 0) {
            continue; // ข้ามรายการที่ไม่ถูกต้อง
        }

        $stmt = $conn->prepare("SELECT `image` FROM `event` WHERE `id` = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // ลบข้อมูลจากฐานข้อมูล
            $deleteStmt = $conn->prepare("DELETE FROM `event` WHERE `id` = :id");
            $deleteStmt->bindParam(':id', $id);
            
            if ($deleteStmt->execute()) {
                // การลบสำเร็จ
                echo json_encode(['status' => true, 'message' => 'Delete Success']);
            } else {
                // การลบล้มเหลว
                echo json_encode(['status' => false, 'message' => 'Delete Failed']);
            }
        } else {
            // ไม่พบข้อมูลที่ต้องการลบ
            echo json_encode(['status' => false, 'message' => 'Data not found']);
        }
    }
} else {
    http_response_code(400);
    echo json_encode(['status' => false, 'message' => 'Invalid request']);
}