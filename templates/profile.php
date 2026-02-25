<?php
session_start();
$page = 'profile';

// 1. ตรวจสอบว่าเข้าสู่ระบบหรือยัง ถ้ายังให้เด้งกลับไปหน้า login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// ป้องกัน Error กรณีบางตัวแปรไม่มีค่าใน Session
$user_name = $_SESSION['name'] ?? 'ไม่ระบุชื่อ';
$user_email = $_SESSION['email'] ?? 'ไม่ระบุอีเมล';
$user_birthdate = isset($_SESSION['birthdate']) ? date('d / m / Y', strtotime($_SESSION['birthdate'])) : '-';
$user_phone = $_SESSION['phone_number'] ?? '-';
$user_gender = $_SESSION['gender'] ?? '-';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVENTLY - My Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: "Kanit", sans-serif; }
    </style>
</head>

<body class="flex flex-col min-h-screen w-full bg-gray-50">
    
    <?php include 'header.php' ?>
    
    <main class="flex-grow flex items-center justify-center pt-[100px] pb-12 px-4 md:px-8">

        <!-- กล่องการ์ดหลัก (Responsive: มือถือเรียงลงล่าง, คอมแบ่งซ้ายขวา) -->
        <div class="flex flex-col md:flex-row w-full max-w-4xl bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <!-- ========================================== -->
            <!-- Panel ซ้าย: รูปและชื่อ (ใช้พื้นหลังสีน้ำเงินเข้ม) -->
            <!-- ========================================== -->
            <div class="w-full md:w-2/5 bg-gradient-to-b from-blue-900 to-blue-950 p-10 flex flex-col items-center justify-center text-center">
                
                <!-- รูปโปรไฟล์อัจฉริยะ (สร้างจากชื่อ) -->
                <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-white/20 shadow-lg mb-5 bg-white shrink-0">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($user_name) ?>&background=E0E7FF&color=3730A3&font-family=Kanit&bold=true&size=128" 
                         alt="Profile" 
                         class="w-full h-full object-cover">
                </div>
                
                <h1 class="text-2xl font-bold text-white mb-1"><?= htmlspecialchars($user_name); ?></h1>
                <p class="text-blue-200 text-sm font-light bg-blue-900/50 px-3 py-1 rounded-full border border-blue-800/50">
                    <?= htmlspecialchars($user_email); ?>
                </p>
            </div>

            <!-- ========================================== -->
            <!-- Panel ขวา: ข้อมูลส่วนตัว -->
            <!-- ========================================== -->
            <div class="w-full md:w-3/5 p-8 lg:p-10 flex flex-col">
                
                <h2 class="text-xl font-bold text-gray-800 border-b border-gray-100 pb-4 mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                    ข้อมูลส่วนตัว
                </h2>

                <!-- ตารางข้อมูล -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-8 mb-8">
                    
                    <div class="flex flex-col gap-1">
                        <span class="text-sm font-medium text-gray-500 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            ชื่อ - นามสกุล
                        </span>
                        <p class="text-lg text-gray-900 font-medium"><?= htmlspecialchars($user_name); ?></p>
                    </div>
                    
                    <div class="flex flex-col gap-1">
                        <span class="text-sm font-medium text-gray-500 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            วันเกิด
                        </span>
                        <p class="text-lg text-gray-900 font-medium"><?= $user_birthdate; ?></p>
                    </div>
                    
                    <div class="flex flex-col gap-1">
                        <span class="text-sm font-medium text-gray-500 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            อีเมล
                        </span>
                        <p class="text-lg text-gray-900 font-medium"><?= htmlspecialchars($user_email); ?></p>
                    </div>
                    
                    <div class="flex flex-col gap-1">
                        <span class="text-sm font-medium text-gray-500 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            เบอร์โทรศัพท์
                        </span>
                        <p class="text-lg text-gray-900 font-medium"><?= htmlspecialchars($user_phone); ?></p>
                    </div>
                    
                    <div class="flex flex-col gap-1">
                        <span class="text-sm font-medium text-gray-500 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            เพศ
                        </span>
                        <p class="text-lg text-gray-900 font-medium"><?= htmlspecialchars($user_gender); ?></p>
                    </div>
                    
                </div>

                <!-- ========================================== -->
                <!-- แถบปุ่มด้านล่าง -->
                <!-- ========================================== -->
                <div class="mt-auto flex flex-col sm:flex-row justify-between items-center gap-4 pt-6 border-t border-gray-100">
                    
                    <!-- ปุ่มกลับหน้าหลัก -->
                    <a href="index.php" class="w-full sm:w-auto px-6 py-2.5 bg-gray-50 hover:bg-gray-100 text-gray-700 font-medium rounded-lg border border-gray-200 transition-colors flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                        </svg>
                        กลับหน้าหลัก
                    </a>

                    <!-- ปุ่มแก้ไขข้อมูลส่วนตัว -->
                    <a href="edit_profile.php" class="w-full sm:w-auto px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-all hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>
                        แก้ไขข้อมูลส่วนตัว
                    </a>

                </div>

            </div>

        </div>

    </main>

    <?php include 'footer.php' ?>
</body>
</html>