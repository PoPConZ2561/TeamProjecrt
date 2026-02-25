<?php
session_start();
$page = 'profile';

// 1. ตรวจสอบว่าเข้าสู่ระบบหรือยัง ถ้ายังให้เด้งกลับไปหน้า login
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
    <title>EVENTLY - profile</title>
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
    <main class="flex flex-row justify-center w-full h-full bg-gray-100 pt-[100px] gap-2">

        <!-- Panel ซ้าย: รูปและชื่อ -->
        <div class="flex flex-col w-[20%] h-[80%] bg-white rounded-t-lg shadow-md">
            <div class="w-full h-[34%] flex flex-col items-center bg-gradient-to-b from-purple-300 via-gray-100 to-purple-100 rounded-t-lg">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAM1BMVEXk5ueutLfn6eqrsbTp6+zg4uOwtrnJzc/j5earsbW0uby4vcDQ09XGyszU19jd3+G/xMamCvwDAAAFLklEQVR4nO2d2bLbIAxAbYE3sDH//7WFbPfexG4MiCAcnWmnrzkjIRaD2jQMwzAMwzAMwzAMwzAMwzAMwzAMwzAMwzAMwzAMwxwQkHJczewxZh2lhNK/CBOQo1n0JIT74/H/qMV0Z7GU3aCcVPuEE1XDCtVLAhgtpme7H0s1N1U7QjO0L8F7llzGeh1hEG/8Lo7TUmmuSrOfns9xnGXpXxsONPpA/B6OqqstjC6Ax/0ujkNdYQQbKNi2k64qiiEZ+ohi35X+2YcZw/WujmslYewiAliVYrxgJYrdwUmwXsU+RdApUi83oNIE27YvrfB/ZPg8+BJETXnqh9CVzBbTQHgojgiCvtqU9thFJg/CKz3VIMKMEkIXxIWqIpIg2SkjYj+xC816mrJae2aiWGykxRNsW0UwiJghJDljYI5CD8GRiCtIsJxizYUPQ2pzItZy5pcisTRdk/a9m4amtNNfBuQkdVhSaYqfpNTSFGfb9GRIakrE2Pm+GFLaCQPqiu0OpWP+HMPQQcgQMiQprWXNmsVwIjQjYi/ZrhAqNTCgr2gu0Jnz85RSSjso0HkMFZ0YZjKkc26a/jlmh9JiDyDxi9oeorTYAzZkwwoMz19pzj9bnH/GP/+qbchjSGflneWYhtTuKdMOmNKZcJ5TjInQKcYXnESd/jQxy0ENpULTNGOGgxpap/oyw9pbUAqhfx2Dbkhovvfgz4iUzoM9+GlK6/Mh4q29hyC1mwro30hpVVLPF9wYQr71RazOeM5/cw81iBRD+A03aM9/C/obbrKjbYSpCmIVG3qT/Q8oeUo3Rz0IL7vI1tEbCB9pSiu8I/aV8x3Kg/BGWrWp4ZVs0nZfmAoEG4h/61yHYIJiFSl6Q0Vk6tTW1N8kYp8hdOkfHYYMXd2Qft+8CYwqYDSKvqIh+MCF8Wgca2u/cwdgeW3TtuVn6+1oBs3yLo5C2JpK6CvQzGpfUkz9UG/87gCsi5o2LIXolxN0FbwAsjOLEr+YJmXn7iR6N0BCt5p5cMxm7eAsfS+/CACQf4CTpKjzgkvr2cVarVTf96372yut7XLJ1sa7lv6VcfgYrWaxqr3Wlo1S6pvStr22sxOtTNPLzdY3nj20bPP+ejFdJYkLsjGLdtPBEbe/mr2bQKiXWJDroA+vtzc0p9aahuwqHMDYrQEXHEw9jwQl3drMpts9JBU1SdktPe5FBRdJQ6bwXBpa57ib2A8kukQDzMjh++Uo7Fo6Wd02Pkf4fknqoo4HtvAIjsqUcjx6DIPgWCaOML9rKI/oqD9/lgNrn+eF+p7j8tnzHBiR7+kdUGw/+V1Kzkc75mMy6U+FMaxjPibiM1U1uGM+puInHpmALZCgP4pt7i840MV8+0R1zPsRB6UTcqpizncYwZ89syDydfyWCwXB1l8/zRNGWbTG/GHKUm9AkxHMc/EGSk3z2+ArEhPEV5TUBLEvUGFcjEUH80J/jveTGOAJEljJbILWGQT3zRYiwuKsUXN1EEJAzBhRJFll7mBUG7KD8EqPkKekBREaL8hMDZLQSG6AQjtHPYmvTQnX0TtpC1SYCe2YdkkyLP3jj5BSbKiuR585eQhTgoje6yIb0Yb0C+mV6EYvebqw5SDy2WmubogZiF2AVxPC2FpDf8H2Q9QWo6IkjUxTWVEI3WY/wrCeSuqJ+eRWzXR/JXwgVjUMozbCOfoEZiSiKVGepqv5CJ8RyR4D7xBeamqa7z3BJ/z17JxuBPdv93d/a2Ki878MMAzDMAzDMAzDMAzDMF/KP09VUmxBAiI3AAAAAElFTkSuQmCC"
                    class="w-24 h-24 object-cover rounded-[50%] border-white border-4 mt-10">
            </div>
            <div class="w-full h-[66%] flex flex-col items-center pt-12">
                <!-- ดึงชื่อและอีเมลมาแสดง -->
                <h1 class="title_text"><?php echo htmlspecialchars($_SESSION['username']); ?></h1>
                <p class="option_text text-gray-400 mt-2"><?php echo htmlspecialchars($_SESSION['email']); ?></p>
            </div>
        </div>

        <!-- Panel ขวา: ข้อมูลส่วนตัว -->
        <div class="flex flex-col w-[40%] h-[80%] bg-white shadow-md rounded-lg relative">
            <div class="grid grid-cols-2 grid-rows-3 w-full h-auto">

                <div class="flex flex-col p-4 border-b border-r">
                    <h1 class="option_header_text font-bold text-gray-500">ชื่อ - นามสกุล</h1>
                    <p class="option_text text-lg mt-1"><?php echo htmlspecialchars($_SESSION['username']); ?></p>
                </div>

                <div class="flex flex-col p-4 border-b">
                    <h1 class="option_header_text font-bold text-gray-500">วันเกิด</h1>
                    <!-- แปลงรูปแบบวันที่ให้อ่านง่ายขึ้น เช่น 25/02/2026 -->
                    <p class="option_text text-lg mt-1"><?php echo date('d / m / Y', strtotime($_SESSION['birthdate'])); ?></p>
                </div>

                <div class="flex flex-col p-4 border-b border-r">
                    <h1 class="option_header_text font-bold text-gray-500">อีเมล</h1>
                    <p class="option_text text-lg mt-1"><?php echo htmlspecialchars($_SESSION['email']); ?></p>
                </div>

                <div class="flex flex-col p-4 border-b">
                    <h1 class="option_header_text font-bold text-gray-500">เบอร์โทรศัพท์</h1>
                    <p class="option_text text-lg mt-1"><?php echo htmlspecialchars($_SESSION['phone_number']); ?></p>
                </div>

                <div class="flex flex-col p-4 border-b border-r">
                    <h1 class="option_header_text font-bold text-gray-500">เพศ</h1>
                    <p class="option_text text-lg mt-1"><?php echo htmlspecialchars($_SESSION['gender']); ?></p>
                </div>

                <div class="flex flex-col p-4 border-b">
                    <!-- เว้นว่างไว้จัด Layout ให้สวยงาม หรือใส่ข้อมูลอื่นเพิ่มในอนาคต -->
                </div>
            </div>

            <!-- ปุ่มกลับหน้าหลัก -->
                <a href="index.php" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-6 rounded-md shadow-sm transition-colors flex items-center gap-2 border border-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    กลับหน้าหลัก
                </a>
                
            <!-- ปุ่มแก้ไขข้อมูลส่วนตัว (จัดให้อยู่ด้านล่างขวา) -->
            <div class="absolute bottom-6 right-6">
                <!-- ตั้งลิงก์ไปยังหน้า edit_profile.php (คุณสามารถสร้างหน้านี้ในภายหลังได้) -->
                <a href="edit_profile.php" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md shadow-sm transition-colors flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                    แก้ไขข้อมูลส่วนตัว
                </a>
            </div>

        </div>

    </main>
</body>

</html>