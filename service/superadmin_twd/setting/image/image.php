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
    $uploadDir = "../uploads/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $newFileName = time() . '_' . basename($_FILES['image']['name']);
    $filePath = $uploadDir . $newFileName;


    $check = getimagesize($_FILES['image']['tmp_name']);
    if (!$check || !in_array($check['mime'], ['image/jpeg', 'image/png'])) {
        respondError('กรุณาใส่รูปที่เป็น PNG , JPG เท่านั้น');
    }

    if (isset($_SESSION['team']['role'])) {
        $role = $_SESSION['team']['role'];
    } else {
        $role = 'default_status';
    }

    try {
        $conn->beginTransaction();

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $filePath)) {
            $eventsname = filter_input(INPUT_POST, 'eventsname');

            $stmt = $conn->prepare("INSERT INTO data_all (users, name,image) VALUES (:users, :name,:image)");
            $stmt->bindParam(':users', $role);
            $stmt->bindParam(':name', $eventsname);
            $stmt->bindParam(':image', $filePath);
            $stmt->execute();
            $conn->commit();

            echo json_encode([
                'status' => true,
                'message' => 'Registration successful',
                'file_path' => $filePath
            ]);
            exit();
        } else {
            respondError('Error uploading image');
        }
    } catch (Exception $e) {
        $conn->rollBack();
        respondError('Transaction failed: ' . $e->getMessage());
    }
} else {
    respondError('Invalid request method');
}
