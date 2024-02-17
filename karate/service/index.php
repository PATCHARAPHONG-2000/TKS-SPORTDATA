<?php
require_once '../../service/connect.php';

$Database = new Database();
$conn = $Database->connect();

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

$adRole = isset($_SESSION['AD_ROLE']) ? $_SESSION['AD_ROLE'] : '';

$sql = $conn->prepare("SELECT * FROM data_score WHERE Role = :role ORDER BY finalsum DESC");
$sql->bindParam(':role', $adRole, PDO::PARAM_STR);
$sql->execute();
$data = [];

while ($score = $sql->fetch(PDO::FETCH_ASSOC)) {
    $data[] = [
        'id' => $score['id'],
        'Name' => $score['Name'],
        'finalsum' => $score['finalsum']
    ];
}

echo "data: " . json_encode($data) . "\n\n";
ob_flush();
flush();

exit(); // จบการทำงานของ script หลังจากส่งข้อมูล
?>
