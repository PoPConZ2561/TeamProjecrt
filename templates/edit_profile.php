<?php
session_start();
$page = 'profile'; // ให้เมนูหรือ header ยังจำว่าเราอยู่ในหมวด profile

// 1. ตรวจสอบการล็อกอิน
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVENTLY - Edit Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- 🌟 เพิ่ม SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body { font-family: "Kanit", sans-serif; }
        .title_text { color: #172554; }
        /* ปรับแต่งฟอนต์ให้ SweetAlert2 ใช้ฟอนต์ Kanit ด้วย */
        div.swal2-container { font-family: "Kanit", sans-serif; }
    </style>
</head>

<body class="bg-gray-50 flex flex-col h-screen w-full">
    
    <?php include 'header.php' ?>

    <main class="flex-grow flex items-center justify-center pt-[100px] pb-10 px-4">
        
        <!-- กล่องฟอร์มแก้ไขข้อมูล -->
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-2xl border border-gray-100">
            
            <div class="flex items-center gap-3 mb-6 border-b pb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-blue-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>
                <h2 class="text-2xl font-bold title_text">แก้ไขข้อมูลส่วนตัว</h2>
            </div>
            
            <!-- เพิ่ม id="editProfileForm" เพื่อใช้ดักจับด้วย JavaScript -->
            <form id="editProfileForm" action="../includes/edit_profile.php" method="POST" class="space-y-5">
                
                <!-- ชื่อ-นามสกุล -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ชื่อ - นามสกุล <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($_SESSION['name']); ?>" required
                           class="w-full border border-gray-300 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow">
                </div>
                
                <!-- อีเมล (อ่านได้อย่างเดียว) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">อีเมล <span class="text-gray-400 text-xs font-normal ml-2">(ไม่อนุญาตให้แก้ไข)</span></label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" readonly
                           class="w-full border border-gray-200 bg-gray-100 text-gray-500 rounded-md px-4 py-2.5 cursor-not-allowed focus:outline-none">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- เบอร์โทรศัพท์ -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">เบอร์โทรศัพท์ <span class="text-red-500">*</span></label>
                        <input type="tel" name="phone_number" value="<?php echo htmlspecialchars($_SESSION['phone_number']); ?>" required
                               class="w-full border border-gray-300 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow">
                    </div>
                    
                    <!-- วันเกิด -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">วันเกิด <span class="text-red-500">*</span></label>
                        <input type="date" name="birthdate" value="<?php echo htmlspecialchars($_SESSION['birthdate']); ?>" required
                               class="w-full border border-gray-300 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow">
                    </div>
                </div>

                <!-- เพศ -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">เพศ <span class="text-red-500">*</span></label>
                    <select name="gender" required class="w-full border border-gray-300 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow bg-white">
                        <option value="ชาย" <?php echo ($_SESSION['gender'] == 'ชาย') ? 'selected' : ''; ?>>ชาย</option>
                        <option value="หญิง" <?php echo ($_SESSION['gender'] == 'หญิง') ? 'selected' : ''; ?>>หญิง</option>
                    </select>
                </div>

                <!-- ปุ่ม กดยกเลิก หรือ บันทึก -->
                <div class="flex justify-end gap-3 pt-6 border-t mt-8">
                    <a href="profile.php" class="px-6 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-md hover:bg-gray-100 transition-colors">
                        ยกเลิก
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 shadow-sm transition-colors">
                        บันทึกการเปลี่ยนแปลง
                    </button>
                </div>

            </form>
        </div>
    </main>

    <!-- 🌟 สคริปต์ควบคุม SweetAlert2 -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // 1. ดักจับการกดปุ่ม Submit ฟอร์ม
            const form = document.getElementById('editProfileForm');
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // หยุดการส่งฟอร์มชั่วคราว
                
                // แสดง SweetAlert2 เพื่อยืนยัน
                Swal.fire({
                    title: 'ยืนยันการบันทึก?',
                    text: "คุณต้องการอัปเดตข้อมูลส่วนตัวใช่หรือไม่",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#2563eb', // สีปุ่มยืนยัน (สีฟ้า Tailwind)
                    cancelButtonColor: '#d1d5db',  // สีปุ่มยกเลิก (สีเทา)
                    confirmButtonText: 'ใช่, บันทึกเลย!',
                    cancelButtonText: 'ยกเลิก',
                    reverseButtons: true // สลับให้ปุ่มยืนยันอยู่ขวามือ
                }).then((result) => {
                    if (result.isConfirmed) {
                        // ถ้าผู้ใช้กดยืนยัน ให้ส่งฟอร์มไปให้ PHP ประมวลผลจริงๆ
                        form.submit();
                    }
                });
            });

            // 2. เช็ค URL ว่ามี ?status=error ส่งกลับมาหรือไม่ (เผื่ออนาคตคุณปรับหลังบ้าน)
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('status') === 'error') {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด!',
                    text: 'ไม่สามารถอัปเดตข้อมูลได้ กรุณาลองใหม่อีกครั้ง',
                    confirmButtonColor: '#ef4444'
                });
                // ลบ parameter ออกจาก URL เพื่อไม่ให้แจ้งเตือนซ้ำตอนรีเฟรช
                window.history.replaceState(null, null, window.location.pathname);
            }
        });
    </script>
</body>
</html>