<?php
header('Content-Type: application/json');
require_once '../connect.php';

$Database = new Database();
$conn = $Database->connect();

function respondError($message)
{
    echo json_encode(['error' => $message]);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $Class = $_POST['class'];
    $weigth = $_POST['weigth'];
    
    if(isset($_POST['ids']) && !empty($_POST['ids'])) {
        $ids = $_POST['ids'];
        
        if(!empty($ids)) {
            $placeholders = rtrim(str_repeat('?,', count($ids)), ',');
            $sql = "SELECT * FROM player WHERE id IN ($placeholders)";
            $stmt = $conn->prepare($sql);
            $stmt->execute($ids);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if($rows) {
                foreach($rows as $row) {
                    
                    $firstname = $row['firstname'];
                    $lastname = $row['lastname'];
                    $status = $row['status'];
                    $role = $row['team'];
                    $age = $row['age'];
                    $license = $row['license'];
                    $fileImage = $row['image'];

                    $stmt = $conn->prepare("INSERT INTO event (firstname, lastname, status, team, age, class, weigth, license, image) 
                        VALUES (:firstname, :lastname, :status, :team, :age, :class, :weigth, :license, :image)");
                    $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
                    $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
                    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
                    $stmt->bindParam(':team', $role, PDO::PARAM_STR);
                    $stmt->bindParam(':age', $age, PDO::PARAM_STR);
                    $stmt->bindParam(':class', $Class, PDO::PARAM_STR);
                    $stmt->bindParam(':weigth', $weigth, PDO::PARAM_STR);
                    $stmt->bindParam(':license', $license, PDO::PARAM_STR);
                    $stmt->bindParam(':image', $fileImage, PDO::PARAM_STR);

                    if (!$stmt->execute()) {
                        respondError('Error executing SQL statement');
                    }
                }

                // หลังจากบันทึกข้อมูลลงในตาราง "event" เรียบร้อยแล้ว
                // ให้ทำการอัพเดตค่าในคอลัมน์ "IsActive" ในตาราง "player" ให้มีค่าเป็น 1

                // กำหนดคำสั่ง SQL สำหรับอัพเดตค่าในคอลัมน์ "IsActive"
                $updateSql = "UPDATE player SET IsActive = 1 WHERE id IN ($placeholders)";

                // เตรียมข้อมูลที่จะส่งเข้าไปในคำสั่ง SQL
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->execute($ids);

                // ตรวจสอบว่ามีข้อผิดพลาดในการอัพเดตหรือไม่
                if ($updateStmt->rowCount() === 0) {
                    respondError('Error updating IsActive column in player table');
                }

                echo json_encode([
                    'status' => true,
                    'message' => 'Registration successful'
                ]);
                exit();
            } else {
                respondError('No data found for provided IDs');
            }
        } else {
            respondError('No ids provided');
        }
    } else {
        respondError('No ids provided');
    }
} else {
    respondError('Invalid request method');
}