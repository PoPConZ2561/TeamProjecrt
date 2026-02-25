<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// 1. โหลดไฟล์ PHPMailer (หากใช้ Composer ให้ใช้ require 'vendor/autoload.php')
require __DIR__ . '/../public/Exception.php';
require __DIR__ . '/../public/PHPMailer.php';
require __DIR__ . '/../public/SMTP.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_email = $_POST['email']; // รับอีเมลจากฟอร์ม

    // 2. สร้าง OTP 6 หลัก
    $otp = rand(100000, 999999);
    $_SESSION['otp_code'] = $otp;
    $_SESSION['otp_expiry'] = time() + 1800; // หมดอายุใน 30 นาที

    // 3. ตั้งค่าการส่ง Email
    $mail = new PHPMailer(true);

    try {
        // ตั้งค่า Server
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';         // SMTP ของ Gmail
        $mail->SMTPAuth   = true;
        $mail->Username   = '67011212051@msu.ac.th';   // อีเมลของคุณ
        $mail->Password   = 'qhax epnf zhaq uvlr';      // App Password 16 หลัก
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        // ผู้รับ-ผู้ส่ง
        $mail->setFrom('your_email@gmail.com', 'ระบบลงทะเบียน Event');
        $mail->addAddress($user_email);

        // เนื้อหา Email
        $mail->isHTML(true);
        $mail->Subject = 'รหัส OTP สำหรับเข้างานของคุณ';
        $mail->Body    = "
            <div style='font-family: sans-serif; padding: 20px; border: 1px solid #eee;'>
                <h2>ยืนยันตัวตนเข้าใช้งาน</h2>
                <p>รหัส OTP ของคุณคือ:</p>
                <h1 style='color: #4F46E5; letter-spacing: 5px;'>$otp</h1>
                <p>รหัสนี้จะหมดอายุภายใน 30 นาที</p>
                <hr>
                <small>หากคุณไม่ได้ร้องขอรหัสนี้ โปรดเพิกเฉยต่ออีเมลฉบับนี้</small>
            </div>
        ";

        $mail->send();
        echo "ส่ง OTP ไปที่ $user_email สำเร็จแล้ว!";
    } catch (Exception $e) {
        echo "ส่งไม่สำเร็จเนื่องจาก: {$mail->ErrorInfo}";
    }

    header('Location: verifyOTP.php');
}
?>

<!DOCTYPE html>
<html>

<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 flex items-center justify-center min-h-screen">
    <form method="POST" class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-sm">
        <h1 class="text-xl font-bold mb-4">รับรหัสผ่านทาง Email</h1>
        <input type="email" name="email" placeholder="example@gmail.com" required
            class="w-full border p-3 rounded-xl mb-4 outline-none focus:ring-2 focus:ring-indigo-500">
        <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-xl font-bold">
            ส่งรหัส OTP
        </button>
    </form>
</body>

</html>