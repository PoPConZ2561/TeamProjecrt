<?php
session_start();
$page = "manage_event";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVENTLY - manage event</title>
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
        main {
            zoom: 0.8;
        }
        .title_text {
            font-family: "Kanit", sans-serif;
            font-size: 2em;
            font-weight: bolder;
            color: #172554;
            line-height: 100%;
            margin: 0;
            padding: 0;
        }

        .option_header_text {
            font-family: "Kanit", sans-serif;
            font-size: 200;
            font-weight: 300;
            color: #172554;
        }

        .option_text {
            font-family: "Kanit", sans-serif;
            font-size: small;
            color: #172554;
        }

        .head {
            font-family: "Kanit", sans-serif;
            font-size: large;
            color: #c0c2c5;
        }

        .description {
            font-family: "Kanit", sans-serif;
            font-size: small;
            font-weight: 200;
            color: black;
        }

        .r {
            background-color: red;
        }
    </style>
</head>

<body class="flex flex-col h-screen w-full">
    <?php include 'header.php' ?>
    <main class="flex flex-row items-center h-full w-full bg-gray-100 pt-[100px]">
        <div class="flex flex-col w-1/5 h-full bg-blue-950">
            <!-- แก้ไข้ให้ข้อมูลตรงกับ data -->
            <input type="text" placeholder="ค้นหากิจกรรม..." class="option_text w-[90%] pl-2 text-lg rounded-sm h-12 mx-auto my-4">
            <div class="flex flex-col items-end overflow-y-auto w-full h-[90%] py-4 gap-2">
                <div class="flex flex-col w-[80%] max-h-20 p-2 bg-gray-100 rounded-l-md hover:bg-purple-600 cursor-pointer">
                    <h1 class="option_header_text ">Title</h1>
                    <div class="flex flex-row">
                        <p class="description">12/1/68 - 14/1/68</p>
                        <p class="description ml-auto">2 คน</p>
                    </div>
                </div>
                <div class="flex flex-col w-[80%] max-h-20 p-2 bg-gray-100 rounded-l-md hover:bg-purple-600 cursor-pointer">
                    <h1 class="option_header_text ">Title</h1>
                    <div class="flex flex-row">
                        <p class="description">12/1/68 - 14/1/68</p>
                        <p class="description ml-auto">2 คน</p>
                    </div>
                </div>
                <div class="flex flex-col w-[80%] max-h-20 p-2 bg-gray-100 rounded-l-md hover:bg-purple-600 cursor-pointer">
                    <h1 class="option_header_text ">Title</h1>
                    <div class="flex flex-row">
                        <p class="description">12/1/68 - 14/1/68</p>
                        <p class="description ml-auto">2 คน</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col w-4/5 h-full px-10 py-6 gap-4 bg-gray-100 overflow-y-auto">
            <div class="flex flex-row items-center w-full h-[60px] min-h-[60px]">
                <h1 class="title_text">จัดการกิจกรรม</h1>
            </div>

            <div class="flex flex-row w-full min-h-[600px] bg-white rounded-md shadow-md p-6">
                <form action="#" method="post" enctype="multipart/form-data" class="flex flex-row w-full h-full">
                    <div class="flex flex-col gap-4 h-full w-[70%]">
                        <!-- แก้ไข้ให้ข้อมูลตรงกับ data -->
                        <div class="flex flex-col">
                            <h1 class="head text-blue-950">ชื่ออีเว้นท์</h1>
                            <input type="text" name="title" value="(ชื่ออีเว้นท์)" class="head pl-2 ml-4 text-black mt-2 w-1/2 h-10 rounded-sm border focus:outline-none focus:ring-1 focus:ring-purple-500" required>
                        </div>
                        <div class="flex flex-col">
                            <h1 class="head text-blue-950">รายละเอียด</h1>
                            <textarea name="description" maxlength="220" class="head resize-none pl-2 ml-4 text-black mt-2 w-2/3 h-32 rounded-sm border focus:outline-none focus:ring-1 focus:ring-purple-500" required>(รายละเอียด)</textarea>
                        </div>
                        <div class="flex flex-row w-2/3 justify-between">
                            <div class="flex flex-col w-[45%]">
                                <h1 class="head text-blue-950">วันเริ่มต้น</h1>
                                <input type="date" name="start" value="2026-02-21" class="ml-4 pl-2 w-full border rounded-sm head focus:outline-none" required>
                            </div>
                            <div class="flex flex-col w-[45%]">
                                <h1 class="head text-blue-950">วันสิ้นสุด</h1>
                                <input type="date" name="end" value="2026-02-24" class="ml-4 pl-2 w-full border rounded-sm head focus:outline-none" required>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <h1 class="head text-blue-950">เงื่อนไขการเข้าร่วม (ถ้ามี)</h1>
                            <textarea name="condition" maxlength="100" class="head resize-none pl-2 ml-4 text-black mt-2 w-2/3 h-32 rounded-sm border focus:outline-none focus:ring-1 focus:ring-purple-500">(เงื่อนไขการเข้าร่วม)</textarea>
                        </div>
                    </div>

                    <div class="flex flex-col items-center h-full w-[30%] gap-4">
                        <div class="flex flex-row items-center w-full">
                            <!-- แก้ไข้ให้ข้อมูลตรงกับ data -->
                            <h1 class="head text-blue-950">รูปภาพกิจกรรม</h1>
                        </div>

                        <div id="imageGrid" class="w-full grid grid-cols-2 gap-1 bg-gray-100 rounded-sm overflow-hidden border min-h-[256px]">
                            <div class="col-span-2 flex items-center justify-center text-gray-400 head text-sm p-10 text-center">
                                ยังไม่มีรูปภาพที่เลือก
                            </div>
                        </div>

                        <div class="flex flex-col items-center w-full gap-2">
                            <div class="flex flex-row gap-2">
                                <label for="fileInput" class="cursor-pointer bg-purple-600 text-white px-4 py-2 rounded-sm hover:bg-purple-700 transition shadow-sm text-center min-w-[100px]">
                                    <span class="head text-white text-sm">เลือกรูปภาพ</span>
                                </label>
                                <button type="button" onclick="clearImages()" class="bg-gray-500 text-white px-4 py-2 rounded-sm hover:bg-gray-600 transition shadow-sm text-center min-w-[100px]">
                                    <span class="head text-white text-sm">ลบรูปภาพทั้งหมด</span>
                                </button>
                            </div>
                            <input type="file" id="fileInput" name="pictures[]" class="hidden" multiple accept="image/*" onchange="previewImages(this)">
                            <div id="fileCount" class="head text-[10px] text-gray-400 mt-1">ยังไม่ได้เลือกไฟล์</div>
                        </div>

                        <div class="flex flex-row items-center w-full h-[20px] gap-2 mt-auto">
                            <button type="reset" class="w-full bg-gray-400 text-white font-bold py-3 rounded-sm hover:bg-blue-900">
                                <span class="head text-white">ยกเลิก</span>
                            </button>
                            <button type="submit" class="w-full bg-blue-950 text-white font-bold py-3 rounded-sm hover:bg-blue-900">
                                <span class="head text-white">บันทึกการแก้ไข</span>
                            </button>
                        </div>

                    </div>
                </form>
            </div>
            <div class="flex flex-col w-full min-h-[600px] bg-white shadow-md p-6 gap-2">
                <div class="flex flex-row items-center w-full h-[10%] border-b-2">
                    <h1 class="title_text">คำขอเข้าร่วม</h1>
                </div>
                <div class="flex flex-col w-full h-[20%] border-b-2 gap-2">
                    <h1 class="title_text text-[30px] font-medium">Title</h1>
                    <p class="option_header_text text-gray-400">12/1/68 - 14/1/68</p>
                </div>
                <div class="flex flex-col w-full h-[70%] gap-2 p-2 overflow-y-auto border-2 rounded-sm">
                    <!-- แก้ไข้ให้ข้อมูลตรงกับ data ไปทำให้ปุ่มมันใช้ได้ด้วย -->
                    <div class="flex flex-row w-full h-[80px] min-h-[80px] border-b-2">
                        <div class="flex flex-row items-center pl-4 w-[70%] h-full">
                            <a href="profile.php" class="shrink-0">
                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAM1BMVEXk5ueutLfn6eqrsbTp6+zg4uOwtrnJzc/j5earsbW0uby4vcDQ09XGyszU19jd3+G/xMamCvwDAAAFLklEQVR4nO2d2bLbIAxAbYE3sDH//7WFbPfexG4MiCAcnWmnrzkjIRaD2jQMwzAMwzAMwzAMwzAMwzAMwzAMwzAMwzAMwzAMw5wQkHJczewxZh2lhNK/CBOQo1n0JIT74/H/qMV0Z7GU3aCcVPuEE1XDCtVLAhgtpme7H0s1N1U7QjO0L8F7llzGeh1hEG/8Lo7TUmmuSrOfns9xnGXpXxsONPpA/B6OqqstjC6Ax/0ujkNdYQQbKNi2k64qiiEZ+ohi35X+2YcZw/WujmslYewiAliVYrxgJYrdwUmwXsU+RdApUi83oNIE27YvrfB/ZPg8+BJETXnqh9CVzBbTQHgojgiCvtqU9thFJg/CKz3VIMKMEkIXxIWqIpIg2SkjYj+xC816mrJae2aiWGykxRNsW0UwiJghJDljYI5CD8GRiCtIsJxizYUPQ2pzItZy5pcisTRdk/a9m4amtNNfBuQkdVhSaYqfpNTSFGfb9GRIakrE2Pm+GFLaCQPqiu0OpWP+HMPQQcgQMiQprWXNmsVwIjQjYi/ZrhAqNTCgr2gu0Jnz85RSSjso0HkMFZ0YZjKkc26a/jlmh9JiDyDxi9oeorTYAzZkwwoMz19pzj9bnH/GP/+qbchjSGflneWYhtTuKdMOmNKZcJ5TjInQKcYXnESd/jQxy0ENpULTNGOGgxpap/oyw9pbUAqhfx2Dbkhovvfgz4iUzoM9+GlK6/Mh4q29hyC1mwro30hpVVLPF9wYQr71RazOeM5/cw81iBRD+A03aM9/C/obbrKjbYSpCmIVG3qT/Q8oeUo3Rz0IL7vI1tEbCB9pSiu8I/aV8x3Kg/BGWrWp4ZVs0nZfmAoEG4h/61yHYIJiFSl6Q0Vk6tTW1N8kYp8hdOkfHYYMXd2Qft+8CYwqYDSKvqIh+MCF8Wgca2u/cwdgeW3TtuVn6+1oBs3yLo5C2JpK6CvQzGpfUkz9UG/87gCsi5o2LIXolxN0FbwAsjOLEr+YJmXn7iR6N0BCt5p5cMxm7eAsfS+/CACQf4CTpKjzgkvr2cVarVTf96372yut7XLJ1sa7lv6VcfgYrWaxqr3Wlo1S6pvStr22sxOtTNPLzdY3nj20bPP+ejFdJYkLsjGLdtPBEbe/mr2bQKiXWJDroA+vtzc0p9aahuwqHMDYrQEXHEw9jwQl3drMpts9JBU1SdktPe5FBRdJQ6bwXBpa57ib2A8kukQDzMjh++Uo7Fo6Wd02Pkf4fknqoo4HtvAIjsqUcjx6DIPgWCaOML9rKI/oqD9/lgNrn+eF+p7j8tnzHBiR7+kdUGw/+V1Kzkc75mMy6U+FMaxjPibiM1U1uGM+puInHpmALZCgP4pt7i840MV8+0R1zPsRB6UTcqpizncYwZ89syDydfyWCwXB1l8/zRNGWbTG/GHKUm9AkxHMc/EGSk3z2+ArEhPEV5TUBLEvUGFcjEUH80J/jveTGOAJEljJbILWGQT3zRYiwuKsUXN1EEJAzBhRJFll7mBUG7KD8EqPkKekBREaL8hMDZLQSG6AQjtHPYmvTQnX0TtpC1SYCe2YdkkyLP3jj5BSbKiuR585eQhTgoje6yIb0Yb0C+mV6EYvebqw5SDy2WmubogZiF2AVxPC2FpDf8H2Q9QWo6IkjUxTWVEI3WY/wrCeSuqJ+eRWzXR/JXwgVjUMozbCOfoEZiSiKVGepqv5CJ8RyR4D7xBeamqa7z3BJ/z17JxuBPdv93d/a2Ki878MMAzDMAzDMAzDMAzDMF/KP09VUmxBAiI3AAAAAElFTkSuQmCC"
                                class="block w-14 h-14 object-cover rounded-[50%]">
                            </a>
                            
                            <div class="flex flex-col p-2 h-full w-full">
                                <h2 class="description text-[20px] font-normal">name</h2>
                                <h2 class="description font-thin">email</h2>
                            </div>
                        </div>
                        <div class="flex flex-row justify-end items-center w-[30%] h-full gap-2">
                            <button onclick="" class="head w-1/3 bg-red-400 text-white font-bold rounded-sm shadow-md py-3 rounded-sm hover:bg-red-500">ปฏิเสธ</button>
                            <button onclick="" class="head w-1/3 bg-green-400 text-white font-bold rounded-sm shadow-md py-3 rounded-sm hover:bg-green-500">อนุญาต</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col w-full min-h-[600px] bg-white shadow-md p-6 gap-2">
                <div class="flex flex-row items-center w-full h-[10%] border-b-2">
                    <h1 class="title_text">สมาชิกทั้งหมด</h1>
                </div>
                <div class="flex flex-col w-full h-full border-2 rounded-md">
                    <div class="grid grid-cols-[90px_1fr_1fr_1fr_90px] grid-rows-1 w-full px-2 h-[10%] bg-gray-100 gap-2">
                        <h1 class="option_text text-[15px] my-auto border-r-2 ">รูปโปรไฟล์</h1>
                        <h1 class="option_text text-[15px] my-auto border-r-2 ">ชื่อ</h1>
                        <h1 class="option_text text-[15px] my-auto border-r-2 ">อีเมล</h1>
                        <h1 class="option_text text-[15px] my-auto border-r-2 ">เบอร์โทรศัพท์</h1>
                        <h1 class="option_text text-[15px] my-auto ">ลบ</h1>
                    </div>
                    <div class="flex flex-col w-full h-full overflow-y-auto">
                        <div class="grid grid-cols-[90px_1fr_1fr_1fr_90px] grid-rows-1 w-full px-2 h-[70px] min-h-[70px] border-b-2 gap-2">
                            <!-- แก้ไข้ให้ข้อมูลตรงกับ data ไปทำให้ปุ่มมันใช้ได้ด้วย -->
                            <div class="flex flex-row items-center p-2 h-full border-r-2">
                                <a href="profile.php" class="shrink-0">
                                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAM1BMVEXk5ueutLfn6eqrsbTp6+zg4uOwtrnJzc/j5earsbW0uby4vcDQ09XGyszU19jd3+G/xMamCvwDAAAFLklEQVR4nO2d2bLbIAxAbYE3sDH//7WFbPfexG4MiCAcnWmnrzkjIRaD2jQMwzAMwzAMwzAMwzAMwzAMwzAMwzAMwzAMwzAMw5wQkHJczewxZh2lhNK/CBOQo1n0JIT74/H/qMV0Z7GU3aCcVPuEE1XDCtVLAhgtpme7H0s1N1U7QjO0L8F7llzGeh1hEG/8Lo7TUmmuSrOfns9xnGXpXxsONPpA/B6OqqstjC6Ax/0ujkNdYQQbKNi2k64qiiEZ+ohi35X+2YcZw/WujmslYewiAliVYrxgJYrdwUmwXsU+RdApUi83oNIE27YvrfB/ZPg8+BJETXnqh9CVzBbTQHgojgiCvtqU9thFJg/CKz3VIMKMEkIXxIWqIpIg2SkjYj+xC816mrJae2aiWGykxRNsW0UwiJghJDljYI5CD8GRiCtIsJxizYUPQ2pzItZy5pcisTRdk/a9m4amtNNfBuQkdVhSaYqfpNTSFGfb9GRIakrE2Pm+GFLaCQPqiu0OpWP+HMPQQcgQMiQprWXNmsVwIjQjYi/ZrhAqNTCgr2gu0Jnz85RSSjso0HkMFZ0YZjKkc26a/jlmh9JiDyDxi9oeorTYAzZkwwoMz19pzj9bnH/GP/+qbchjSGflneWYhtTuKdMOmNKZcJ5TjInQKcYXnESd/jQxy0ENpULTNGOGgxpap/oyw9pbUAqhfx2Dbkhovvfgz4iUzoM9+GlK6/Mh4q29hyC1mwro30hpVVLPF9wYQr71RazOeM5/cw81iBRD+A03aM9/C/obbrKjbYSpCmIVG3qT/Q8oeUo3Rz0IL7vI1tEbCB9pSiu8I/aV8x3Kg/BGWrWp4ZVs0nZfmAoEG4h/61yHYIJiFSl6Q0Vk6tTW1N8kYp8hdOkfHYYMXd2Qft+8CYwqYDSKvqIh+MCF8Wgca2u/cwdgeW3TtuVn6+1oBs3yLo5C2JpK6CvQzGpfUkz9UG/87gCsi5o2LIXolxN0FbwAsjOLEr+YJmXn7iR6N0BCt5p5cMxm7eAsfS+/CACQf4CTpKjzgkvr2cVarVTf96372yut7XLJ1sa7lv6VcfgYrWaxqr3Wlo1S6pvStr22sxOtTNPLzdY3nj20bPP+ejFdJYkLsjGLdtPBEbe/mr2bQKiXWJDroA+vtzc0p9aahuwqHMDYrQEXHEw9jwQl3drMpts9JBU1SdktPe5FBRdJQ6bwXBpa57ib2A8kukQDzMjh++Uo7Fo6Wd02Pkf4fknqoo4HtvAIjsqUcjx6DIPgWCaOML9rKI/oqD9/lgNrn+eF+p7j8tnzHBiR7+kdUGw/+V1Kzkc75mMy6U+FMaxjPibiM1U1uGM+puInHpmALZCgP4pt7i840MV8+0R1zPsRB6UTcqpizncYwZ89syDydfyWCwXB1l8/zRNGWbTG/GHKUm9AkxHMc/EGSk3z2+ArEhPEV5TUBLEvUGFcjEUH80J/jveTGOAJEljJbILWGQT3zRYiwuKsUXN1EEJAzBhRJFll7mBUG7KD8EqPkKekBREaL8hMDZLQSG6AQjtHPYmvTQnX0TtpC1SYCe2YdkkyLP3jj5BSbKiuR585eQhTgoje6yIb0Yb0C+mV6EYvebqw5SDy2WmubogZiF2AVxPC2FpDf8H2Q9QWo6IkjUxTWVEI3WY/wrCeSuqJ+eRWzXR/JXwgVjUMozbCOfoEZiSiKVGepqv5CJ8RyR4D7xBeamqa7z3BJ/z17JxuBPdv93d/a2Ki878MMAzDMAzDMAzDMAzDMF/KP09VUmxBAiI3AAAAAElFTkSuQmCC"
                                    class="w-12 h-12 object-cover rounded-[50%] ">
                                </a>
                                
                            </div>
                            <div class="flex flex-col justify-center p-2 h-full border-r-2">
                                <h1 class="option_text text-lg">name</h1>
                            </div>
                            <div class="flex flex-col justify-center p-2 h-full border-r-2">
                                <h1 class="option_text text-lg">email</h1>
                            </div>
                            <div class="flex flex-col justify-center p-2 h-full border-r-2">
                                <h1 class="option_text text-lg">XXX-XXX-XXXX</h1>
                            </div>
                            <div class="flex flex-col justify-center p-2 h-full">
                                <button class="flex flex-row items-center justify-center w-14 h-10 rounded-md bg-red-400 text-white">
                                    ลบ
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        function clearImages() {
            const fileInput = document.getElementById('fileInput');
            const grid = document.getElementById('imageGrid');
            const fileCount = document.getElementById('fileCount');

            fileInput.value = "";
            grid.innerHTML = '<div class="col-span-2 flex items-center justify-center text-gray-400 head text-sm p-10 text-center">ยังไม่มีรูปภาพที่เลือก</div>';
            fileCount.textContent = "ยังไม่ได้เลือกไฟล์";
        }

        function previewImages(input) {
            const grid = document.getElementById('imageGrid');
            const fileCount = document.getElementById('fileCount');
            grid.innerHTML = '';

            if (input.files && input.files.length > 0) {
                const files = Array.from(input.files);
                const count = files.length;
                fileCount.textContent = `เลือกแล้ว ${count} รูป`;

                files.forEach((file, index) => {
                    if (index > 3) return; // แสดงพรีวิวสูงสุด 4 รูปแบบ

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'relative h-32 w-full bg-gray-300';

                        if (count === 1) {
                            div.className = 'col-span-2 h-64';
                        } else if (count === 2) {
                            div.className = 'col-span-1 h-64';
                        } else if (count === 3 && index === 0) {
                            div.className = 'col-span-2 h-40';
                        } else if (count >= 4 && index === 3 && count > 4) {
                            div.innerHTML = `<div class="absolute inset-0 bg-black/50 flex items-center justify-center text-white font-bold text-xl">+${count - 3}</div>`;
                        }

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'object-cover w-full h-full';
                        div.prepend(img);
                        grid.appendChild(div);
                    }
                    reader.readAsDataURL(file);
                });
            } else {
                clearImages();
            }
        }
    </script>
</body>

</html>