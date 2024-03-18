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

    $name_match = $_POST['name_match'];
    $type_Name = $_POST['Type_Name'];
    $age_group = $_POST['team_age'];
    $weight = $_POST['team_weight'];

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

                    $ID_Number = $row['ID_Number'];
                    $firstname = $row['firstname'];
                    $lastname = $row['lastname'];
                    $gender = $row['status'];
                    $age = $row['age'];
                    $role = $row['team'];
                    $license = $row['license'];
                    $fileImage = $row['image'];

                    $stmt = $conn->prepare("INSERT INTO event ( ID_Number, firstname, lastname, gender, team, age, license, image, name_match, type_Name, age_group, weight) 
                        VALUES (:ID_Number, :firstname, :lastname, :gender, :team, :age, :license, :image, :name_match, :type_Name, :age_group, :weight)");
                    $stmt->bindParam(':ID_Number', $ID_Number, PDO::PARAM_STR);
                    $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
                    $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
                    $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
                    $stmt->bindParam(':age', $age, PDO::PARAM_STR);
                    $stmt->bindParam(':team', $role, PDO::PARAM_STR);
                    $stmt->bindParam(':license', $license, PDO::PARAM_STR);
                    $stmt->bindParam(':image', $fileImage, PDO::PARAM_STR);
                    $stmt->bindParam(':name_match', $name_match, PDO::PARAM_STR);
                    $stmt->bindParam(':type_Name', $type_Name, PDO::PARAM_STR);
                    $stmt->bindParam(':age_group', $age_group, PDO::PARAM_STR);
                    $stmt->bindParam(':weight', $weight, PDO::PARAM_STR);

                    if (!$stmt->execute()) {
                        respondError('Error executing SQL statement');
                    }
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
