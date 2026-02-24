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
                            class="text-sm text-gray-400 w-full pl-1 bg-white rounded-sm border" required>
                        <p class="option_text">วันสิ้นสุด</p>
                        <input type="date"
                            class="text-sm text-gray-400 w-full pl-1 bg-white rounded-sm border" required>
                        <input type="submit" value="ค้นหา" class="mt-2 text-white h-10 bg-green-400 rounded-md shadow-sm">
                    </form>
                </div>
            </div>

            <div class="ml-10 flex flex-col w-[75%] h-fit px-2 gap-2 ">
                <div class="flex flex-row items-center w-full h-[30px] min-h-[30px] mb-3">
                    <h2 class="option_header_text text-orange-400 text-2xl font-bold">อีเว้นท์ทั้งหมด</h2>
                </div>
                <!-- ไปแก้ไข ให้ข้อมูลตามผู้จัด ใน database -->
                <div class="flex flex-row w-full h-[280px] min-h-[280px] bg-white rounded-lg border shadow-sm">
                    <img class="h-full w-[40%] object-cover rounded-l-lg" src="https://images.unsplash.com/photo-1522158637959-30385a09e0da?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTF8fGV2ZW50fGVufDB8fDB8fHww">
                        <div class="flex flex-col gap-2 h-full w-[60%] flex-col px-4 py-6">
                            <h1 class="title_event_text">Night Pulse Music Festival</h1>
                            <div class="w-[70%] gap-2">
                                <p class="description">เทศกาลดนตรียามค่ำคืนที่รวมศิลปินหลากหลายแนว มอบประสบการณ์ แสง สี เสียง สุดตื่นตาตื่นใจ ให้แก่ผู้เข้าร่วม
                                    ได้ปลดปล่อยพลังและสนุกไปกับจังหวะ ดนตรีท่ามกลางบรรยากาศสุดมันส์
                                </p>
                                <!-- วันที่ตามผู้สร้าง -->
                                <p class="description mt-2 text-bold">
                                    จันทร์ 12/2/69 - พุธ 14/2/69
                                </p>
                            </div>
                            <div class="flex flex-row items-center w-full mt-auto">
                                <div class="flex flex-row items-center w-1/2">
                                    <!-- รูปผู้จัด เผื่ออยากเอา ไม่เอาก็ลบ
                                    <image src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAM1BMVEXk5ueutLfn6eqrsbTp6+zg4uOwtrnJzc/j5earsbW0uby4vcDQ09XGyszU19jd3+G/xMamCvwDAAAFLklEQVR4nO2d2bLbIAxAbYE3sDH//7WFbPfexG4MiCAcnWmnrzkjIRaD2jQMwzAMwzAMwzAMwzAMwzAMwzAMwzAMwzAMwzAMw5wQkHJczewxZh2lhNK/CBOQo1n0JIT74/H/qMV0Z7GU3aCcVPuEE1XDCtVLAhgtpme7H0s1N1U7QjO0L8F7llzGeh1hEG/8Lo7TUmmuSrOfns9xnGXpXxsONPpA/B6OqqstjC6Ax/0ujkNdYQQbKNi2k64qiiEZ+ohi35X+2YcZw/WujmslYewiAliVYrxgJYrdwUmwXsU+RdApUi83oNIE27YvrfB/ZPg8+BJETXnqh9CVzBbTQHgojgiCvtqU9thFJg/CKz3VIMKMEkIXxIWqIpIg2SkjYj+xC816mrJae2aiWGykxRNsW0UwiJghJDljYI5CD8GRiCtIsJxizYUPQ2pzItZy5pcisTRdk/a9m4amtNNfBuQkdVhSaYqfpNTSFGfb9GRIakrE2Pm+GFLaCQPqiu0OpWP+HMPQQcgQMiQprWXNmsVwIjQjYi/ZrhAqNTCgr2gu0Jnz85RSSjso0HkMFZ0YZjKkc26a/jlmh9JiDyDxi9oeorTYAzZkwwoMz19pzj9bnH/GP/+qbchjSGflneWYhtTuKdMOmNKZcJ5TjInQKcYXnESd/jQxy0ENpULTNGOGgxpap/oyw9pbUAqhfx2Dbkhovvfgz4iUzoM9+GlK6/Mh4q29hyC1mwro30hpVVLPF9wYQr71RazOeM5/cw81iBRD+A03aM9/C/obbrKjbYSpCmIVG3qT/Q8oeUo3Rz0IL7vI1tEbCB9pSiu8I/aV8x3Kg/BGWrWp4ZVs0nZfmAoEG4h/61yHYIJiFSl6Q0Vk6tTW1N8kYp8hdOkfHYYMXd2Qft+8CYwqYDSKvqIh+MCF8Wgca2u/cwdgeW3TtuVn6+1oBs3yLo5C2JpK6CvQzGpfUkz9UG/87gCsi5o2LIXolxN0FbwAsjOLEr+YJmXn7iR6N0BCt5p5cMxm7eAsfS+/CACQf4CTpKjzgkvr2cVarVTf96372yut7XLJ1sa7lv6VcfgYrWaxqr3Wlo1S6pvStr22sxOtTNPLzdY3nj20bPP+ejFdJYkLsjGLdtPBEbe/mr2bQKiXWJDroA+vtzc0p9aahuwqHMDYrQEXHEw9jwQl3drMpts9JBU1SdktPe5FBRdJQ6bwXBpa57ib2A8kukQDzMjh++Uo7Fo6Wd02Pkf4fknqoo4HtvAIjsqUcjx6DIPgWCaOML9rKI/oqD9/lgNrn+eF+p7j8tnzHBiR7+kdUGw/+V1Kzkc75mMy6U+FMaxjPibiM1U1uGM+puInHpmALZCgP4pt7i840MV8+0R1zPsRB6UTcqpizncYwZ89syDydfyWCwXB1l8/zRNGWbTG/GHKUm9AkxHMc/EGSk3z2+ArEhPEV5TUBLEvUGFcjEUH80J/jveTGOAJEljJbILWGQT3zRYiwuKsUXN1EEJAzBhRJFll7mBUG7KD8EqPkKekBREaL8hMDZLQSG6AQjtHPYmvTQnX0TtpC1SYCe2YdkkyLP3jj5BSbKiuR585eQhTgoje6yIb0Yb0C+mV6EYvebqw5SDy2WmubogZiF2AVxPC2FpDf8H2Q9QWo6IkjUxTWVEI3WY/wrCeSuqJ+eRWzXR/JXwgVjUMozbCOfoEZiSiKVGepqv5CJ8RyR4D7xBeamqa7z3BJ/z17JxuBPdv93d/a2Ki878MMAzDMAzDMAzDMAzDMF/KP09VUmxBAiI3AAAAAElFTkSuQmCC"
                                        class="rounded-[50%] h-[100%] object-cover w-10 h-10">
                                    <p class="option_text pl-2">Jonh Smith</p> -->
                                    <p class="option_text pl-2 text-red-500">* ต้องมีอายุ 20 ปีบริบูรณ์</p>
                                </div>
                                <div class="flex flex-row items-center justify-end w-1/2">
                                    <form action="#" method="post ">
                                        <!-- จำนวนคนที่ลงได้อิงจากผู้สร้าง ถ้าคนลงเต็มกดลงไม่ได้ เปลี่ยน text  -->
                                        <button type="submit" class="option_text w-24 h-10 rounded-md shadow-md bg-green-400">
                                            สมัคร (0/150)
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="flex flex-row w-full h-[280px] min-h-[280px] bg-white rounded-lg border shadow-sm">
                    <img class="h-full w-[40%] object-cover rounded-l-lg" src="https://images.unsplash.com/photo-1505373877841-8d25f7d46678?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OHx8ZXZlbnR8ZW58MHx8MHx8fDA%3D">
                        <div class="flex flex-col gap-2 h-full w-[60%] flex-col px-4 py-6">
                            <h1 class="title_event_text">Digital Innovation Showcase 2026</h1>
                            <div class="w-[70%] gap-2">
                                <p class="description"> งานนำเสนอผลงานและนวัตกรรมด้านเทคโนโลยีดิจิทัล เปิดพื้นที่ให้ผู้พัฒนา และนักศึกษาร่วมแสดงไอเดีย
                                    ผลงานแอปพลิเคชั่นและโซลูชั่นใหม่ๆ
                                </p>
                                <!-- วันที่ตามผู้สร้าง -->
                                <p class="description mt-2 text-bold">
                                    พฤหัสบดี 24/3/69 - เสาร์ 26/3/69
                                </p>
                            </div>
                            <div class="flex flex-row items-center w-full mt-auto">
                                <div class="flex flex-row items-center w-1/2">
                                    <!-- รูปผู้จัด เผื่ออยากเอา ไม่เอาก็ลบ
                                    <image src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAM1BMVEXk5ueutLfn6eqrsbTp6+zg4uOwtrnJzc/j5earsbW0uby4vcDQ09XGyszU19jd3+G/xMamCvwDAAAFLklEQVR4nO2d2bLbIAxAbYE3sDH//7WFbPfexG4MiCAcnWmnrzkjIRaD2jQMwzAMwzAMwzAMwzAMwzAMwzAMwzAMwzAMwzAMw5wQkHJczewxZh2lhNK/CBOQo1n0JIT74/H/qMV0Z7GU3aCcVPuEE1XDCtVLAhgtpme7H0s1N1U7QjO0L8F7llzGeh1hEG/8Lo7TUmmuSrOfns9xnGXpXxsONPpA/B6OqqstjC6Ax/0ujkNdYQQbKNi2k64qiiEZ+ohi35X+2YcZw/WujmslYewiAliVYrxgJYrdwUmwXsU+RdApUi83oNIE27YvrfB/ZPg8+BJETXnqh9CVzBbTQHgojgiCvtqU9thFJg/CKz3VIMKMEkIXxIWqIpIg2SkjYj+xC816mrJae2aiWGykxRNsW0UwiJghJDljYI5CD8GRiCtIsJxizYUPQ2pzItZy5pcisTRdk/a9m4amtNNfBuQkdVhSaYqfpNTSFGfb9GRIakrE2Pm+GFLaCQPqiu0OpWP+HMPQQcgQMiQprWXNmsVwIjQjYi/ZrhAqNTCgr2gu0Jnz85RSSjso0HkMFZ0YZjKkc26a/jlmh9JiDyDxi9oeorTYAzZkwwoMz19pzj9bnH/GP/+qbchjSGflneWYhtTuKdMOmNKZcJ5TjInQKcYXnESd/jQxy0ENpULTNGOGgxpap/oyw9pbUAqhfx2Dbkhovvfgz4iUzoM9+GlK6/Mh4q29hyC1mwro30hpVVLPF9wYQr71RazOeM5/cw81iBRD+A03aM9/C/obbrKjbYSpCmIVG3qT/Q8oeUo3Rz0IL7vI1tEbCB9pSiu8I/aV8x3Kg/BGWrWp4ZVs0nZfmAoEG4h/61yHYIJiFSl6Q0Vk6tTW1N8kYp8hdOkfHYYMXd2Qft+8CYwqYDSKvqIh+MCF8Wgca2u/cwdgeW3TtuVn6+1oBs3yLo5C2JpK6CvQzGpfUkz9UG/87gCsi5o2LIXolxN0FbwAsjOLEr+YJmXn7iR6N0BCt5p5cMxm7eAsfS+/CACQf4CTpKjzgkvr2cVarVTf96372yut7XLJ1sa7lv6VcfgYrWaxqr3Wlo1S6pvStr22sxOtTNPLzdY3nj20bPP+ejFdJYkLsjGLdtPBEbe/mr2bQKiXWJDroA+vtzc0p9aahuwqHMDYrQEXHEw9jwQl3drMpts9JBU1SdktPe5FBRdJQ6bwXBpa57ib2A8kukQDzMjh++Uo7Fo6Wd02Pkf4fknqoo4HtvAIjsqUcjx6DIPgWCaOML9rKI/oqD9/lgNrn+eF+p7j8tnzHBiR7+kdUGw/+V1Kzkc75mMy6U+FMaxjPibiM1U1uGM+puInHpmALZCgP4pt7i840MV8+0R1zPsRB6UTcqpizncYwZ89syDydfyWCwXB1l8/zRNGWbTG/GHKUm9AkxHMc/EGSk3z2+ArEhPEV5TUBLEvUGFcjEUH80J/jveTGOAJEljJbILWGQT3zRYiwuKsUXN1EEJAzBhRJFll7mBUG7KD8EqPkKekBREaL8hMDZLQSG6AQjtHPYmvTQnX0TtpC1SYCe2YdkkyLP3jj5BSbKiuR585eQhTgoje6yIb0Yb0C+mV6EYvebqw5SDy2WmubogZiF2AVxPC2FpDf8H2Q9QWo6IkjUxTWVEI3WY/wrCeSuqJ+eRWzXR/JXwgVjUMozbCOfoEZiSiKVGepqv5CJ8RyR4D7xBeamqa7z3BJ/z17JxuBPdv93d/a2Ki878MMAzDMAzDMAzDMAzDMF/KP09VUmxBAiI3AAAAAElFTkSuQmCC"
                                        class="rounded-[50%] h-[100%] object-cover w-10 h-10">
                                    <p class="option_text pl-2">Jonh Smith</p> -->
                                    <p class="option_text pl-2 text-red-500">* เฉพาะนิสิตมหาวิทยาลัยมหาสารคาม</p>
                                </div>
                                <div class="flex flex-row items-center justify-end w-1/2">
                                    <form action="#" method="post ">
                                        <!-- จำนวนคนที่ลงได้อิงจากผู้สร้าง ถ้าคนลงเต็มกดลงไม่ได้ เปลี่ยน text  -->
                                        <button type="submit" class="option_text w-24 h-10 rounded-md shadow-md bg-green-400">
                                            สมัคร (0/200)
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="flex flex-row w-full h-[280px] min-h-[280px] bg-white rounded-lg border shadow-sm">
                    <img class="h-full w-[40%] object-cover rounded-l-lg" src="https://images.unsplash.com/photo-1638132704795-6bb223151bf7?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTl8fGV2ZW50fGVufDB8fDB8fHww">
                        <div class="flex flex-col gap-2 h-full w-[60%] flex-col px-4 py-6">
                            <h1 class="title_event_text">Creative Street Market Festival</h1>
                            <div class="w-[70%] gap-2">
                                <p class="description"> เทศกาลตลาดสร้างสรรค์กลางแจ้ง รวมร้านค้า อาหาร งานแฮนด์เมด และกิจกรรมชุมชนใน
                                    บรรยากาศเป็นกันเอง เหมาะสำหรับการเดินเล่นพักผ่อน
                                </p>
                                <!-- วันที่ตามผู้สร้าง -->
                                <p class="description mt-2 text-bold">
                                    อาทิตย์ 2/4/69 - ศุกร์ 7/4/69
                                </p>
                            </div>
                            <div class="flex flex-row items-center w-full mt-auto">
                                <div class="flex flex-row items-center w-1/2">
                                    <!-- รูปผู้จัด เผื่ออยากเอา ไม่เอาก็ลบ
                                    <image src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAM1BMVEXk5ueutLfn6eqrsbTp6+zg4uOwtrnJzc/j5earsbW0uby4vcDQ09XGyszU19jd3+G/xMamCvwDAAAFLklEQVR4nO2d2bLbIAxAbYE3sDH//7WFbPfexG4MiCAcnWmnrzkjIRaD2jQMwzAMwzAMwzAMwzAMwzAMwzAMwzAMwzAMwzAMw5wQkHJczewxZh2lhNK/CBOQo1n0JIT74/H/qMV0Z7GU3aCcVPuEE1XDCtVLAhgtpme7H0s1N1U7QjO0L8F7llzGeh1hEG/8Lo7TUmmuSrOfns9xnGXpXxsONPpA/B6OqqstjC6Ax/0ujkNdYQQbKNi2k64qiiEZ+ohi35X+2YcZw/WujmslYewiAliVYrxgJYrdwUmwXsU+RdApUi83oNIE27YvrfB/ZPg8+BJETXnqh9CVzBbTQHgojgiCvtqU9thFJg/CKz3VIMKMEkIXxIWqIpIg2SkjYj+xC816mrJae2aiWGykxRNsW0UwiJghJDljYI5CD8GRiCtIsJxizYUPQ2pzItZy5pcisTRdk/a9m4amtNNfBuQkdVhSaYqfpNTSFGfb9GRIakrE2Pm+GFLaCQPqiu0OpWP+HMPQQcgQMiQprWXNmsVwIjQjYi/ZrhAqNTCgr2gu0Jnz85RSSjso0HkMFZ0YZjKkc26a/jlmh9JiDyDxi9oeorTYAzZkwwoMz19pzj9bnH/GP/+qbchjSGflneWYhtTuKdMOmNKZcJ5TjInQKcYXnESd/jQxy0ENpULTNGOGgxpap/oyw9pbUAqhfx2Dbkhovvfgz4iUzoM9+GlK6/Mh4q29hyC1mwro30hpVVLPF9wYQr71RazOeM5/cw81iBRD+A03aM9/C/obbrKjbYSpCmIVG3qT/Q8oeUo3Rz0IL7vI1tEbCB9pSiu8I/aV8x3Kg/BGWrWp4ZVs0nZfmAoEG4h/61yHYIJiFSl6Q0Vk6tTW1N8kYp8hdOkfHYYMXd2Qft+8CYwqYDSKvqIh+MCF8Wgca2u/cwdgeW3TtuVn6+1oBs3yLo5C2JpK6CvQzGpfUkz9UG/87gCsi5o2LIXolxN0FbwAsjOLEr+YJmXn7iR6N0BCt5p5cMxm7eAsfS+/CACQf4CTpKjzgkvr2cVarVTf96372yut7XLJ1sa7lv6VcfgYrWaxqr3Wlo1S6pvStr22sxOtTNPLzdY3nj20bPP+ejFdJYkLsjGLdtPBEbe/mr2bQKiXWJDroA+vtzc0p9aahuwqHMDYrQEXHEw9jwQl3drMpts9JBU1SdktPe5FBRdJQ6bwXBpa57ib2A8kukQDzMjh++Uo7Fo6Wd02Pkf4fknqoo4HtvAIjsqUcjx6DIPgWCaOML9rKI/oqD9/lgNrn+eF+p7j8tnzHBiR7+kdUGw/+V1Kzkc75mMy6U+FMaxjPibiM1U1uGM+puInHpmALZCgP4pt7i840MV8+0R1zPsRB6UTcqpizncYwZ89syDydfyWCwXB1l8/zRNGWbTG/GHKUm9AkxHMc/EGSk3z2+ArEhPEV5TUBLEvUGFcjEUH80J/jveTGOAJEljJbILWGQT3zRYiwuKsUXN1EEJAzBhRJFll7mBUG7KD8EqPkKekBREaL8hMDZLQSG6AQjtHPYmvTQnX0TtpC1SYCe2YdkkyLP3jj5BSbKiuR585eQhTgoje6yIb0Yb0C+mV6EYvebqw5SDy2WmubogZiF2AVxPC2FpDf8H2Q9QWo6IkjUxTWVEI3WY/wrCeSuqJ+eRWzXR/JXwgVjUMozbCOfoEZiSiKVGepqv5CJ8RyR4D7xBeamqa7z3BJ/z17JxuBPdv93d/a2Ki878MMAzDMAzDMAzDMAzDMF/KP09VUmxBAiI3AAAAAElFTkSuQmCC"
                                        class="rounded-[50%] h-[100%] object-cover w-10 h-10">
                                    <p class="option_text pl-2">Jonh Smith</p> -->
                                    <p class="option_text pl-2 text-green-500">ใครๆก็เข้าร่วมได้</p>
                                </div>
                                <div class="flex flex-row items-center justify-end w-1/2">
                                    <form action="#" method="post ">
                                        <!-- จำนวนคนที่ลงได้อิงจากผู้สร้าง ถ้าคนลงเต็มกดลงไม่ได้ เปลี่ยน text  -->
                                        <button type="submit" class="option_text w-24 h-10 rounded-md shadow-md bg-green-400">
                                            สมัคร
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <?php include 'footer.php' ?>
    </main>
</body>

</html>