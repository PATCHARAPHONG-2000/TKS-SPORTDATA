<?php
header('Content-Type: application/json');
require_once '../../../connect.php'; 

$Database = new Database();
$connect = $Database->connect();

if ($connect) {

    $query = 'SELECT * FROM data_all ';
    $stmt = $connect->prepare($query);
    $stmt->execute();

    if ($stmt) {
        $data = array();
        foreach ($stmt->fetchAll() as $row) {
            $data[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'image' => $row['image'],
            ];
        }
        $response = [
            'status' => true,
            'message' => 'Get Data Manager Success',
            'response' => $data
        ];
    } else {
        $response['message'] = 'Failed to retrieve data from the database';
    }

}

echo json_encode($response);
?>