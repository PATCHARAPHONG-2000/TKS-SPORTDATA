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
    $dir = "../tksuploads/";
    $newFileName = time() . '_' . $_FILES['image']['name'];
    $fileImage = $dir . $newFileName;
    $check = getimagesize($_FILES['image']['tmp_name']);

    if (isset($_SESSION['team']['role'])) {
        $role = $_SESSION['team']['role'];
    } else {
        $role = 'default_status';
    }

    // Check image format
    $allowedImageTypes = ['image/jpeg', 'image/png'];
    if (!$check || !in_array($check['mime'], $allowedImageTypes)) {
        respondError('Invalid or unreadable image format. Please upload a JPEG, PNG.');
    }

    try {
        $conn->beginTransaction();

        if ($check) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $fileImage)) {
                $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
                $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
                $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
                $age = filter_input(INPUT_POST, 'age', FILTER_SANITIZE_STRING);
                $license = filter_input(INPUT_POST, 'license', FILTER_SANITIZE_STRING);

                // แปลงค่า status
                if ($status === 'male') {
                    $status = 'ชาย';
                } elseif ($status === 'female') {
                    $status = 'หญิง';
                } else {
                    // กรณีค่า status ไม่ใช่ male หรือ female ให้กำหนดค่าเป็นอะไรก็ตามที่เหมาะสม
                    $status = 'ไม่ระบุ';
                }

                $stmt = $conn->prepare("INSERT INTO player (firstname, lastname, status, team, age, license, image) 
                        VALUES (:firstname, :lastname, :status, :team, :age, :license, :image)");

                $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
                $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
                $stmt->bindParam(':status', $status, PDO::PARAM_STR);
                $stmt->bindParam(':team', $role, PDO::PARAM_STR);
                $stmt->bindParam(':age', $age, PDO::PARAM_STR);
                $stmt->bindParam(':license', $license, PDO::PARAM_STR);
                $stmt->bindParam(':image', $fileImage, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    $conn->commit();
                    echo json_encode([
                        'status' => true,
                        'message' => 'Registration successful'
                    ]);
                    exit();
                } else {
                    respondError('Error executing SQL statement');
                }
            } else {
                respondError('Error uploading image');
            }
        } else {
            respondError('Invalid or unreadable image');
        }
    } catch (Exception $e) {
        $conn->rollBack();
        respondError('Transaction failed: ' . $e->getMessage());
    }
} else {
    respondError('Invalid request method');
}