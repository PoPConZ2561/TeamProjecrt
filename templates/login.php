<?php
session_start();
$page = "index";

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
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
    <?php include 'header.php'?>
    <main class="flex flex-grow flex-col items-center justify-center w-full bg-gray-200">
        <div class="flex flex-row w-[60%] h-[500px] bg-white rounded-lg shadow-md mt-10">
            <div class="flex w-[55%] h-full border-r">
                <img src="/templates/undraw_people_ka7y.svg" class="w-[80%] mx-auto my-auto object-cover">
            </div>
            <div class="flex flex-col w-[45%] p-6 gap-2">
                <h1 class="register_text">เข้าสู่ระบบ</h1>
                <form action="\..\includes\check_login.php" method="post" class="flex flex-col gap-4">
                    <input type="email" name="email" placeholder="อีเมล" class="pl-2 w-full h-[40px] border rounded-sm">
                    <input type="password" name="password" placeholder="รหัสผ่าน" class="pl-2 w-full h-[40px] border rounded-sm">
                    <input type="submit" value="ยืนยัน" class="login_text pl-2 w-full h-[40px] bg-blue-950 rounded-sm">
                </form>
                <p>
                    <?php
                    if (isset($_GET['error']) && $_GET['error'] == 1) {
                        echo "<span class='text-red-500'>อีเมลหรือรหัสผ่านไม่ถูกต้อง</span>";
                    }
                    ?>
                </p>
                <a href="register.php" class="w-full mt-auto">
                    <p class="text-blue-500 underline">สมัครบัญชีใหม่</p>
                </a>
            </div>
        </div> 
    </main>
</body>

</html>