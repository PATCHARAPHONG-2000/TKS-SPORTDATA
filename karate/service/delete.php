<?php
require_once '../../service/connect.php';

$Database = new Database();
$conn = $Database->connect();

// ตรวจสอบว่ามีคำสั่ง POST ที่ส่งมาหรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ตรวจสอบและใช้ค่า Role จาก $_SESSION
    if(isset($_SESSION['AD_ROLE'])) {
        $adRole = $_SESSION['AD_ROLE'];

        // ชื่อตารางที่ต้องการลบข้อมูล
        $tableName = "data_score";

        // คำสั่ง SQL สำหรับลบข้อมูลที่มี Role เท่ากับ $adRole
        $sql = $conn->prepare("DELETE FROM $tableName WHERE role = :role");
        $sql->bindParam(':role', $adRole);
        
        $result = $sql->execute();

        if ($result) {
            // ลบข้อมูลสำเร็จ
            echo json_encode(array('message' => "ลบข้อมูลในตาราง $tableName ที่มี Role เท่ากับ $adRole เรียบร้อยแล้ว"));
        } else {
            // เกิดข้อผิดพลาดในการลบข้อมูล
            echo json_encode(array('message' => "เกิดข้อผิดพลาดในการลบข้อมูลในตาราง $tableName"));
        }
    } else {
        $adRole = '';  // ถ้าไม่มีค่ากำหนดให้เป็นค่าว่าง
        // กระทำสิ่งที่ต้องการเมื่อไม่มี session
        echo "ไม่พบ session หรือ session ไม่มีค่าที่ต้องการ";
    }
}
?>
