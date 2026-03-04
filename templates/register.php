<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVENTLY - Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans+Flex:opsz,wght@8..144,100..1000&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- 🌟 เพิ่ม SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: "Kanit", sans-serif; }
        .title_text {
            font-family: "Google Sans Flex", sans-serif;
            font-size: large;
            font-weight: bolder;
            color: white;
        }
        .register_text {
            font-size: xx-large;
            font-weight: bolder;
            color: #172554;
        }
        .login_text {
            font-size: medium;
            font-weight: 300;
            color: #172554;
        }
        div.swal2-container { font-family: "Kanit", sans-serif; }
    </style>
</head>

<body class="flex flex-row h-screen w-screen">
    <!-- panel ซ้าย -->
    <div class="flex flex-col w-2/6 h-full bg-blue-950">
        <div class="flex flex-row w-full h-[10%] items-center pl-3">
            <a href="index.php"><h1 class="title_text">EVENTLY</h1></a>
        </div>
        <!-- ตรวจสอบ path รูปภาพด้วยนะครับว่าถูกต้องไหม -->
        <img src="undraw_partying_3qad.svg" class="w-[80%] object-cover my-auto mx-auto" alt="Register Cover">
    </div>
    
    <!-- panel ขวา -->
    <main class="flex flex-col w-4/6 h-full bg-white px-10 items-center">
        <div class="w-full max-w-2xl">

            <div class="flex flex-row w-full h-32 items-center">
                <h1 class="register_text">ลงทะเบียน</h1>
            </div>

            <!-- 🌟 เปลี่ยน action ไปที่ routes -->
            <form id="registerForm" class="grid grid-cols-2 gap-x-8 gap-y-4" action="../routes/register.php" method="post">
                <div class="flex flex-col gap-2">
                    <p class="login_text">ชื่อผู้ใช้<span class="text-red-500"> *</span></p>
                    <input type="text" placeholder="ไรอัน" name="name" class="bg-gray-100 border rounded-sm pl-2 text-sm w-full h-[37px] focus:outline-none focus:ring-1 focus:ring-blue-500" required>
                </div>
                <div class="flex flex-col gap-2">
                    <p class="login_text">อีเมล<span class="text-red-500"> *</span></p>
                    <input type="email" placeholder="XXX@msu.ac.th" name="email" class="bg-gray-100 border rounded-sm pl-2 text-sm w-full h-[37px] focus:outline-none focus:ring-1 focus:ring-blue-500" required>
                </div>
                <div class="flex flex-col gap-2">
                    <p class="login_text">เบอร์โทรติดต่อ<span class="text-red-500"> *</span></p>
                    <input type="text" placeholder="0999999999" inputmode="numeric" name="phone_number" class="bg-gray-100 border rounded-sm pl-2 text-sm w-full h-[37px] focus:outline-none focus:ring-1 focus:ring-blue-500" required>
                </div>
                <div class="flex flex-col gap-2">
                    <p class="login_text">วันเกิด<span class="text-red-500"> *</span></p>
                    <input type="date" name="birthdate" class="bg-gray-100 border rounded-sm pl-2 text-gray-400 text-sm w-full h-[37px] focus:outline-none focus:ring-1 focus:ring-blue-500" required>
                </div>
                <div class="flex flex-col gap-2">
                    <p class="login_text">เพศ<span class="text-red-500"> *</span></p>
                    <select name="gender" class="bg-gray-100 border rounded-sm pl-2 text-sm w-full h-[37px] focus:outline-none focus:ring-1 focus:ring-blue-500" required>
                        <option value="ชาย">ชาย</option>
                        <option value="หญิง">หญิง</option>
                    </select>
                </div>
                <div class="flex flex-col gap-2">
                    <p class="login_text">รหัสผ่าน<span class="text-red-500"> *</span></p>
                    <input type="password" name="password" placeholder="ตั้งรหัสผ่านของคุณ" class="bg-gray-100 border rounded-sm pl-2 text-sm w-full h-[37px] focus:outline-none focus:ring-1 focus:ring-blue-500" required>
                </div>

                <button type="reset" class="login_text mt-4 bg-white border-2 rounded-sm w-full h-[37px] hover:bg-gray-50 transition">
                    ยกเลิก
                </button>
                <button type="submit" class="login_text text-white mt-4 bg-blue-950 rounded-sm w-full h-[37px] hover:bg-blue-900 transition">
                    ลงทะเบียน
                </button>

            </form>
            <div class="flex flex-row items-center w-full h-[20px] mt-14">
                <a href="login.php" class="text-blue-500 underline hover:text-blue-700 transition">
                    มีบัญชีอยู่แล้ว เข้าสู่ระบบ
                </a>
            </div>

        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // เมื่อกด Submit ฟอร์ม ให้ขึ้น Loading ป้องกันการกดเบิ้ล
            const form = document.getElementById('registerForm');
            form.addEventListener('submit', function() {
                Swal.fire({
                    title: 'กำลังดำเนินการ...',
                    text: 'กรุณารอสักครู่',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            });

            // เช็ค Error หากสมัครไม่ผ่าน (เช่น อีเมลซ้ำ)
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('status') === 'error') {
                Swal.fire({
                    icon: 'error',
                    title: 'ลงทะเบียนไม่สำเร็จ!',
                    text: 'อีเมลนี้อาจมีในระบบแล้ว หรือข้อมูลไม่ถูกต้อง',
                    confirmButtonColor: '#ef4444'
                });
                window.history.replaceState(null, null, window.location.pathname);
            }
        });
    </script>
</body>
</html>