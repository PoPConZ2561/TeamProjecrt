<?php
// ตรวจสอบสถานะก่อนเริ่ม Session เพื่อป้องกัน Error
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['user_id']) && !isset($_GET['event_id'])){
    header("Location: index.php");
    exit();
}

require_once __DIR__ . "/../routes/verify.php";

// ==========================================
// 🌟 ระบบเซ็นเซอร์อีเมล (Email Masking)
// ==========================================
$user_email = $_SESSION['email'] ?? 'unknown@example.com';
$email_parts = explode("@", $user_email);
$masked_email = $user_email;

if (count($email_parts) === 2) {
    $name_part = $email_parts[0];
    $domain_part = $email_parts[1];
    
    // ถ้าชื่ออีเมลยาวกว่า 4 ตัวอักษร ให้โชว์ 2 ตัวหน้า และ 2 ตัวหลัง
    if (strlen($name_part) > 4) {
        $masked_name = substr($name_part, 0, 2) . str_repeat("*", strlen($name_part) - 4) . substr($name_part, -2);
    } 
    // ถ้าชื่ออีเมลสั้นกว่านั้น ให้โชว์แค่ตัวแรกกับตัวสุดท้าย
    elseif (strlen($name_part) > 2) {
        $masked_name = substr($name_part, 0, 1) . str_repeat("*", strlen($name_part) - 2) . substr($name_part, -1);
    } 
    // สั้นมาก เซ็นเซอร์หมดเลย
    else {
        $masked_name = str_repeat("*", strlen($name_part));
    }
    $masked_email = $masked_name . "@" . $domain_part;
}

// เอา event_id เผื่อใช้ส่ง OTP ซ้ำ
$event_id_param = isset($_GET['event_id']) ? "?event_id=" . htmlspecialchars($_GET['event_id']) : "";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVENTLY - Verify OTP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans+Flex:opsz,wght@8..144,100..1000&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    
    <!-- 🌟 เพิ่ม SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        .title_text {
            font-family: "Google Sans Flex", sans-serif;
            font-size: 2em;
            font-weight: bolder;
            color: #172554;
            line-height: 100%;
        }
        .register_text {
            font-family: "Kanit", sans-serif;
            font-size: xx-large;
            font-weight: bolder;
            color: #172554;
        }
        .option_header_text {
            font-family: "Kanit", sans-serif;
            font-size: 15px;
            font-weight: 300;
            color: #4b5563; /* ปรับสีให้อ่านง่ายขึ้น */
        }
        .login_text {
            font-family: "Kanit", sans-serif;
            font-size: medium;
            font-weight: 400;
            color: white;
        }
        div.swal2-container { font-family: "Kanit", sans-serif; }
    </style>
</head>

<body class="flex flex-col min-h-screen w-full justify-between bg-gray-200">
    <?php include 'header.php' ?>
    
    <main class="flex flex-grow flex-col items-center justify-center w-full">
        <div class="flex flex-row w-[60%] h-[500px] bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="flex flex-row items-center justify-center w-[50%] h-full bg-blue-50 border-r border-gray-100">
                <img src="undraw_system-update_gekm.svg" class="w-[75%] mx-auto my-auto object-cover" alt="Verify OTP">
            </div>
            
            <div class="flex flex-col justify-center w-[50%] h-full p-10 relative">
                <div class="flex flex-col w-full h-full justify-center">
                    
                    <div class="flex flex-col gap-2 mb-6">
                        <h1 class="register_text">ยืนยันรหัส OTP</h1>
                        <!-- 🌟 แสดงอีเมลที่เซ็นเซอร์แล้ว -->
                        <h2 class="option_header_text">ระบบได้ส่งรหัส 6 หลัก ไปยังอีเมล<br><span class="font-semibold text-blue-600"><?= $masked_email ?></span></h2>
                    </div>

                    <form id="otpForm" method="post" action="" class="flex flex-col gap-4">
                        <input
                            type="text"
                            maxlength="6"
                            inputmode="numeric"
                            placeholder="------"
                            name="otp"
                            required
                            class="w-full h-14 text-center text-3xl tracking-[0.5em] font-bold text-gray-700
                            border-2 border-gray-300 rounded-lg
                            py-3 outline-none transition-colors
                            focus:border-blue-600 focus:ring-1 focus:ring-blue-600" />
                        
                        <button type="submit" name="button_click" class="login_text w-full h-12 bg-blue-900 hover:bg-blue-950 transition-colors rounded-lg shadow-sm mt-2">
                            ยืนยันรหัส
                        </button>
                    </form>

                    <!-- 🌟 แก้ไข Path ลิงก์ขอรหัสใหม่ให้ถูกต้อง -->
                    <a href="../routes/OTP.php<?= $event_id_param ?>" class="mt-6 text-center">
                        <span class="text-sm font-['Kanit'] text-gray-500 hover:text-blue-600 transition-colors underline">ขอรหัส OTP ใหม่อีกครั้ง</span>
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- 🌟 Script จัดการระบบแจ้งเตือน SweetAlert2 -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // ดักจับการกดปุ่ม Submit เพื่อโชว์ Loading (กันผู้ใช้กดเบิ้ล)
            const form = document.getElementById('otpForm');
            if(form) {
                form.addEventListener('submit', function() {
                    Swal.fire({
                        title: 'กำลังตรวจสอบรหัส...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                });
            }

            <?php if (isset($isVerify) && $isVerify === true): ?>
                // กรณี: ยืนยันสำเร็จ
                Swal.fire({
                    icon: 'success',
                    title: 'ยืนยันสำเร็จ!',
                    text: 'รหัส OTP ถูกต้อง ระบบกำลังพาท่านเข้าสู่กิจกรรม',
                    confirmButtonColor: '#10b981',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    // พอแจ้งเตือนเสร็จ ให้พาเด้งกลับไปหน้าแรก (หรือหน้าที่คุณต้องการ)
                    window.location.href = 'index.php';
                });

            <?php elseif (isset($isVerify) && $isVerify === false && $_SERVER['REQUEST_METHOD'] === 'POST'): ?>
                // กรณี: ยืนยันรหัสผิด
                Swal.fire({
                    icon: 'error',
                    title: 'รหัส OTP ไม่ถูกต้อง หรือหมดอายุ',
                    text: 'กรุณาตรวจสอบรหัสจากอีเมลของท่านใหม่อีกครั้ง หรือกดขอรหัสใหม่',
                    confirmButtonColor: '#ef4444'
                });
            <?php endif; ?>
            
        });
    </script>
</body>

</html>