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

        .title_event_text {
            font-family: "Kanit", sans-serif;
            font-size: xx-large;
            font-weight: 500;
            color: black;
        }

        .description {
            font-family: "Kanit", sans-serif;
            font-size: small;
            font-weight: 200;
            color: black;
        }
    </style>
</head>

<body class="flex flex-col min-h-screen w-full justify-between">
    <?php include 'header.php' ?>
    <main class="flex flex-grow flex-col items-center w-full bg-gray-100 pt-[80px]">
        <div class="flex flex-row w-[80%] h-full pt-10">
            <div class=" w-[25%] h-[250px]">
                <div class="flex flex-col items-center justify-center bg-white w-[20%] h-[300px] px-2 rounded-md shadow-sm fixed">
                    <div class="flex flex-row items-center w-full pl-2 h-[30px]">
                        <h2 class="option_header_text text-orange-400 text-2xl font-bold">ตัวคัดกรอง</h2>
                    </div>
                    <!-- ทำให้กด enter แล้วกรองให้ทันทีด้วย -->
                    <form action="#" method="post" class="flex flex-col mt-5 gap-2">
                        <div class="flex flex-col">
                            <p class="option_text">ค้นหา</p>
                            <input type="text"
                                class="w-full rounded-sm border pl-1">
                        </div>
                        <p class="option_text">วันเริ่มต้น</p>
                        <input type="date"
                            class="text-sm text-gray-400 w-full pl-1 bg-white rounded-sm border">
                        <p class="option_text">วันสิ้นสุด</p>
                        <input type="date"
                            class="text-sm text-gray-400 w-full pl-1 bg-white rounded-sm border">
                        <input type="submit" value="ค้นหา" class="mt-2 text-white h-10 bg-green-400 rounded-md shadow-sm">
                    </form>
                </div>
            </div>

            <div class="ml-10 flex flex-col w-[75%] h-fit px-2 gap-2 ">
                <div class="flex flex-row items-center w-full h-[30px] min-h-[30px] mb-3">
                    <h2 class="option_header_text text-orange-400 text-2xl font-bold">อีเว้นท์ทั้งหมด</h2>
                </div>
                <!-- ไปแก้ไข ให้ข้อมูลตามผู้จัด ใน database -->
                <?php require_once __DIR__ . '/../includes/showEvent.php'; ?>
            </div>
        </div>
    </main>
    <?php include 'footer.php' ?>
</body>

</html>