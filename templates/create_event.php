<?php
session_start();
$page = "create";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVENTLY - create event</title>
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

        body {
            font-family: "Kanit", sans-serif;
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
            font-weight: 300;
            color: #172554;
        }

        .head {
            font-family: "Kanit", sans-serif;
            color: #c0c2c5;
        }
    </style>
</head>

<body class="flex flex-col min-h-screen w-full justify-between bg-gray-100">
    <?php include 'header.php' ?>

    <main class="flex flex-col items-center w-full pt-[80px] pb-10">
        <div class="flex flex-col w-[90%] max-w-5xl bg-white rounded-md shadow-md mt-10 overflow-hidden">
            <form action="/../includes/create_event.php" method="POST" enctype="multipart/form-data" class="flex flex-col w-full">
                <div class="flex flex-col md:flex-row w-full">

                    <div class="flex flex-col w-full md:w-2/3 p-10 gap-6">
                        <div class="flex flex-col">
                            <h1 class="head text-blue-950">ชื่ออีเว้นท์</h1>
                            <input type="text" name="title" placeholder="กรอกชื่ออีเว้นท์"
                                class="pl-2 text-black head input-style w-full md:w-2/3 h-10 border" required>
                        </div>
                        <div class="flex flex-col">
                            <h1 class="head text-blue-950">จำนวนสมาชิก</h1>
                            <input type="number" name="max_participants" inputmode="numeric" placeholder="กรอกจำนวนสมาชิก"
                                class="pl-2 text-black head input-style w-full md:w-2/3 h-10 border" required>
                        </div>

                        <div class="flex flex-col">
                            <h1 class="head text-blue-950">สถานที่</h1>
                            <textarea name="location" maxlength="220" placeholder="กรอกสถานที่"
                                class="pl-2 text-black head input-style w-full md:w-3/4 h-20 resize-none border" required></textarea>
                        </div>

                        <div class="flex flex-col">
                            <h1 class="head text-blue-950">รายละเอียด</h1>
                            <textarea name="description" maxlength="220" placeholder="กรอกรายละเอียด"
                                class="pl-2 text-black head input-style w-full md:w-3/4 h-20 resize-none border" required></textarea>
                        </div>

                        <div class="flex flex-row w-full md:w-3/4 justify-between gap-4">
                            <div class="flex flex-col w-1/2">
                                <h1 class="head text-blue-950">วันเริ่มต้น</h1>
                                <input type="date" name="start_date"
                                    class="head input-style ml-0 w-full border"
                                    onchange="this.classList.add('text-black')" required>
                            </div>
                            <div class="flex flex-col w-1/2">
                                <h1 class="head text-blue-950">วันสิ้นสุด</h1>
                                <input type="date" name="end_date"
                                    class="head input-style ml-0 w-full border"
                                    onchange="this.classList.add('text-black')" required>
                            </div>
                        </div>

                        <div class="flex flex-col">
                            <h1 class="head text-blue-950">เงื่อนไขการเข้าร่วม (ถ้ามี)</h1>
                            <textarea name="condition" maxlength="100" placeholder="กรอกเงื่อนไข"
                                class="pl-2 head text-black input-style w-full md:w-3/4 h-16 resize-none border"></textarea>
                        </div>
                    </div>

                    <div class="w-full md:w-1/3 bg-gradient-to-b from-purple-300 via-gray-100 to-purple-100 p-8 flex items-center justify-center">
                        <label id="dropZone" class="flex flex-col items-center justify-center w-full h-64 bg-white border-4 border-dashed rounded-md cursor-pointer hover:bg-gray-50 transition overflow-hidden p-4">
                            <div class="flex flex-col items-center justify-center text-center">
                                <p class="text-gray-500 mt-2">
                                    ลากไฟล์มาวาง <br>
                                    หรือคลิกเพื่ออัปโหลด
                                </p>
                                <ul id="fileList" class="text-xs text-gray-700 mt-3 list-none"></ul>
                            </div>
                            <input id="fileInput" name="img" type="file" class="hidden" multiple>
                        </label>
                    </div>

                </div>

                <div class="flex justify-end gap-2 p-6 bg-gray-50 border-t">
                    <button type="reset" id="resetBtn" class="bg-gray-500 text-white font-bold py-2 px-6 rounded hover:bg-gray-400 transition">
                        ล้าง
                    </button>
                    <button type="submit" class="bg-purple-600 text-white font-bold py-2 px-6 rounded hover:bg-purple-700 transition shadow-sm">
                        สร้างอีเว้นท์
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        const dropZone = document.getElementById("dropZone");
        const fileInput = document.getElementById("fileInput");
        const fileList = document.getElementById("fileList");
        const resetBtn = document.getElementById("resetBtn");

        let selectedFiles = [];

        function showFiles() {
            fileList.innerHTML = "";
            selectedFiles.forEach((file, index) => {
                if (index < 3) {
                    const li = document.createElement("li");
                    li.textContent = "📄 " + (file.name.length > 15 ? file.name.substring(0, 15) + "..." : file.name);
                    fileList.appendChild(li);
                }
            });
            if (selectedFiles.length > 3) {
                const more = document.createElement("li");
                more.textContent = `+ อีก ${selectedFiles.length - 3} ไฟล์`;
                fileList.appendChild(more);
            }
        }

        dropZone.addEventListener("click", (e) => {
            if (e.target !== fileInput) fileInput.click();
        });

        dropZone.addEventListener("dragover", (e) => {
            e.preventDefault();
            dropZone.classList.add("bg-purple-100");
        });

        dropZone.addEventListener("dragleave", () => {
            dropZone.classList.remove("bg-purple-100");
        });

        dropZone.addEventListener("drop", (e) => {
            e.preventDefault();
            dropZone.classList.remove("bg-purple-100");
            const files = e.dataTransfer.files;
            handleFiles(files);
        });

        fileInput.addEventListener("change", () => {
            handleFiles(fileInput.files);
        });

        function handleFiles(files) {
            selectedFiles = [...selectedFiles, ...Array.from(files)];
            showFiles();
        }

        resetBtn.addEventListener("click", () => {
            selectedFiles = [];
            fileList.innerHTML = "";
        });
    </script>
</body>

</html>