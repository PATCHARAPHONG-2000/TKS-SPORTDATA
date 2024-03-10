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
    // ตรวจสอบค่า ID
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if ($id === false || $id <= 0) {
        respondError('Invalid ID');
    }

    $class = trim(filter_input(INPUT_POST, 'class'));
    $age = trim(filter_input(INPUT_POST, 'age'));
    $weigth = trim(filter_input(INPUT_POST, 'weigth'));

    if (empty($class) && empty($weigth) && empty($age)) {
        respondError('At least one field (class, age, weigth) must not be empty');
    }

    if (!empty($class) || !empty($weigth) || !empty($age)) {
        
        $sql = "UPDATE `event` SET ";
        $params = array();
        
        if (!empty($class)) {
            $sql .= "`class` = :class";
            $params[':class'] = $class;
        }

        if (!empty($weigth)) {
            if (!empty($class)) {
                $sql .= ", ";
            }
            $sql .= "`weigth` = :weigth";
            $params[':weigth'] = $weigth;
        }

        if (!empty($age)) {
            if (!empty($class) || !empty($weigth)) {
                $sql .= ", ";
            }
            $sql .= "`age` = :age";
            $params[':age'] = $age;
        }
      
        $sql .= " WHERE `id` = :id";
        $params[':id'] = $id;

        $stmt = $conn->prepare($sql);
        if ($stmt->execute($params)) {
            echo json_encode(array(
                'status' => true,
                'message' => 'Update successful'
            ));
        } else {
            respondError('Failed to update the record');
        }
    } else {
        respondError('No data to update');
    }
}
?>