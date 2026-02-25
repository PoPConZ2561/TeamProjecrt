<?php
session_start();
$page = "create";

// ตรวจสอบการล็อกอิน (ถ้ายังไม่ล็อกอินให้กลับไปหน้า login)
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
    <title>EVENTLY - Create Event</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: "Kanit", sans-serif; background-color: #f8fafc; }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>

<body class="flex flex-col min-h-screen w-full">
    
    <?php include 'header.php' ?>

    <main class="flex flex-grow flex-col items-center w-full pt-[100px] pb-12 px-4">
        
        <div class="w-full max-w-5xl bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            
            <!-- ส่วนหัวของกล่อง -->
            <div class="bg-gradient-to-r from-blue-900 to-blue-800 px-8 py-6">
                <h1 class="text-2xl font-bold text-white flex items-center gap-3">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    สร้างกิจกรรมใหม่
                </h1>
                <p class="text-blue-100 mt-1 text-sm text-gray-200">กรอกข้อมูลรายละเอียดเพื่อสร้างกิจกรรมของคุณให้โลกเห็น</p>
            </div>

            <!-- ฟอร์มกรอกข้อมูล -->
            <form action="../includes/create_event.php" method="POST" enctype="multipart/form-data" class="flex flex-col w-full">
                
                <div class="flex flex-col lg:flex-row w-full p-8 gap-10">

                    <!-- ========================================== -->
                    <!-- ฝั่งซ้าย: ข้อมูลกิจกรรม -->
                    <!-- ========================================== -->
                    <div class="flex flex-col w-full lg:w-3/5 gap-6">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex flex-col gap-1.5">
                                <label class="text-sm font-medium text-gray-700">ชื่ออีเว้นท์ <span class="text-red-500">*</span></label>
                                <input type="text" name="title" placeholder="เช่น นิทรรศการศิลปะ..." 
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-sm font-medium text-gray-700">จำนวนสมาชิก (0 = ไม่จำกัด) <span class="text-red-500">*</span></label>
                                <input type="number" name="max_participants" inputmode="numeric" placeholder="ตัวเลขเท่านั้น" min="0" value="0"
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex flex-col gap-1.5">
                                <label class="text-sm font-medium text-gray-700">วันเริ่มต้น <span class="text-red-500">*</span></label>
                                <input type="date" name="start_date" 
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-sm font-medium text-gray-700">วันสิ้นสุด <span class="text-red-500">*</span></label>
                                <input type="date" name="end_date" 
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
                            </div>
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label class="text-sm font-medium text-gray-700">สถานที่จัดงาน <span class="text-red-500">*</span></label>
                            <input type="text" name="location" placeholder="ระบุสถานที่ หรือ ลิงก์ออนไลน์"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label class="text-sm font-medium text-gray-700">รายละเอียดกิจกรรม <span class="text-red-500">*</span></label>
                            <textarea name="description" rows="4" maxlength="500" placeholder="อธิบายเกี่ยวกับกิจกรรมของคุณ..."
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none" required></textarea>
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label class="text-sm font-medium text-gray-700">เงื่อนไขการเข้าร่วม (ถ้ามี)</label>
                            <textarea name="condition" rows="2" maxlength="200" placeholder="เช่น แต่งกายสุภาพ, อายุ 18 ปีขึ้นไป..."
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"></textarea>
                        </div>
                    </div>

                    <!-- ========================================== -->
                    <!-- ฝั่งขวา: อัปโหลดรูปภาพ (Drag & Drop) -->
                    <!-- ========================================== -->
                    <div class="flex flex-col w-full lg:w-2/5 gap-4">
                        <label class="text-sm font-medium text-gray-700">รูปภาพกิจกรรม</label>
                        
                        <!-- พื้นที่ลากวางไฟล์ (ใช้ div แก้ปัญหาคลิกเบิ้ล) -->
                        <div id="dropZone" class="flex flex-col items-center justify-center w-full h-48 bg-gray-50 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:bg-blue-50 hover:border-blue-400 transition-colors group relative">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6 pointer-events-none">
                                <svg class="w-10 h-10 text-gray-400 group-hover:text-blue-500 mb-3 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold text-blue-600">คลิกเพื่ออัปโหลด</span> หรือลากไฟล์มาวาง</p>
                                <p class="text-xs text-gray-400">PNG, JPG, JPEG (รองรับหลายไฟล์)</p>
                            </div>
                            <!-- Input ซ่อนไว้ -->
                            <input id="fileInput" name="img[]" type="file" class="hidden" multiple accept="image/png, image/jpeg, image/jpg">
                        </div>

                        <!-- พื้นที่แสดงรูปตัวอย่าง (Preview) -->
                        <div id="previewContainer" class="grid grid-cols-3 gap-3 mt-2 empty:hidden">
                            <!-- รูปภาพจะถูกแทรกที่นี่ด้วย JS -->
                        </div>

                    </div>
                </div>

                <!-- ========================================== -->
                <!-- แถบด้านล่างสุด: ปุ่มตกลง/ยกเลิก -->
                <!-- ========================================== -->
                <div class="flex items-center justify-end gap-3 px-8 py-5 bg-gray-50 border-t border-gray-100">
                    <button type="reset" id="resetBtn" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors">
                        ล้างข้อมูล
                    </button>
                    <button type="submit" class="px-8 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors shadow-sm flex items-center gap-2">
                        สร้างกิจกรรม
                    </button>
                </div>

            </form>
        </div>
    </main>

    <?php include 'footer.php' ?>

    <!-- ========================================== -->
    <!-- Script สำหรับอัปโหลดและแสดงตัวอย่างภาพ -->
    <!-- ========================================== -->
    <script>
        const dropZone = document.getElementById("dropZone");
        const fileInput = document.getElementById("fileInput");
        const previewContainer = document.getElementById("previewContainer");
        const resetBtn = document.getElementById("resetBtn");

        let selectedFiles = []; // เก็บไฟล์ที่ผู้ใช้เลือก

        // 1. จัดการการคลิกที่กล่อง (แก้ปัญหาเด้ง 2 รอบ)
        dropZone.addEventListener("click", () => {
            fileInput.click();
        });

        // 2. จัดการ Drag & Drop
        dropZone.addEventListener("dragover", (e) => {
            e.preventDefault();
            dropZone.classList.add("border-blue-500", "bg-blue-50");
        });

        dropZone.addEventListener("dragleave", () => {
            dropZone.classList.remove("border-blue-500", "bg-blue-50");
        });

        dropZone.addEventListener("drop", (e) => {
            e.preventDefault();
            dropZone.classList.remove("border-blue-500", "bg-blue-50");
            handleFiles(e.dataTransfer.files);
        });

        // 3. จัดการเมื่อกดเลือกไฟล์ผ่านปุ่ม
        fileInput.addEventListener("change", (e) => {
            handleFiles(e.target.files);
        });

        // 4. ฟังก์ชันจัดการไฟล์
        function handleFiles(files) {
            // เพิ่มไฟล์ใหม่เข้าไปใน Array
            selectedFiles = [...selectedFiles, ...Array.from(files)];
            updateFileInput(); // อัปเดตไฟล์ลง Input ให้ PHP มองเห็น
            renderPreviews();  // วาดรูปตัวอย่างหน้าจอ
        }

        // 5. อัปเดตไฟล์ลง Input จริงๆ
        function updateFileInput() {
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => dataTransfer.items.add(file));
            fileInput.files = dataTransfer.files; 
        }

        // 6. วาดรูปตัวอย่าง (Preview)
        function renderPreviews() {
            previewContainer.innerHTML = ""; // ล้างของเก่า
            
            selectedFiles.forEach((file, index) => {
                // อ่านไฟล์รูป
                const reader = new FileReader();
                reader.onload = function(e) {
                    // สร้างกล่องรูป
                    const div = document.createElement("div");
                    div.className = "relative aspect-square rounded-lg overflow-hidden border border-gray-200 shadow-sm group";
                    
                    // สร้างรูปภาพ
                    const img = document.createElement("img");
                    img.src = e.target.result;
                    img.className = "w-full h-full object-cover";
                    
                    // สร้างปุ่มลบ (X)
                    const deleteBtn = document.createElement("button");
                    deleteBtn.type = "button";
                    deleteBtn.className = "absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-600 focus:outline-none";
                    deleteBtn.innerHTML = `<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>`;
                    
                    // กดปุ่ม X แล้วลบรูปนี้
                    deleteBtn.onclick = () => {
                        selectedFiles.splice(index, 1); // ลบออกจาก Array
                        updateFileInput(); // อัปเดต Input ใหม่
                        renderPreviews();  // วาด UI ใหม่
                    };

                    div.appendChild(img);
                    div.appendChild(deleteBtn);
                    previewContainer.appendChild(div);
                }
                reader.readAsDataURL(file);
            });
        }

        // 7. เมื่อกดปุ่ม "ล้างข้อมูล" (Reset)
        resetBtn.addEventListener("click", () => {
            selectedFiles = [];
            previewContainer.innerHTML = "";
            // Input file จะถูกเคลียร์อัตโนมัติโดยฟังก์ชัน Reset ของ Form
        });
    </script>
</body>
</html>