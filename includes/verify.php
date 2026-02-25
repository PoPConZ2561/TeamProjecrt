<?php 

session_start();

$verify = "pending"; // สถานะเริ่มต้น

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $otp = $_POST['otp']; // รับ OTP จากฟอร์ม
    if (isset($_SESSION['otp_code']) && isset($_SESSION['otp_expiry'])) {
        if (time() > $_SESSION['otp_expiry']) {
            unset($_SESSION['otp_code']);
            unset($_SESSION['otp_expiry']);
        } elseif ($otp == $_SESSION['otp_code']) {
            unset($_SESSION['otp_code']);
            unset($_SESSION['otp_expiry']);
            $verify = "approved"; // อัปเดตสถานะเป็น approved
            $_SESSION["verify"] = $verify;
            header('Location: /../templates/index.php');
        }
    }
}

?>