<?php
ob_start();
header('Content-Type: application/json');

require_once '../connect.php';
require_once "../../assets/PHPMailer/src/Exception.php";
require_once "../../assets/PHPMailer/src/PHPMailer.php";
require_once "../../assets/PHPMailer/src/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$Database = new Database();
$conn = $Database->connect();

function respondError($message)
{
    echo json_encode(['error' => $message]);
    exit();
}

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!$email) {
        // ถ้า email ไม่ถูกต้องหรือไม่ได้กรอก
        respondError('กรุณากรอกอีเมลของคุณ');
    }
    

    // Check if email exists in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user) {
        // Email exists in the system, proceed to send OTP
        $otp_generated = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $_SESSION['otp'] = $otp_generated;
        $_SESSION['otp_expiry'] = time() + 600;
        $_SESSION['email'] = $email;

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'rikerpol@gmail.com'; // Your email
            $mail->Password   = 'blxq aoju lhtc rfqo'; // Your password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            // Email content
            $mail->setFrom('rikerpol@gmail.com', 'TKS SPORTDATA');
            $mail->addAddress($email); // Recipient email
            $mail->isHTML(true);
            $mail->CharSet = "UTF-8";
            $mail->Subject = 'ยืนยัน OTP เพื่อรีเซ็ตรหัสผ่าน';
            $mail->Body    = "ยินดีต้อนรับ: $email<br>
                              =================================<br>
                              กรุณากรอก OTP นี้ในเว็บไซต์เพื่อยืนยัน: $otp_generated<br>
                              =================================<br>
                              YourSite.com<br>";

            $mail->send(); // Send email

            echo json_encode([
                'status' => true,
                'message' => 'Email sent successfully'
            ]);
            exit();
        } catch (Exception $e) {
            respondError("Failed to send OTP. Error: {$mail->ErrorInfo}");
        }
    } else {
        // Email does not exist in the system
        echo json_encode([
            'status' => false,
            'message' => 'ไม่มีอีเมลนี้ในระบบ กรุณาลองใหม่อีกครั้ง'
        ]);
        exit();
    }
}
?>