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
function generateUniqueID($conn)
{
    // กำหนดรหัสเริ่มต้นที่ 000001
    $ID_Number = "TKS" . str_pad(1, 6, '0', STR_PAD_LEFT);

    // ตรวจสอบว่ามีรหัสซ้ำกับที่มีในฐานข้อมูลหรือไม่
    $stmt = $conn->prepare("SELECT ID_Number FROM player ORDER BY ID_Number DESC LIMIT 1");
    $stmt->execute();
    $lastID = $stmt->fetchColumn();

    // หากมีรหัสล่าสุดแล้วให้เพิ่มไปอีก 1
    if ($lastID) {
        $lastIDNumber = intval(substr($lastID, 3)); // เอาเฉพาะตัวเลขหลัง "TKS"
        $ID_Number = "TKS" . str_pad($lastIDNumber + 1, 6, '0', STR_PAD_LEFT);
    }

    return $ID_Number;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['team']['role'])) {
        respondError('Team role not set');
    }

    $dir = "../tksuploads/";
    $newFileName = time() . '_' . $_FILES['image']['name'];
    $fileImage = $dir . $newFileName;
    $check = getimagesize($_FILES['image']['tmp_name']);

    $allowedImageTypes = ['image/jpeg', 'image/png'];
    if (!$check || !in_array($check['mime'], $allowedImageTypes)) {
        respondError('Invalid or unreadable image format. Please upload a JPEG or PNG image.');
    }

    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $fileImage)) {
        respondError('Error uploading image');
    }

    $firstname =$_POST['firstname'];
    $lastname = $_POST['lastname']; 
    $status = $_POST['status'] ?? '';
    $age = $_POST['age']; 
    $license = $_POST['license']; 

    if ($status === 'male') {
        $status = 'ชาย';
    } elseif ($status === 'female') {
        $status = 'หญิง';
    } else {
        $status = 'ไม่ระบุ';
    }

    // สร้างรหัส ID ที่ไม่ซ้ำกับฐานข้อมูล
    $ID_Number = generateUniqueID($conn);

    try {
        $stmt = $conn->prepare("INSERT INTO player (ID_Number, firstname, lastname, status, team, age, license, image) 
                        VALUES (:ID_Number, :firstname, :lastname, :status, :team, :age, :license, :image)");

        $role = $_SESSION['team']['role'];

        $stmt->bindParam(':ID_Number', $ID_Number, PDO::PARAM_STR);
        $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':team', $role, PDO::PARAM_STR);
        $stmt->bindParam(':age', $age, PDO::PARAM_INT);
        $stmt->bindParam(':license', $license, PDO::PARAM_STR);
        $stmt->bindParam(':image', $fileImage, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo json_encode([
                'status' => true,
                'message' => 'Registration successful'
            ]);
            exit();
        } else {
            respondError('Error executing SQL statement');
        }
    } catch (Exception $e) {
        respondError('Transaction failed: ' . $e->getMessage());
    }
} else {
    respondError('Invalid request method');
}
?>
