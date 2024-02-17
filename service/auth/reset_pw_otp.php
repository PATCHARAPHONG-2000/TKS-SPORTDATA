<?php

require_once '../connect.php';

$Database = new Database();
$conn = $Database->connect();

function respondError($message)
{
    echo json_encode(['error' => $message]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    if (isset($_SESSION['resetting_password'])) {
       
        $new_password = filter_input(INPUT_POST, 'new_password', FILTER_SANITIZE_STRING); 
        $confirm_password = filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_STRING);
        
       
        if ($new_password !== false && $confirm_password !== false) {
            
            if ($new_password === $confirm_password) {
                $email = $_SESSION['email'];

                $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();
                $user = $stmt->fetch();
                
                if ($user) {
                    $tableToUpdate = 'users';
                } else {
                    respondError('ไม่พบอีเมลนี้ในระบบ กรุณากรอกอีเมลอีกครั้ง');
                }

                $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);

                $updatePasswordQuery = "UPDATE $tableToUpdate SET password = :password WHERE email = :email";
                $stmtUpdate = $conn->prepare($updatePasswordQuery);
                $stmtUpdate->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
                $stmtUpdate->bindParam(':email', $email, PDO::PARAM_STR);
                $stmtUpdate->execute();

                unset($_SESSION['resetting_password'], $_SESSION['email']);
                
                echo json_encode([
                    'status' => true,
                    'message' => 'Password reset successful'
                ]);
                exit();
            } else {
                respondError('รหัสผ่านและยืนยันรหัสผ่านไม่ตรงกัน');
            }
        } else {
            respondError('กรุณากรอกรหัสผ่านใหม่และยืนยันรหัสผ่าน');
        }
    } else {
        $submitted_otp = filter_input(INPUT_POST, 'otp', FILTER_SANITIZE_NUMBER_INT);

        if ($submitted_otp !== false) {
            if (isset($_SESSION['otp'], $_SESSION['email']) && time() <= $_SESSION['otp_expiry']) {
                if ($_SESSION['otp'] == $submitted_otp) {
                    $_SESSION['resetting_password'] = true; 
                    
                    echo json_encode([
                        'status' => true,
                        'message' => 'OTP is valid. Please enter your new password.'
                    ]);
                    exit();
                } else {
                    http_response_code(401);
                    echo json_encode([
                        'status' => false,
                        'message' => 'Invalid OTP',
                    ]);
                    exit();
                }
            } else {
                http_response_code(401);
                echo json_encode([
                    'status' => false,
                    'message' => 'OTP has expired or is missing',
                ]);
                exit();
            }
        } else {
            respondError('Invalid OTP format');
        }
    }
}
?>