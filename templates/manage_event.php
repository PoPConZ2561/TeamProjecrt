<?php
session_start();
$page = "manage";

require_once __DIR__ . '/../routes/manage_event.php'; // ดึงข้อมูลและประมวลผลต่างๆ จากไฟล์นี้
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVENTLY - Manage Event</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- 🌟 เพิ่ม SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: "Kanit", sans-serif; }
        .title_text { color: #172554; }
        .head { color: #172554; font-weight: 500;}
        .description { font-weight: 300; }
        /* ซ่อน Scrollbar แต่อยู่ให้เลื่อนได้ */
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        /* ให้ SweetAlert2 ใช้ฟอนต์ Kanit */
        div.swal2-container { font-family: "Kanit", sans-serif; }
    </style>
</head>

<body class="flex flex-col h-screen w-full bg-gray-100 overflow-hidden">
    
    <?php include 'header.php' ?>
    
    <main class="flex flex-row h-full w-full pt-[80px]"> <!-- ปรับ pt ให้พอดีกับ Header -->
        
        <!-- ========================================== -->
        <!-- ส่วนซ้าย: รายชื่อกิจกรรมของคุณ -->
        <!-- ========================================== -->
        <div class="flex flex-col w-1/4 max-w-[300px] h-full bg-blue-950 shadow-lg z-10">
            <div class="p-4 border-b border-blue-900">
                <input type="text" placeholder="ค้นหากิจกรรม..." class="w-full pl-3 text-sm rounded-md h-10 focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
            
            <div class="flex flex-col overflow-y-auto hide-scrollbar h-full py-2">
                <?php if (count($my_events) == 0): ?>
                    <p class="text-gray-400 text-center text-sm mt-4">คุณยังไม่มีกิจกรรม</p>
                <?php else: ?>
                    <?php foreach ($my_events as $event): ?>
                        <?php 
                            // เช็คว่าอันไหนถูกเลือกอยู่ ให้เป็นสีม่วง
                            $is_active = ($event['event_id'] == $selected_event_id);
                            $bg_class = $is_active ? "bg-purple-600 text-white" : "text-gray-300 hover:bg-blue-900";
                            $text_class = $is_active ? "text-white" : "text-gray-100";
                            $desc_class = $is_active ? "text-purple-200" : "text-gray-400";
                        ?>
                        <a href="?event_id=<?= $event['event_id'] ?>" 
                           class="flex flex-col p-4 border-b border-blue-900/50 transition-colors cursor-pointer <?= $bg_class ?>">
                            <h1 class="font-medium truncate <?= $text_class ?>">
                                <?= htmlspecialchars($event['title']) ?>
                            </h1>
                            <div class="flex flex-row justify-between mt-1 text-xs <?= $desc_class ?>">
                                <p><?= date("d/m/Y", strtotime($event['start_date'])) ?></p>
                                <p>รับ: <?= $event['max_participants'] == 0 ? 'ไม่จำกัด' : $event['max_participants'] . ' คน' ?></p>
                            </div>
                        </a>
                    <?php endforeach ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- ส่วนขวา: รายละเอียดและการจัดการ (ฟอร์มและรายชื่อ) -->
        <!-- ========================================== -->
        <div class="flex flex-col w-full h-full p-6 lg:p-10 bg-gray-50 overflow-y-auto hide-scrollbar gap-6">
            
            <?php if ($selected_event == null): ?>
                <!-- กรณีไม่มีกิจกรรมเลย -->
                <div class="flex flex-col items-center justify-center w-full h-full bg-white rounded-lg shadow-sm border border-gray-100">
                    <svg class="w-24 h-24 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <h2 class="text-2xl font-bold text-gray-400">คุณยังไม่ได้สร้างกิจกรรม</h2>
                    <a href="create_event.php" class="mt-4 bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">สร้างกิจกรรมใหม่</a>
                </div>
            <?php else: ?>
                <!-- กรณีมีกิจกรรม ให้แสดงข้อมูล -->
                
                <h1 class="text-3xl font-bold title_text border-b-2 pb-2">จัดการกิจกรรม: <span class="text-purple-600"><?= htmlspecialchars($selected_event['title']) ?></span></h1>

                <?php if(time() > strtotime($selected_event['end_date'])): ?>
                    <div class="mb-6">
                        <a href="event_stat.php?event_id=<?= $selected_event['event_id'] ?>" 
                           class="inline-flex items-center gap-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white px-5 py-2.5 rounded-lg hover:from-purple-700 hover:to-blue-700 transition shadow-md font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            ดูสรุปสถิติกิจกรรม
                        </a>
                    </div>
                <?php endif; ?>

                <!-- กล่อง 1: แก้ไขข้อมูลกิจกรรม -->
                <div class="flex flex-col w-full bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <!-- 🌟 เปลี่ยน action เป็น routes และเพิ่ม id สำหรับ SweetAlert -->
                    <form id="updateEventForm" action="../routes/process_update_event.php" method="post" enctype="multipart/form-data" class="flex flex-col lg:flex-row w-full gap-8">
                        <input type="hidden" name="event_id" value="<?= $selected_event['event_id'] ?>">
                        
                        <!-- ฝั่งซ้ายฟอร์ม (Text) -->
                        <div class="flex flex-col gap-4 w-full lg:w-[65%]">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex flex-col">
                                    <label class="head mb-1">ชื่ออีเว้นท์</label>
                                    <input type="text" name="title" value="<?= htmlspecialchars($selected_event['title']) ?>" class="w-full h-11 px-3 rounded-md border border-gray-300 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500" required>
                                </div>
                                <div class="flex flex-col">
                                    <label class="head mb-1">จำนวนสมาชิก (0 = ไม่จำกัด)</label>
                                    <input type="number" name="max_participants" value="<?= $selected_event['max_participants'] ?>" class="w-full h-11 px-3 rounded-md border border-gray-300 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500" required>
                                </div>
                            </div>

                            <div class="flex flex-col">
                                <label class="head mb-1">สถานที่</label>
                                <input type="text" name="location" value="<?= htmlspecialchars($selected_event['location']) ?>" class="w-full h-11 px-3 rounded-md border border-gray-300 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500" required>
                            </div>
                            
                            <div class="flex flex-col">
                                <label class="head mb-1">รายละเอียด</label>
                                <textarea name="description" rows="3" class="w-full p-3 resize-none rounded-md border border-gray-300 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500" required><?= htmlspecialchars($selected_event['description']) ?></textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <?php 
                                    $fDate = date('Y-m-d', strtotime($selected_event['start_date']));
                                    $eDate = date('Y-m-d', strtotime($selected_event['end_date']));
                                ?>
                                <div class="flex flex-col">
                                    <label class="head mb-1">วันเริ่มต้น</label>
                                    <input type="date" name="start_date" value="<?= $fDate ?>" class="w-full h-11 px-3 rounded-md border border-gray-300 focus:outline-none focus:border-purple-500" required>
                                </div>
                                <div class="flex flex-col">
                                    <label class="head mb-1">วันสิ้นสุด</label>
                                    <input type="date" name="end_date" value="<?= $eDate ?>" class="w-full h-11 px-3 rounded-md border border-gray-300 focus:outline-none focus:border-purple-500" required>
                                </div>
                            </div>
                        </div>

                        <!-- ฝั่งขวาฟอร์ม (Image & Buttons) -->
                        <div class="flex flex-col items-center w-full lg:w-[35%] gap-4">
                            <label class="head self-start">รูปภาพกิจกรรม</label>
                            
                            <div id="imageGrid" class="w-full bg-gray-100 rounded-md overflow-hidden border border-gray-300 h-[220px] flex items-center justify-center relative group">
                                <?php if (!empty($selected_event['image_path'])): ?>
                                    <img src="../public/<?= htmlspecialchars($selected_event['image_path']) ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <span class="text-gray-400 text-sm">ไม่มีรูปภาพ</span>
                                <?php endif; ?>
                            </div>

                            <div class="flex flex-row gap-2 w-full mt-2">
                                <label for="fileInput" class="cursor-pointer bg-purple-600 text-white flex-1 py-2 rounded-md hover:bg-purple-700 transition text-center text-sm font-medium">
                                    เปลี่ยนรูปภาพ
                                </label>
                                <input type="file" id="fileInput" name="pictures[]" class="hidden" multiple accept="image/*" onchange="previewImages(this)">
                            </div>
                            <div id="fileCount" class="text-[11px] text-gray-500 text-center w-full">สามารถเลือกรูปใหม่เพื่อทับรูปเดิมได้</div>

                            <div class="flex flex-row w-full gap-3 mt-auto pt-4">
                                <button type="reset" class="w-1/2 bg-gray-200 text-gray-700 font-medium py-3 rounded-md hover:bg-gray-300 transition">
                                    ยกเลิก
                                </button>
                                <button type="submit" class="w-1/2 bg-blue-900 text-white font-medium py-3 rounded-md hover:bg-blue-950 transition shadow-md">
                                    บันทึกแก้ไข
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- กล่อง 2: คำขอเข้าร่วม (รอดำเนินการ) -->
                <div class="flex flex-col w-full bg-white rounded-lg shadow-sm border border-gray-100 p-6 gap-4">
                    <div class="flex flex-row items-center justify-between border-b pb-2">
                        <h1 class="text-2xl font-bold title_text">คำขอเข้าร่วม <span class="bg-yellow-100 text-yellow-700 text-sm px-3 py-1 rounded-full ml-2"><?= count($pending_users) ?> รายการ</span></h1>
                    </div>
                    
                    <div class="flex flex-col gap-3 max-h-[300px] overflow-y-auto pr-2 hide-scrollbar">
                        <?php if (count($pending_users) == 0): ?>
                            <p class="text-gray-400 text-center py-6">ไม่มีคำขอเข้าร่วมใหม่</p>
                        <?php else: ?>
                            <?php foreach ($pending_users as $user): ?>
                                <div class="flex flex-row items-center justify-between p-3 border rounded-lg bg-gray-50 hover:bg-gray-100 transition">
                                    <div class="flex flex-row items-center gap-4">
                                        <div class="w-12 h-12 bg-blue-200 text-blue-800 rounded-full flex items-center justify-center font-bold text-xl uppercase">
                                            <?= mb_substr($user['name'], 0, 1, 'UTF-8') ?>
                                        </div>
                                        <div class="flex flex-col">
                                            <h2 class="font-medium text-lg text-gray-800"><?= htmlspecialchars($user['name']) ?></h2>
                                            <p class="text-sm text-gray-500"><?= htmlspecialchars($user['email']) ?> | 📞 <?= htmlspecialchars($user['phone_number']) ?></p>
                                        </div>
                                    </div>
                                    <div class="flex flex-row gap-2">
                                        <!-- 🌟 เปลี่ยนคลาสเป็น btn-reject และ btn-approve สำหรับ SweetAlert -->
                                        <a href="../routes/process_registration.php?action=reject&user_id=<?= $user['user_id'] ?>&event_id=<?= $selected_event_id ?>" 
                                           class="btn-reject bg-red-50 text-red-600 border border-red-200 hover:bg-red-500 hover:text-white px-4 py-2 rounded-md transition font-medium text-sm">ปฏิเสธ</a>
                                        <a href="../routes/process_registration.php?action=approve&user_id=<?= $user['user_id'] ?>&event_id=<?= $selected_event_id ?>" 
                                           class="btn-approve bg-green-500 text-white hover:bg-green-600 px-4 py-2 rounded-md transition font-medium text-sm shadow-sm">อนุมัติ</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- กล่อง 3: สมาชิกที่อนุมัติแล้ว -->
                <div class="flex flex-col w-full bg-white rounded-lg shadow-sm border border-gray-100 p-6 gap-4">
                    <div class="flex flex-row items-center justify-between border-b pb-2">
                        <h1 class="text-2xl font-bold title_text">สมาชิกที่อนุมัติแล้ว <span class="bg-green-100 text-green-700 text-sm px-3 py-1 rounded-full ml-2"><?= count($approved_users) ?>/<?= $selected_event['max_participants'] == 0 ? '∞' : $selected_event['max_participants'] ?></span></h1>
                    </div>
                    
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100 text-gray-700 text-sm border-b">
                                    <th class="p-3 font-medium w-16 text-center">รูป</th>
                                    <th class="p-3 font-medium">ชื่อ-นามสกุล</th>
                                    <th class="p-3 font-medium">อีเมล</th>
                                    <th class="p-3 font-medium">เบอร์โทรศัพท์</th>
                                    <th class="p-3 font-medium text-center w-24">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($approved_users) == 0): ?>
                                    <tr>
                                        <td colspan="5" class="p-6 text-center text-gray-400">ยังไม่มีสมาชิกที่อนุมัติแล้ว</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($approved_users as $user): ?>
                                        <tr class="border-b hover:bg-gray-50 transition text-sm">
                                            <td class="p-3 text-center">
                                                <div class="w-10 h-10 mx-auto bg-purple-200 text-purple-800 rounded-full flex items-center justify-center font-bold">
                                                    <?= mb_substr($user['name'], 0, 1, 'UTF-8') ?>
                                                </div>
                                            </td>
                                            <td class="p-3 font-medium text-gray-800"><?= htmlspecialchars($user['name']) ?></td>
                                            <td class="p-3 text-gray-600"><?= htmlspecialchars($user['email']) ?></td>
                                            <td class="p-3 text-gray-600"><?= htmlspecialchars($user['phone_number']) ?></td>
                                            <td class="p-3 text-center">
                                                <?php if($user['status'] == 'attended'):?>
                                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">เข้าร่วมแล้ว</span>
                                                <?php else: ?>
                                                    <!-- 🌟 เพิ่มคลาส btn-remove สำหรับ SweetAlert ลบสมาชิก -->
                                                    <a href="../routes/process_registration.php?action=remove&user_id=<?= $user['user_id'] ?>&event_id=<?= $selected_event_id ?>" 
                                                       class="btn-remove text-red-500 hover:text-red-700 hover:bg-red-50 px-3 py-1 rounded transition">ลบ</a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            <?php endif; ?>
        </div>
    </main>

    <script>
        // พรีวิวรูปภาพ
        function previewImages(input) {
            const grid = document.getElementById('imageGrid');
            const fileCount = document.getElementById('fileCount');
            
            if (input.files && input.files.length > 0) {
                grid.innerHTML = '';
                const file = input.files[0]; 
                fileCount.textContent = `เลือกรูปภาพใหม่แล้ว`;

                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'object-cover w-full h-full';
                    grid.appendChild(img);
                }
                reader.readAsDataURL(file);
            }
        }

        // ==========================================
        // 🌟 ส่วนจัดการ SweetAlert2 สำหรับทุกปุ่ม
        // ==========================================
        document.addEventListener('DOMContentLoaded', function() {
            
            // 1. ดักจับปุ่มบันทึกฟอร์มแก้ไขข้อมูล
            const updateForm = document.getElementById('updateEventForm');
            if(updateForm) {
                updateForm.addEventListener('submit', function(e) {
                    e.preventDefault(); 
                    Swal.fire({
                        title: 'ยืนยันการแก้ไข?',
                        text: "ระบบจะบันทึกการเปลี่ยนแปลงข้อมูลกิจกรรมของคุณ",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#2563eb', // สีฟ้า
                        cancelButtonColor: '#d1d5db',  // สีเทา
                        confirmButtonText: 'ใช่, บันทึกเลย!',
                        cancelButtonText: 'ยกเลิก',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.showLoading();
                            updateForm.submit();
                        }
                    });
                });
            }

            // 2. ดักจับปุ่ม "อนุมัติ" สมาชิก
            document.querySelectorAll('.btn-approve').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const href = this.getAttribute('href');
                    Swal.fire({
                        title: 'ยืนยันการอนุมัติ?',
                        text: "ผู้ใช้นี้จะสามารถเข้าร่วมกิจกรรมได้",
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonColor: '#10b981', // สีเขียว
                        cancelButtonColor: '#d1d5db',
                        confirmButtonText: 'ใช่, อนุมัติเลย',
                        cancelButtonText: 'ยกเลิก',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.showLoading();
                            window.location.href = href;
                        }
                    });
                });
            });

            // 3. ดักจับปุ่ม "ปฏิเสธ" คำขอ
            document.querySelectorAll('.btn-reject').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const href = this.getAttribute('href');
                    Swal.fire({
                        title: 'ปฏิเสธคำขอ?',
                        text: "ผู้ใช้นี้จะไม่สามารถเข้าร่วมกิจกรรมได้",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444', // สีแดง
                        cancelButtonColor: '#d1d5db',
                        confirmButtonText: 'ใช่, ปฏิเสธ',
                        cancelButtonText: 'ยกเลิก',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.showLoading();
                            window.location.href = href;
                        }
                    });
                });
            });

            // 4. ดักจับปุ่ม "ลบ" สมาชิกที่อนุมัติแล้ว
            document.querySelectorAll('.btn-remove').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const href = this.getAttribute('href');
                    Swal.fire({
                        title: 'เตือนภัย!',
                        text: "แน่ใจหรือไม่ว่าต้องการลบผู้ใช้นี้ออกจากกิจกรรม? (ไม่สามารถย้อนกลับได้)",
                        icon: 'error',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444', 
                        cancelButtonColor: '#d1d5db',
                        confirmButtonText: 'ใช่, ลบออกเลย!',
                        cancelButtonText: 'ยกเลิก',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.showLoading();
                            window.location.href = href;
                        }
                    });
                });
            });

            // 5. เช็คสถานะหลังจากโหลดหน้า (รับค่าจาก Backend)
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');

            if (status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ!',
                    text: 'ทำรายการเรียบร้อยแล้ว',
                    confirmButtonColor: '#10b981',
                    timer: 2000,
                    showConfirmButton: false
                });
                
                // ล้าง status ออกจาก URL เพื่อไม่ให้ Alert เด้งซ้ำตอนกด Refresh
                urlParams.delete('status');
                const newUrl = window.location.pathname + (urlParams.toString() ? '?' + urlParams.toString() : '');
                window.history.replaceState(null, null, newUrl);
                
            } else if (status === 'error') {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด!',
                    text: 'ไม่สามารถทำรายการได้ กรุณาลองใหม่อีกครั้ง',
                    confirmButtonColor: '#ef4444'
                });
                urlParams.delete('status');
                const newUrl = window.location.pathname + (urlParams.toString() ? '?' + urlParams.toString() : '');
                window.history.replaceState(null, null, newUrl);
            }
        });
    </script>
</body>
</html>