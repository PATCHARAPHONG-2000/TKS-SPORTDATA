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

    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if ($id === false || $id <= 0) {
        respondError('Invalid ID');
    }

    $dir = "../tksuploads/";
    $fileImage = '';

    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // User has uploaded a new image
        $newFileName = time() . '_' . $_FILES['image']['name'];
        $fileImage = $dir . $newFileName;
        $check = getimagesize($_FILES['image']['tmp_name']);
        if ($check) {
            if (!empty($fileImage)) {
                // Delete the old image (if any)
                $oldImage = getOldImageName($id, $conn);
                if (!empty($oldImage) && file_exists($dir . $oldImage)) {
                    unlink($dir . $oldImage);
                }

                // ตรวจสอบว่าไฟล์รูปภาพที่อัปโหลดถูกต้อง
                if (!move_uploaded_file($_FILES["image"]["tmp_name"], $fileImage)) {
                    respondError('Error uploading the image');
                }
            }
        }
    }

    $firstname = filter_input(INPUT_POST, 'firstname');
    $lastname = filter_input(INPUT_POST, 'lastname');
    $status = filter_input(INPUT_POST, 'status');
    $age = filter_input(INPUT_POST, 'age');
    $license = filter_input(INPUT_POST, 'license');

    $sql = "UPDATE `player` SET ";
    $params = [];

    if (!empty($firstname)) {
        $sql .= "`firstname` = :firstname";
        $params[':firstname'] = $firstname;
    }

    if (!empty($lastname)) {
        if (!empty($firstname)) {
            $sql .= ", ";
        }
        $sql .= "`lastname` = :lastname";
        $params[':lastname'] = $lastname;
    }

    if (!empty($status)) {
        if (!empty($firstname) || !empty($lastname)) {
            $sql .= ", ";
        }
        $sql .= "`status` = :status";
        $params[':status'] = $status;
    }

    // เพิ่มเงื่อนไขให้กับตัวแปรที่ไม่ได้ใช้ในโค้ดนี้
    if (!empty($age)) {
        if (!empty($firstname) || !empty($lastname) || !empty($status)) {
            $sql .= ", ";
        }
        $sql .= "`age` = :age";
        $params[':age'] = $age;
    }

    if (!empty($license)) {
        if (!empty($firstname) || !empty($lastname) || !empty($status) || !empty($age)) {
            $sql .= ", ";
        }
        $sql .= "`license` = :license";
        $params[':license'] = $license;
    }

    if (!empty($fileImage)) {
        if (!empty($firstname) || !empty($lastname) || !empty($status) || !empty($age) || !empty($license)) {
            $sql .= ", ";
        }
        $sql .= "`image` = :image";
        $params[':image'] = $fileImage;
    }

    $sql .= " WHERE `id` = :id";
    $params[':id'] = $id;

    $stmt = $conn->prepare($sql);

    if ($stmt->execute($params)) {
        echo json_encode([
            'status' => true,
            'message' => 'Update successful'
        ]);
    } else {
        respondError('Failed to update the record');
    }
}

function getOldImageName($id, $conn)
{
    $sql = "SELECT `image` FROM `player` WHERE `id` = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && isset($result['image'])) {
        return $result['image'];
    }

    return ''; // Return empty if no old image or an error occurred fetching data
}
?>