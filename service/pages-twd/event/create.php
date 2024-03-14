<?php
header('Content-Type: application/json');
require_once '../../connect.php';

$Database = new Database();
$conn = $Database->connect();

function respondError($message)
{
    echo json_encode(['error' => $message]);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $age = $_POST['age'];
    $Class = $_POST['class'];
    $weight = $_POST['weight'];
    $name_match = $_POST['name_match'];

    if (isset($_POST['ids']) && !empty($_POST['ids'])) {
        $ids = $_POST['ids'];

        if (!empty($ids)) {
            $placeholders = rtrim(str_repeat('?,', count($ids)), ',');
            $sql = "SELECT * FROM player WHERE id IN ($placeholders)";
            $stmt = $conn->prepare($sql);
            $stmt->execute($ids);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($rows) {
                foreach ($rows as $row) {

                    $firstname = $row['firstname'];
                    $lastname = $row['lastname'];
                    $status = $row['status'];
                    $role = $row['team'];
                    $license = $row['license'];
                    $fileImage = $row['image'];

                    $stmt = $conn->prepare("INSERT INTO event (name_match, firstname, lastname, status, team, age, class, weight, license, image) 
                        VALUES (:name_match, :firstname, :lastname, :status, :team, :age, :class, :weight, :license, :image)");
                    $stmt->bindParam(':name_match', $name_match, PDO::PARAM_STR);
                    $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
                    $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
                    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
                    $stmt->bindParam(':team', $role, PDO::PARAM_STR);
                    $stmt->bindParam(':age', $age, PDO::PARAM_STR);
                    $stmt->bindParam(':class', $Class, PDO::PARAM_STR);
                    $stmt->bindParam(':weight', $weight, PDO::PARAM_STR);
                    $stmt->bindParam(':license', $license, PDO::PARAM_STR);
                    $stmt->bindParam(':image', $fileImage, PDO::PARAM_STR);

                    if (!$stmt->execute()) {
                        respondError('Error executing SQL statement');
                    }
                }

                $updateSql = "UPDATE player SET IsActive = 1 WHERE id IN ($placeholders)";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->execute($ids);

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
