<?php
session_start();
$page = "index";

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVENTLY - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans+Flex:opsz,wght@8..144,100..1000&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- 🌟 เพิ่ม SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: "Kanit", sans-serif; }
        .title_text {
            font-family: "Google Sans Flex", sans-serif;
            font-size: 2em;
            font-weight: bolder;
            color: #172554;
        }
        .register_text {
            font-size: xx-large;
            font-weight: bolder;
            color: #172554;
        }
        .login_text {
            font-size: medium;
            font-weight: 300;
            color: white;
        }
        div.swal2-container { font-family: "Kanit", sans-serif; }
    </style>
</head>

<body class="flex flex-col min-h-screen w-full justify-between">
    <?php include 'header.php'?>
    
    <main class="flex flex-grow flex-col items-center justify-center w-full bg-gray-200">
        <div class="flex flex-row w-[60%] h-[500px] bg-white rounded-lg shadow-md mt-10 overflow-hidden">
            <div class="flex w-[55%] h-full border-r bg-gray-50">
                <!-- ตรวจสอบ path รูปภาพด้วยนะครับ -->
                <img src="undraw_people_ka7y.svg" class="w-[80%] mx-auto my-auto object-cover" alt="Login Cover">
            </div>
            <div class="flex flex-col w-[45%] p-8 gap-4 justify-center">
                <h1 class="register_text mb-4">เข้าสู่ระบบ</h1>
                
                <!-- 🌟 เปลี่ยน action ไปที่ routes -->
                <form id="loginForm" action="../routes/check_login.php" method="post" class="flex flex-col gap-5">
                    <input type="email" name="email" placeholder="อีเมล" class="px-4 w-full h-[45px] border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <input type="password" name="password" placeholder="รหัสผ่าน" class="px-4 w-full h-[45px] border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <button type="submit" class="login_text w-full h-[45px] bg-blue-950 rounded-md hover:bg-blue-900 transition mt-2">
                        ยืนยัน
                    </button>
                </form>
                
                <a href="register.php" class="w-full mt-6 text-center">
                    <p class="text-blue-500 underline hover:text-blue-700 transition">สมัครบัญชีใหม่</p>
                </a>
            </div>
        </div> 
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            
            // 1. ดักจับกรณีเพิ่ง "สมัครสมาชิกเสร็จ" (มาจากหน้า register)
            if (urlParams.get('status') === 'register_success') {
                Swal.fire({
                    icon: 'success',
                    title: 'ลงทะเบียนสำเร็จ!',
                    text: 'คุณสามารถเข้าสู่ระบบด้วยอีเมลและรหัสผ่านที่สมัครได้เลย',
                    confirmButtonColor: '#10b981' // สีเขียว
                });
                window.history.replaceState(null, null, window.location.pathname);
            }
            
            // 2. ดักจับกรณี "ล็อกอินผิด"
            if (urlParams.get('error') === '1') {
                Swal.fire({
                    icon: 'error',
                    title: 'เข้าสู่ระบบล้มเหลว',
                    text: 'อีเมลหรือรหัสผ่านไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง',
                    confirmButtonColor: '#ef4444' // สีแดง
                });
                window.history.replaceState(null, null, window.location.pathname);
            }

            // 3. ป้องกันการกดรัวๆ
            const form = document.getElementById('loginForm');
            form.addEventListener('submit', function() {
                Swal.fire({
                    title: 'กำลังเข้าสู่ระบบ...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            });
        });
    </script>
</body>
</html>