<?php
ob_start();
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ตรวจสอบข้อมูลที่รับมา
    $requiredFields = ["firstName", "lastname", "team", "gender", "email", "tell", "password", "c_password"];
    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field])) {
            respondError('ข้อมูลไม่ครบถ้วน');
        }
    }

    $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
    $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
    $team = filter_input(INPUT_POST, 'team', FILTER_SANITIZE_STRING);
    $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $tell = filter_input(INPUT_POST, 'tell', FILTER_SANITIZE_NUMBER_INT);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $c_password = filter_input(INPUT_POST, 'c_password', FILTER_SANITIZE_STRING);

    if (!$email) {
        respondError('Email ไม่ถูกต้อง');
    }

    // ตรวจสอบว่ามีอีเมล์นี้ในระบบหรือไม่
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        respondError("มีอีเมลนี้อยู่ในระบบแล้ว");
    }

    if (!preg_match('/^0[0-9]+$/', $tell)) {
        respondError('รูปแบบเบอร์โทรไม่ถูกต้อง');
    }

    if (strlen($password) < 8 || strlen($password) > 20) {
        respondError('รหัสผ่านต้องมีความยาวระหว่าง 8 ถึง 20 ตัวอักษร');
    }

    if ($password != $c_password) {
        respondError('รหัสผ่านไม่ตรงกัน');
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

    $_SESSION['otp'] = $otp;
    $_SESSION['otp_expiry'] = time() + 600;
    $_SESSION['registration_data'] = [
        'firstName' => $firstName,
        'lastname' => $lastname,
        'team' => $team,
        'gender' => $gender,
        'email' => $email,
        'tell' => $tell,
        'password' => $hashed_password,
    ];

    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'rikerpol@gmail.com'; // อีเมล์ของคุณ
        $mail->Password   = 'blxq aoju lhtc rfqo'; // รหัสผ่านของคุณ
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Email content
        $mail->setFrom('rikerpol@gmail.com', 'TKS SPORTDATA');
        $mail->addAddress($email); // อีเมล์ผู้รับ
        $mail->isHTML(true);
        $mail->CharSet = "UTF-8";
        $mail->Subject = 'ยืนยันบัญชีสมาชิกด้วย OTP';
        $mail->Body    = "ยินดีต้อนรับ: $firstName $lastname<br>
                          =================================<br>
                          กรุณากรอก OTP นี้ในเว็บไซต์เพื่อยืนยัน: $otp<br>
                          =================================<br>
                         https://www.tks-sportdata.com<br>";
        // //ตั้งค่าสำหรับการส่งอีเมล์
        // $mail->SMTPDebug = 0;
        // $mail->isSMTP();
        // $mail->Host       = 'sgsv1.hostatom.com';
        // $mail->SMTPAuth   = true;
        // $mail->Username   = 'tkssportdata@tks-sportdata.com';
        // $mail->Password   = '{Fm8W_zd_pEM_CtIjmrx';
        // $mail->SMTPSecure = 'ssl';
        // $mail->Port       = 465;

        // // เนื้อหาของอีเมล์
        // $mail->setFrom('tkssport@tks-sportdata.com', 'TKS SPORTDATA');
        // $mail->addAddress($email); // อีเมล์ผู้รับ
        // $mail->isHTML(true);
        // $mail->CharSet = "UTF-8";
        // $mail->Subject = 'ยืนยันบัญชีสมาชิกด้วย OTP';
        // $mail->Body    = "ยินดีต้อนรับ: $firstName $lastname<br>
        //                   =================================<br>
        //                   กรุณากรอก OTP นี้ในเว็บไซต์เพื่อยืนยัน: $otp<br>
        //                   =================================<br>
        //                   https://www.tks-sportdata.com/<br>";

        if ($mail->send()) {
            echo json_encode([
                'status' => true,
                'message' => 'Please check your email for the OTP'
            ]);
        } else {
            respondError('เกิดข้อผิดพลาดในการส่งอีเมล: ' . $mail->ErrorInfo);
        }
        exit();
    } catch (Exception $e) {
        respondError("Failed to send OTP. Error: {$mail->ErrorInfo}");
    }
}

ob_end_flush();
?>