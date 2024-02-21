<?php
header('Content-Type: application/json');

$response = [
    'status' => false,
    'message' => 'An error occurred',
    'response' => []
];

require_once '../connect.php'; // ปรับเส้นทางตามความเหมาะสม

$Database = new Database();
$connect = $Database->connect();

if ($connect) { 
    
        $query = 'SELECT * FROM player';
        $stmt = $connect->prepare($query);
        $stmt->execute();

        if ($stmt) {
            $data = array();
            foreach ($stmt->fetchAll() as $row) {
                $data[] = [
                    'id' => $row['id'], 
                    'firstname' => $row['firstname'],
                    'lastname' => $row['lastname'],
                    'team' => $row['team'],
                    'status' => $row['status'],
                    'age' => $row['age'], // เพิ่ม key ตามคำสั่ง SQL
                    'license' => $row['license'], // เพิ่ม key ตามคำสั่ง SQL
                    'image' => $row['image'],
                ];
            }
            echo json_encode ( [
                'status' => true,
                'message' => 'Get Data Manager Success',
                'response' => $data
            ]);
        } else {
            $response['message'] = 'Failed to retrieve data from the database';
        }
    
}