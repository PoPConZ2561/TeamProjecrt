<?php
session_start();
$page = "index";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVENTLY - main</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Kanit", sans-serif;
        }

        .option_header_text {
            font-family: "Kanit", sans-serif;
        }

        .option_text {
            font-family: "Kanit", sans-serif;
        }
    </style>
</head>

<body class="flex flex-col min-h-screen w-full bg-gray-50">

    <?php include 'header.php' ?>

    <main class="flex flex-grow flex-col items-center w-full bg-gray-50 pt-[100px] pb-12">
        <div class="flex flex-col lg:flex-row w-[90%] lg:w-[85%] max-w-[1400px] h-full gap-8">

            <!-- Sidebar ตัวคัดกรอง -->
            <div class="w-full lg:w-[25%] xl:w-[22%] shrink-0">
                <div class="sticky top-[100px] flex flex-col bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex flex-row items-center w-full mb-4">
                        <h2 class="option_header_text text-orange-400 text-2xl font-bold">ตัวคัดกรอง</h2>
                    </div>

                    <form id="search-form" action="" method="GET" class="flex flex-col gap-4">

                        <!-- 1. ค้นหาชื่อ -->
                        <div class="flex flex-col gap-1">
                            <label class="option_text font-medium text-gray-700">ค้นหา</label>
                            <input type="text" id="search-input" name="search" placeholder="ชื่อกิจกรรม, สถานที่..."
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:border-orange-400 focus:ring-1 focus:ring-orange-400 transition-colors">
                        </div>

                        <!-- 2. การเรียงลำดับ (เพิ่มเข้ามาใหม่ ⭐) -->
                        <div class="flex flex-col gap-1">
                            <label class="option_text font-medium text-gray-700">การเรียงลำดับ</label>
                            <select id="sort-by" name="sort_by" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-600 focus:outline-none focus:border-orange-400 focus:ring-1 focus:ring-orange-400 transition-colors bg-white cursor-pointer">
                                <option value="latest">กิจกรรมใหม่ล่าสุด (เริ่มต้น)</option>
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <option value="registered_first">กิจกรรมที่ฉันลงทะเบียน (บนสุด)</option>
                                <?php endif; ?>
                                <option value="upcoming_first">วันที่จัดงาน (ใกล้ถึงที่สุด)</option>

                                <!-- 🌟 เพิ่ม 3 ตัวเลือกใหม่ตรงนี้ -->
                                <option value="popular">🔥 กิจกรรมยอดฮิต (คนสมัครเยอะสุด)</option>
                                <option value="seats_available">🪑 ที่นั่งเหลือเยอะสุด</option>
                                <option value="title_asc">🔤 ชื่อกิจกรรม (ก-ฮ / A-Z)</option>
                            </select>
                        </div>

                        <!-- 3. วันเริ่มต้น -->
                        <div class="flex flex-col gap-1">
                            <label class="option_text font-medium text-gray-700">วันเริ่มต้น</label>
                            <input type="date" id="start-date" name="start_date"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-600 focus:outline-none focus:border-orange-400 focus:ring-1 focus:ring-orange-400 transition-colors bg-white">
                        </div>

                        <!-- 4. วันสิ้นสุด -->
                        <div class="flex flex-col gap-1">
                            <label class="option_text font-medium text-gray-700">วันสิ้นสุด</label>
                            <input type="date" id="end-date" name="end_date"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-600 focus:outline-none focus:border-orange-400 focus:ring-1 focus:ring-orange-400 transition-colors bg-white">
                        </div>

                        <!-- ปุ่ม Action -->
                        <div class="flex flex-col gap-2 mt-2">
                            <button type="button" id="clear-btn" class="hidden w-full bg-gray-100 hover:bg-gray-200 text-gray-600 font-medium py-2 rounded-md text-center transition-colors text-sm font-['Kanit']">
                                ล้างการค้นหาทั้งหมด
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ส่วนแสดงผลเนื้อหา -->
            <div class="flex flex-col w-full lg:w-[75%] xl:w-[78%] h-fit gap-2">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between w-full mb-4 gap-2">
                    <h2 class="option_header_text text-orange-400 text-2xl font-bold">อีเว้นท์ทั้งหมด</h2>

                    <span id="search-status" class="hidden text-sm text-gray-500 bg-white px-3 py-1 rounded-full border border-gray-200 shadow-sm font-['Kanit']">
                        ผลการค้นหา: <span id="search-term" class="text-blue-600 font-semibold">""</span>
                    </span>
                </div>

                <div id="events-container">
                    <!-- โหลดข้อมูลครั้งแรกด้วย PHP ปกติ -->
                    <?php require_once __DIR__ . '/../includes/showEvent.php'; ?>
                </div>
            </div>
        </div>
    </main>

    <?php include 'footer.php' ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-input');
            const sortByInput = document.getElementById('sort-by'); // ตัวแปรใหม่
            const startDateInput = document.getElementById('start-date');
            const endDateInput = document.getElementById('end-date');
            const eventsContainer = document.getElementById('events-container');
            const searchStatus = document.getElementById('search-status');
            const searchTermText = document.getElementById('search-term');
            const clearBtn = document.getElementById('clear-btn');
            const searchForm = document.getElementById('search-form');

            // ฟังก์ชันดึงข้อมูลกิจกรรมผ่าน AJAX
            function fetchEvents() {
                const search = searchInput.value;
                const sortBy = sortByInput.value; // ดึงค่าการเรียงลำดับ
                const startDate = startDateInput.value;
                const endDate = endDateInput.value;

                // จัดการแสดง/ซ่อน ปุ่มล้างค่า
                if (search || startDate || endDate || sortBy !== 'latest') {
                    clearBtn.classList.remove('hidden');
                } else {
                    clearBtn.classList.add('hidden');
                }

                // จัดการสถานะคำค้นหา
                if (search) {
                    searchStatus.classList.remove('hidden');
                    searchTermText.textContent = `"${search}"`;
                } else {
                    searchStatus.classList.add('hidden');
                }

                // เพิ่ม sort_by เข้าไปใน URL Parameter
                const url = `../includes/showEvent.php?search=${encodeURIComponent(search)}&start_date=${encodeURIComponent(startDate)}&end_date=${encodeURIComponent(endDate)}&sort_by=${encodeURIComponent(sortBy)}`;

                fetch(url)
                    .then(response => response.text())
                    .then(html => {
                        eventsContainer.innerHTML = html;
                    })
                    .catch(error => console.error('Error fetching events:', error));
            }

            // ดักจับ Event (Real-time)
            searchInput.addEventListener('input', fetchEvents);
            sortByInput.addEventListener('change', fetchEvents); // ดักจับตอนเปลี่ยน Dropdown
            startDateInput.addEventListener('change', fetchEvents);
            endDateInput.addEventListener('change', fetchEvents);

            // ป้องกันฟอร์ม Reload
            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                fetchEvents();
            });

            // ปุ่มล้างตัวกรอง
            clearBtn.addEventListener('click', function() {
                searchInput.value = '';
                sortByInput.value = 'latest'; // คืนค่ากลับไปเริ่มต้น
                startDateInput.value = '';
                endDateInput.value = '';
                fetchEvents();
            });
        });
    </script>
</body>

</html>