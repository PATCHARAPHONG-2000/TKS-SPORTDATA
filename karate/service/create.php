<?php
header('Content-Type: application/json');
require_once '../../service/connect.php';

$Database = new Database();
$conn = $Database->connect();

function respondError($message)
{
    echo json_encode(['error' => $message]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $conn->beginTransaction();

        $name = $_POST['name'];
        $scores = $_POST['scores'];
        $totalSum = $_POST['totalSum'];
        $finalSum = $_POST['finalSum'];

        // Assuming $_SESSION['AD_ROLE'] is properly set
        $adRole = isset($_SESSION['AD_ROLE']) ? $_SESSION['AD_ROLE'] : '';

        $stmt = $conn->prepare("INSERT INTO data_score (Name, judge1, judge2, judge3, judge4, judge5, judge6, judge7, max_sum, finalsum, Role) 
        VALUES (:Name, :judge1, :judge2, :judge3, :judge4, :judge5, :judge6, :judge7, :max_sum, :finalsum, :Role)");

        $stmt->bindParam(':Name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':judge1', $scores[0], PDO::PARAM_STR);
        $stmt->bindParam(':judge2', $scores[1], PDO::PARAM_STR);
        $stmt->bindParam(':judge3', $scores[2], PDO::PARAM_STR);
        $stmt->bindParam(':judge4', $scores[3], PDO::PARAM_STR);
        $stmt->bindParam(':judge5', $scores[4], PDO::PARAM_STR);
        $stmt->bindParam(':judge6', $scores[5], PDO::PARAM_STR);
        $stmt->bindParam(':judge7', $scores[6], PDO::PARAM_STR);    
        $stmt->bindParam(':max_sum', $totalSum, PDO::PARAM_STR);
        $stmt->bindParam(':finalsum', $finalSum, PDO::PARAM_STR);
        $stmt->bindParam(':Role', $adRole, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $conn->commit();
            echo json_encode([
                'status' => true,
                'message' => 'ลงทะเบียนเรียบร้อย'
            ]);
            exit();
        } else {
            respondError('ผิดพลาดในการดำเนินการคำสั่ง SQL');
        }
    } catch (Exception $e) {
        $conn->rollBack();
        respondError('การทำรายการล้มเหลว: ' . $e->getMessage());
    }
} else {
    respondError('วิธีการร้องขอไม่ถูกต้อง');
}
?>
