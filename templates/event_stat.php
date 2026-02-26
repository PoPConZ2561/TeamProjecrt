<?php
session_start();
$page = "statistics";

require_once __DIR__ . '/../includes/event_stat.php'; // ตรวจสอบการเข้าสู่ระบบ


$attendance_rate = $total_approved > 0 ? round(($total_attended / $total_approved) * 100, 2) : 0;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สรุปสถิติ - <?= htmlspecialchars($event_title) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Kanit", sans-serif;
        }

        .title_text {
            color: #172554;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background-color: white;
            }

            .shadow-sm {
                box-shadow: none;
                border: 1px solid #e5e7eb;
            }
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">

    <!-- นำเข้า Header (ถ้ามี) -->
    <div class="no-print">
        <?php include 'header.php' ?>
    </div>

    <main class="max-w-6xl mx-auto pt-[100px] px-6 pb-12">

        <!-- ส่วนหัวเรื่อง และปุ่มย้อนกลับ -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b-2 border-gray-200 pb-4 mb-8">
            <div>
                <a href="manage_event.php?event_id=<?= htmlspecialchars($event_id) ?>" class="no-print text-blue-600 hover:text-blue-800 text-sm flex items-center gap-1 mb-2 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    กลับไปหน้าจัดการกิจกรรม
                </a>
                <h1 class="text-3xl font-bold title_text">📊 สรุปสถิติกิจกรรม</h1>
                <p class="text-gray-500 mt-1 text-lg"><?= htmlspecialchars($title) ?></p>
            </div>

            <button onclick="window.print()" class="no-print mt-4 md:mt-0 bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-50 transition flex items-center gap-2 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                พิมพ์รายงาน
            </button>
        </div>

        <!-- 4 กล่องสถิติ -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- กล่อง 1 -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col">
                <p class="text-gray-500 text-sm font-medium">คำขอเข้าร่วมทั้งหมด</p>
                <div class="flex items-end justify-between mt-2">
                    <h2 class="text-4xl font-bold text-blue-900"><?= number_format($total_registered) ?></h2>
                    <span class="text-blue-500 bg-blue-50 px-2 py-1 rounded text-xs font-medium">คน</span>
                </div>
            </div>

            <!-- กล่อง 2 -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col">
                <p class="text-gray-500 text-sm font-medium">อนุมัติให้เข้าร่วม</p>
                <div class="flex items-end justify-between mt-2">
                    <h2 class="text-4xl font-bold text-yellow-600"><?= number_format($total_approved) ?></h2>
                    <span class="text-yellow-600 bg-yellow-50 px-2 py-1 rounded text-xs font-medium">คน</span>
                </div>
            </div>

            <!-- กล่อง 3 -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col relative overflow-hidden">
                <div class="absolute right-0 top-0 w-2 h-full bg-green-500"></div>
                <p class="text-gray-500 text-sm font-medium">มาเข้าร่วมจริง</p>
                <div class="flex items-end justify-between mt-2">
                    <h2 class="text-4xl font-bold text-green-600"><?= number_format($total_attended) ?></h2>
                    <span class="text-green-600 bg-green-50 px-2 py-1 rounded text-xs font-medium">คน</span>
                </div>
            </div>

            <!-- กล่อง 4 -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col">
                <p class="text-gray-500 text-sm font-medium">ขาดร่วมกิจกรรม</p>
                <div class="flex items-end justify-between mt-2">
                    <h2 class="text-4xl font-bold text-red-500"><?= number_format($total_approved - $total_attended) ?></h2>
                    <span class="text-red-500 bg-red-50 px-2 py-1 rounded text-xs font-medium">คน</span>
                </div>
            </div>
        </div>

        <!-- กล่อง Progress & อัตราการเข้างาน -->
        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 mb-8">
            <h3 class="text-xl font-bold title_text mb-4">อัตราการเข้าร่วมกิจกรรม (Attendance Rate)</h3>
            <div class="flex items-center gap-4 mb-2">
                <span class="text-3xl font-bold text-purple-600"><?= $attendance_rate ?>%</span>
                <span class="text-gray-500 text-sm">ของผู้ที่ได้รับการอนุมัติทั้งหมด (<?= $total_attended ?> จาก <?= $total_approved ?> คน)</span>
            </div>

            <!-- หลอด Progress Bar -->
            <div class="w-full bg-gray-200 rounded-full h-4 mb-4 overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-blue-500 h-4 rounded-full transition-all duration-1000" style="width: <?= $attendance_rate ?>%"></div>
            </div>
        </div>
        <hr>
        <h3>สรุปเพศ</h3>

        <p>ผู้ชาย: <?= $total_male ?> คน</p>
        <p>ผู้หญิง: <?= $total_female ?> คน</p>

        <hr>
        <h3>สรุปอายุ</h3>

        <p>อายุเฉลี่ย: <?= $avg_age ?> ปี</p>
    </main>

</body>

</html>