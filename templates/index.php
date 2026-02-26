<?php
session_start();
$page = "index";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    </head>
<body class="flex flex-col min-h-screen w-full bg-gray-50">
    
    <?php include 'header.php' ?>
    
    <main class="flex flex-grow flex-col items-center w-full bg-gray-50 pt-[100px] pb-12">
        <div class="flex flex-col lg:flex-row w-[90%] lg:w-[85%] max-w-[1400px] h-full gap-8">
            
            <div class="w-full lg:w-[25%] xl:w-[22%] shrink-0">
                <div class="sticky top-[100px] flex flex-col bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex flex-row items-center w-full mb-4">
                        <h2 class="option_header_text text-orange-400 text-2xl font-bold">ตัวคัดกรอง</h2>
                    </div>

                    <form id="search-form" action="" method="GET" class="flex flex-col gap-4">
                        <div class="flex flex-col gap-1">
                            <label class="option_text font-medium text-gray-700">ค้นหา</label>
                            <input type="text" id="search-input" name="search" placeholder="ชื่อกิจกรรม..."
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:border-orange-400 focus:ring-1 focus:ring-orange-400 transition-colors">
                        </div>

                        <div class="flex flex-col gap-1">
                            <label class="option_text font-medium text-gray-700">วันเริ่มต้น</label>
                            <input type="date" id="start-date" name="start_date"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-600 focus:outline-none focus:border-orange-400 focus:ring-1 focus:ring-orange-400 transition-colors bg-white">
                        </div>

                        <div class="flex flex-col gap-1">
                            <label class="option_text font-medium text-gray-700">วันสิ้นสุด</label>
                            <input type="date" id="end-date" name="end_date"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-600 focus:outline-none focus:border-orange-400 focus:ring-1 focus:ring-orange-400 transition-colors bg-white">
                        </div>
                        
                        <div class="flex flex-col gap-2 mt-2">
                            <button type="button" id="clear-btn" class="hidden w-full bg-gray-100 hover:bg-gray-200 text-gray-600 font-medium py-2 rounded-md text-center transition-colors text-sm font-['Kanit']">
                                ล้างการค้นหา
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="flex flex-col w-full lg:w-[75%] xl:w-[78%] h-fit gap-2">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between w-full mb-4 gap-2">
                    <h2 class="option_header_text text-orange-400 text-2xl font-bold">อีเว้นท์ทั้งหมด</h2>
                    
                    <span id="search-status" class="hidden text-sm text-gray-500 bg-white px-3 py-1 rounded-full border border-gray-200 shadow-sm font-['Kanit']">
                        ผลการค้นหา: <span id="search-term" class="text-blue-600 font-semibold">""</span>
                    </span>
                </div>

                <div id="events-container">
                    <?php require_once __DIR__ . '/../includes/showEvent.php'; ?>
                </div>
                
            </div>
        </div>
    </main>

    <?php include 'footer.php' ?>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');
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
            const startDate = startDateInput.value;
            const endDate = endDateInput.value;

            // จัดการแสดง/ซ่อน ปุ่มล้างค่า และ สถานะการค้นหา
            if (search || startDate || endDate) {
                clearBtn.classList.remove('hidden');
            } else {
                clearBtn.classList.add('hidden');
            }

            if (search) {
                searchStatus.classList.remove('hidden');
                searchTermText.textContent = `"${search}"`;
            } else {
                searchStatus.classList.add('hidden');
            }

            // เรียกไฟล์ showEvent.php พร้อมส่ง Parameter
            const url = `../includes/showEvent.php?search=${encodeURIComponent(search)}&start_date=${encodeURIComponent(startDate)}&end_date=${encodeURIComponent(endDate)}`;

            fetch(url)
                .then(response => response.text())
                .then(html => {
                    eventsContainer.innerHTML = html; // นำ HTML ที่ได้มาอัปเดตใส่หน้าเว็บทันที
                })
                .catch(error => console.error('Error fetching events:', error));
        }

        // ดักจับ Event เมื่อมีการพิมพ์หรือเปลี่ยนค่า (Real-time)
        searchInput.addEventListener('input', fetchEvents);
        startDateInput.addEventListener('change', fetchEvents);
        endDateInput.addEventListener('change', fetchEvents);

        // ป้องกันฟอร์ม Reload หน้าเว็บถ้าผู้ใช้เผลอกด Enter
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            fetchEvents();
        });

        // ปุ่มล้างตัวกรอง
        clearBtn.addEventListener('click', function() {
            searchInput.value = '';
            startDateInput.value = '';
            endDateInput.value = '';
            fetchEvents();
        });
    });
    </script>
</body>
</html>