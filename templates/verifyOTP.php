<?php
session_start();
if(!isset($_SESSION['user_id']) && !isset($_GET['event_id'])){
    header("Location: index.php");
    exit();
}

require_once __DIR__ . "/../includes/verify.php";
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

        .register_text {
            font-family: "Kanit", sans-serif;
            font-size: xx-large;
            font-weight: bolder;
            color: #172554;
        }

        .option_header_text {
            font-family: "Kanit", sans-serif;
            font-size: 200;
            font-weight: 300;
            color: #172554;
        }

        .login_text {
            font-family: "Kanit", sans-serif;
            font-size: medium;
            font-weight: 300;
            color: white;
        }
    </style>
</head>

<body class="flex flex-col min-h-screen w-full justify-between">
    <?php include 'header.php' ?>
    <main class="flex flex-grow flex-col items-center justify-center w-full bg-gray-200">
        <div class="flex flex-row w-[60%] h-[500px] bg-white rounded-md shadow-md">
            <div class="flex flex-row items-center justify-center w-[50%] h-full border-r-4 border-dashed">
                <img src="/templates/undraw_system-update_gekm.svg" class="w-[80%] mx-auto my-auto object-cover">
            </div>
            <div class="flex flex-row items-center justify-center w-[50%] h-full p-4">
                <div class="flex flex-col w-full h-full">
                    <div class="flex flex-row items-center">
                        <h1 class="register_text">ยืนยันรหัส OTP</h1>
                    </div>
                    <div class="flex flex-col justify-center p-4 gap-2">
                        <!-- เปลี่ยนให้เป็นอีเมลของผู้รับ -->
                        <h1 class="option_header_text">กรุณากรอกรหัส OTP ที่ส่งไปยังอีเมล XXX@gmail.com</h1>
                        <form method="post" action="" class="flex flex-col gap-2">
                            <input
                                type="text"
                                maxlength="6"
                                inputmode="numeric"
                                placeholder="------"
                                name="otp"
                                class="w-[80%] h-10 text-center text-2xl tracking-[1em]
                                border-2 border-gray-300
                                py-3 outline-none
                                focus:border-purple-500" />
                            <button type="submit" name="button_click" class="login_text w-[80%] h-10 bg-blue-950">
                                ยืนยัน
                            </button>
                        </form>
                        <p>
                            <?php if($isVerify == true){
                                echo "ยืนยันสำเร็จ";
                            } else if($isVerify == false && $_SERVER['REQUEST_METHOD'] === 'POST'){
                                echo "OTP ไม่ถูกต้อง";
                            }
                             ?>
                        </p>
                    </div>
                    <a href="\..\includes\OTP.php">
                        <button class="flex flex-row mt-auto pl-4">
                            <p class="login_text underline text-blue-500">ส่งรหัสผ่านอีกครั้ง</p>
                        </button>
                    </a>

                </div>
            </div>
        </div>
    </main>
</body>

</html>