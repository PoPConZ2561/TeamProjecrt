<?php 
// ส่วนประมวลผล Backend (ห้ามมี HTML ปน)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isVerify = null; // เริ่มต้นด้วยค่าว่าง

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $otp = $_POST['otp'] ?? ''; 
    
    if (isset($_SESSION['otp_code']) && isset($_SESSION['otp_expiry'])) {
        
        // กรณีที่ 1: OTP หมดอายุ
        if (time() > $_SESSION['otp_expiry']) {
            unset($_SESSION['otp_code']);
            unset($_SESSION['otp_expiry']);
            $isVerify = false; // ส่งค่า false ให้หน้า UI ไปจับแจ้งเตือน
            
        // กรณีที่ 2: OTP ถูกต้อง
        } elseif ($otp == $_SESSION['otp_code']) {
            unset($_SESSION['otp_code']);
            unset($_SESSION['otp_expiry']);
            
            $isVerify = true; 
            $_SESSION["isVerify"] = true;

            require_once __DIR__ . "/../includes/database.php";
            $conn = getConnection();

            $sql = "UPDATE registrations SET status = 'attended' WHERE user_id = ? AND event_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $_SESSION['user_id'], $_GET['event_id']);
            $stmt->execute();
            
        // กรณีที่ 3: OTP ไม่ถูกต้อง
        } else {
            $isVerify = false; // รหัสผิด ส่งค่า false
        }
    } else {
        // กรณีไม่มี Session OTP อยู่ในระบบ
        $isVerify = false;
    }
}
?>