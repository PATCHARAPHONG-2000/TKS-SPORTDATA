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
    $users = $_POST['username'];
    $password = $_POST['password'];
    
    try {
        $stmt = $conn->prepare("SELECT * FROM users_t WHERE users = :users");
        $stmt->bindParam(':users', $users);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user['password'])) {

                $_SESSION['AD_ID'] = $user['id'];
                $_SESSION['AD_USERNAME'] = $user['users'];
                $_SESSION['AD_ROLE'] = $user['Role'];

                if ($_SESSION['AD_ROLE']) {
                    
                    $_SESSION['karate'] = [
                        'role' => $user['Role'],
                        'users' => $user['users'],
                    ];
                    echo json_encode([
                        'status' => true,
                        'users' => 'karate',
                        'role' => $user['users'],
                        'message' => 'Login Success'
                    ]);
                    exit();
                }
            } else {
                respondError('รหัสผ่านไม่ถูกต้อง');
            }
        }else {
            respondError('ไม่พบยูสเซอร์นี้ในระบบ กรุณากรอกยูสเซอร์ที่ถูกต้อง');
        }
    } catch (PDOException $e) {
        respondError("An error occurred. Please try again later.");
    }
}