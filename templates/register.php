<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVENTLY - register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans+Flex:opsz,wght@8..144,100..1000&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <style>
        .title_text {
            font-family: "Google Sans Flex", sans-serif;
            font-size: large;
            font-weight: bolder;
            color: white;
        }

        .register_text {
            font-family: "Kanit", sans-serif;
            font-size: xx-large;
            font-weight: bolder;
            color: #172554;
        }

        .login_text {
            font-family: "Kanit", sans-serif;
            font-size: medium;
            font-weight: 300;
            color: #172554;
        }
    </style>
</head>

<body class="flex flex-row h-screen w-screen">
    <!-- panel ซ้าย -->
    <div class="flex flex-col w-2/6 h-full bg-blue-950">
        <div class="flex flex-row w-full h-[10%] items-center pl-3">
            <a href="index.php"><h1 class="title_text">EVENTLY</h1></a>
            </div>
        <img src="undraw_partying_3qad.svg" class="w-[80%] object-cover my-auto mx-auto">
    </div>
    <!-- panel ขวา -->
    <main class="flex flex-col w-4/6 h-full bg-white px-10 items-center">

        <div class="w-full max-w-2xl">

            <div class="flex flex-row w-full h-32 items-center">
                <h1 class="register_text">ลงทะเบียน</h1>
            </div>

            <form class="grid grid-cols-2 gap-x-8 gap-y-4" action="/../includes/register.php" method="post" name="register">
                <div class="flex flex-col gap-2">
                    <p class="login_text">ชื่อผู้ใช้<span class="text-red-500"> *</span></p>
                    <input type="text" placeholder="ไรอัน" name="name" class="bg-gray-100 border rounded-sm pl-2 text-sm w-full h-[37px]" required>
                </div>
                <div class="flex flex-col gap-2">
                    <p class="login_text">อีเมล<span class="text-red-500"> *</span></p>
                    <input type="email" placeholder="XXX@msu.ac.th" name="email" class="bg-gray-100 border rounded-sm pl-2 text-sm w-full h-[37px]" required>
                </div>
                <div class="flex flex-col gap-2">
                    <p class="login_text">เบอร์โทรติดต่อ<span class="text-red-500"> *</span></p>
                    <input type="text" placeholder="+66 999 999 999" inputmode="numeric" name="phone_number" class="bg-gray-100 border rounded-sm pl-2 text-sm w-full h-[37px]" required>
                </div>
                <div class="flex flex-col gap-2">
                    <p class="login_text">วันเกิด<span class="text-red-500"> *</span></p>
                    <input type="date" name="birthdate" class="bg-gray-100 border rounded-sm pl-2 text-gray-400 text-sm w-full h-[37px]" required>
                </div>
                <div class="flex flex-col gap-2">
                    <p class="login_text">เพศ<span class="text-red-500"> *</span></p>
                    <select name="gender" class="bg-gray-100 border rounded-sm pl-2 text-sm w-full h-[37px]" required>
                        <option>ชาย</option>
                        <option>หญิง</option>
                    </select>
                </div>
                <div class="flex flex-col gap-2">
                    <p class="login_text">รหัสผ่าน<span class="text-red-500"> *</span></p>
                    <input type="password" name="password" placeholder="lorem1234sd@as" class="bg-gray-100 border rounded-sm pl-2 text-sm w-full h-[37px]" required>
                </div>

                <button type="reset" class="login_text mt-4 bg-white border-2 rounded-sm w-full h-[37px]">
                    ยกเลิก
                </button>
                <button type="submit" class="login_text text-white mt-4 bg-blue-950 rounded-sm w-full h-[37px]">
                    ลงทะเบียน
                </button>

            </form>
            <div class="flex flex-row items-center w-full h-[20px] mt-14">
                <a href="login.php">
                    <p class="text-blue-500 underline">มีบัญชีอยู่แล้ว</p>
                </a>
            </div>

        </div>

    </main>
</body>

</html>
