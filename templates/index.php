<?php
session_start();
$page = "index";

// เก็บค่าที่ผู้ใช้ค้นหาไว้เพื่อนำกลับมาแสดงในช่องกรอก (จะได้รู้ว่ากำลังค้นหาอะไรอยู่)
$search_query = $_GET['search'] ?? '';
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVENTLY - main</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans+Flex:opsz,wght@8..144,100..1000&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        .title_text {
            font-family: "Google Sans Flex", sans-serif;
            font-size: 2em;
            font-weight: bolder;
            color: #172554;
            line-height: 100%;
        }

        .option_header_text {
            font-family: "Kanit", sans-serif;
        }

        .option_text {
            font-family: "Kanit", sans-serif;
            font-size: small;
            color: #172554;
        }

        /* ซ่อน Scrollbar ของแถบซ้ายแต่อยู่ให้เลื่อนได้ */
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>

<body class="flex flex-col min-h-screen w-full bg-gray-50">
    
    <?php include 'header.php' ?>
    
    <!-- เปลียน flex-row เป็น flex-col lg:flex-row เพื่อให้รองรับมือถือ -->
    <main class="flex flex-grow flex-col items-center w-full bg-gray-50 pt-[100px] pb-12">
        <div class="flex flex-col lg:flex-row w-[90%] lg:w-[85%] max-w-[1400px] h-full gap-8">
            
            <!-- ========================================== -->
            <!-- แถบด้านซ้าย: ตัวคัดกรอง (Sidebar) -->
            <!-- ========================================== -->
            <div class="w-full lg:w-[25%] xl:w-[22%] shrink-0">
                <!-- ใช้ sticky เพื่อให้เลื่อนตามกรอบจอ (เลิกใช้ fixed) -->
                <div class="sticky top-[100px] flex flex-col bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    
                    <div class="flex flex-row items-center w-full mb-4">
                        <h2 class="option_header_text text-orange-400 text-2xl font-bold">ตัวคัดกรอง</h2>
                    </div>

                    <!-- ฟอร์มค้นหา: กด Enter จะส่งค่าแบบ GET ไปหน้าเดิม -->
                    <form action="index.php" method="GET" class="flex flex-col gap-4">
                        
                        <div class="flex flex-col gap-1">
                            <label class="option_text font-medium text-gray-700">ค้นหา</label>
                            <input type="text" name="search" value="<?= htmlspecialchars($search_query) ?>" placeholder="ชื่อกิจกรรม..."
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:border-orange-400 focus:ring-1 focus:ring-orange-400 transition-colors">
                        </div>

                        <div class="flex flex-col gap-1">
                            <label class="option_text font-medium text-gray-700">วันเริ่มต้น</label>
                            <input type="date" name="start_date" value="<?= htmlspecialchars($start_date) ?>"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-600 focus:outline-none focus:border-orange-400 focus:ring-1 focus:ring-orange-400 transition-colors bg-white">
                        </div>

                        <div class="flex flex-col gap-1">
                            <label class="option_text font-medium text-gray-700">วันสิ้นสุด</label>
                            <input type="date" name="end_date" value="<?= htmlspecialchars($end_date) ?>"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-600 focus:outline-none focus:border-orange-400 focus:ring-1 focus:ring-orange-400 transition-colors bg-white">
                        </div>

                        <!-- ปุ่ม Action -->
                        <div class="flex flex-col gap-2 mt-2">
                            <button type="submit" class="w-full bg-green-400 hover:bg-green-500 text-white font-medium py-2.5 rounded-md shadow-sm transition-colors font-['Kanit']">
                                ค้นหา
                            </button>
                            
                            <!-- ปุ่มล้างตัวกรองจะโชว์ก็ต่อเมื่อมีการค้นหาอยู่เท่านั้น -->
                            <?php if(!empty($search_query) || !empty($start_date) || !empty($end_date)): ?>
                                <a href="index.php" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-600 font-medium py-2 rounded-md text-center transition-colors text-sm font-['Kanit']">
                                    ล้างการค้นหา
                                </a>
                            <?php endif; ?>
                        </div>

                    </form>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- แถบด้านขวา: แสดงกิจกรรมทั้งหมด -->
            <!-- ========================================== -->
            <div class="flex flex-col w-full lg:w-[75%] xl:w-[78%] h-fit gap-2">
                
                <div class="flex flex-col sm:flex-row sm:items-center justify-between w-full mb-4 gap-2">
                    <h2 class="option_header_text text-orange-400 text-2xl font-bold">อีเว้นท์ทั้งหมด</h2>
                    
                    <!-- โชว์ข้อความว่ากำลังค้นหาอะไรอยู่ -->
                    <?php if(!empty($search_query)): ?>
                        <span class="text-sm text-gray-500 bg-white px-3 py-1 rounded-full border border-gray-200 shadow-sm font-['Kanit']">
                            ผลการค้นหา: <span class="text-blue-600 font-semibold">"<?= htmlspecialchars($search_query) ?>"</span>
                        </span>
                    <?php endif; ?>
                </div>

                <!-- ดึงไฟล์แสดงกิจกรรม -->
                <?php require_once __DIR__ . '/../includes/showEvent.php'; ?>
                
            </div>
        </div>
    </main>

    <?php include 'footer.php' ?>
</body>

</html>