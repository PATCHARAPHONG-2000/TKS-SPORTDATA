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

    try {
        $stmt = $conn->prepare("INSERT INTO player (firstname, lastname, status, team, age, license, image) 
                        VALUES (:firstname, :lastname, :status, :team, :age, :license, :image)");

        $role = $_SESSION['team']['role'];

        $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':team', $role, PDO::PARAM_STR);
        $stmt->bindParam(':age', $age, PDO::PARAM_INT);
        $stmt->bindParam(':license', $license, PDO::PARAM_INT);
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
