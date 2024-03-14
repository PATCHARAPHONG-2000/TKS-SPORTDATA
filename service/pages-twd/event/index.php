<?php
header('Content-Type: application/json');
require_once '../../connect.php'; // ปรับเส้นทางตามความเหมาะสม

$Database = new Database();
$connect = $Database->connect();

if ($connect) {
    if (isset($_SESSION['team'])) {
        $userStatus = $_SESSION['team']['role']; // เช็ค session สำหรับสถานะผู้ใช้

        $query = 'SELECT * FROM event WHERE team = :userStatus';
        $stmt = $connect->prepare($query);
        $stmt->bindParam(':userStatus', $userStatus);
        $stmt->execute();

        if ($stmt) {
            $data = array();
            foreach ($stmt->fetchAll() as $row) {
                $data[] = [
                    'id' => $row['id'],
                    'firstname' => $row['firstname'],
                    'lastname' => $row['lastname'],
                    'team' => $row['team'],
                    'status' => $row['status'],
                    'class' => $row['class'],
                    'weigth' => $row['weigth'],
                    'age' => $row['age'], // เพิ่ม key ตามคำสั่ง SQL
                    'license' => $row['license'], // เพิ่ม key ตามคำสั่ง SQL
                    'image' => $row['image'],
                ];
            }
            echo json_encode([
                'status' => true,
                'message' => 'Get Data Manager Success',
                'response' => $data
            ]);
        } else {
            $response['message'] = 'Failed to retrieve data from the database';
        }
    } else {
        $response['message'] = 'User is not logged in'; // หรือข้อความที่คุณต้องการสำหรับผู้ใช้ที่ไม่ได้ล็อกอิน
    }
}
