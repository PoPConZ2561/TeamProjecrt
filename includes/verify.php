<?php 

session_start();

$isVerify = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $otp = $_POST['otp']; // รับ OTP จากฟอร์ม
    if (isset($_SESSION['otp_code']) && isset($_SESSION['otp_expiry'])) {
        if (time() > $_SESSION['otp_expiry']) {
            unset($_SESSION['otp_code']);
            unset($_SESSION['otp_expiry']);
        } elseif ($otp == $_SESSION['otp_code']) {
            unset($_SESSION['otp_code']);
            unset($_SESSION['otp_expiry']);
            $isVerifyy = true; 
            $_SESSION["isVerify"] = $isVerify;

            require("database.php");
            $conn = getConnection();

            $sql = "UPDATE registrations SET status = 'attended' WHERE user_id = ? AND event_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $_SESSION['user_id'], $_GET['event_id']);
            $stmt->execute();

            header('Location: /../templates/index.php');
        }
    }
}
?>