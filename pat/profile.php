<?php
session_start();
$page = 'profile';
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
        <div class="flex flex-col w-[20%] h-[80%] bg-white rounded-t-lg shadow-md">
            <div class="w-full h-[34%] flex flex-col items-center bg-gradient-to-b from-purple-300 via-gray-100 to-purple-100 rounded-t-lg">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAM1BMVEXk5ueutLfn6eqrsbTp6+zg4uOwtrnJzc/j5earsbW0uby4vcDQ09XGyszU19jd3+G/xMamCvwDAAAFLklEQVR4nO2d2bLbIAxAbYE3sDH//7WFbPfexG4MiCAcnWmnrzkjIRaD2jQMwzAMwzAMwzAMwzAMwzAMwzAMwzAMwzAMwzAMw5wQkHJczewxZh2lhNK/CBOQo1n0JIT74/H/qMV0Z7GU3aCcVPuEE1XDCtVLAhgtpme7H0s1N1U7QjO0L8F7llzGeh1hEG/8Lo7TUmmuSrOfns9xnGXpXxsONPpA/B6OqqstjC6Ax/0ujkNdYQQbKNi2k64qiiEZ+ohi35X+2YcZw/WujmslYewiAliVYrxgJYrdwUmwXsU+RdApUi83oNIE27YvrfB/ZPg8+BJETXnqh9CVzBbTQHgojgiCvtqU9thFJg/CKz3VIMKMEkIXxIWqIpIg2SkjYj+xC816mrJae2aiWGykxRNsW0UwiJghJDljYI5CD8GRiCtIsJxizYUPQ2pzItZy5pcisTRdk/a9m4amtNNfBuQkdVhSaYqfpNTSFGfb9GRIakrE2Pm+GFLaCQPqiu0OpWP+HMPQQcgQMiQprWXNmsVwIjQjYi/ZrhAqNTCgr2gu0Jnz85RSSjso0HkMFZ0YZjKkc26a/jlmh9JiDyDxi9oeorTYAzZkwwoMz19pzj9bnH/GP/+qbchjSGflneWYhtTuKdMOmNKZcJ5TjInQKcYXnESd/jQxy0ENpULTNGOGgxpap/oyw9pbUAqhfx2Dbkhovvfgz4iUzoM9+GlK6/Mh4q29hyC1mwro30hpVVLPF9wYQr71RazOeM5/cw81iBRD+A03aM9/C/obbrKjbYSpCmIVG3qT/Q8oeUo3Rz0IL7vI1tEbCB9pSiu8I/aV8x3Kg/BGWrWp4ZVs0nZfmAoEG4h/61yHYIJiFSl6Q0Vk6tTW1N8kYp8hdOkfHYYMXd2Qft+8CYwqYDSKvqIh+MCF8Wgca2u/cwdgeW3TtuVn6+1oBs3yLo5C2JpK6CvQzGpfUkz9UG/87gCsi5o2LIXolxN0FbwAsjOLEr+YJmXn7iR6N0BCt5p5cMxm7eAsfS+/CACQf4CTpKjzgkvr2cVarVTf96372yut7XLJ1sa7lv6VcfgYrWaxqr3Wlo1S6pvStr22sxOtTNPLzdY3nj20bPP+ejFdJYkLsjGLdtPBEbe/mr2bQKiXWJDroA+vtzc0p9aahuwqHMDYrQEXHEw9jwQl3drMpts9JBU1SdktPe5FBRdJQ6bwXBpa57ib2A8kukQDzMjh++Uo7Fo6Wd02Pkf4fknqoo4HtvAIjsqUcjx6DIPgWCaOML9rKI/oqD9/lgNrn+eF+p7j8tnzHBiR7+kdUGw/+V1Kzkc75mMy6U+FMaxjPibiM1U1uGM+puInHpmALZCgP4pt7i840MV8+0R1zPsRB6UTcqpizncYwZ89syDydfyWCwXB1l8/zRNGWbTG/GHKUm9AkxHMc/EGSk3z2+ArEhPEV5TUBLEvUGFcjEUH80J/jveTGOAJEljJbILWGQT3zRYiwuKsUXN1EEJAzBhRJFll7mBUG7KD8EqPkKekBREaL8hMDZLQSG6AQjtHPYmvTQnX0TtpC1SYCe2YdkkyLP3jj5BSbKiuR585eQhTgoje6yIb0Yb0C+mV6EYvebqw5SDy2WmubogZiF2AVxPC2FpDf8H2Q9QWo6IkjUxTWVEI3WY/wrCeSuqJ+eRWzXR/JXwgVjUMozbCOfoEZiSiKVGepqv5CJ8RyR4D7xBeamqa7z3BJ/z17JxuBPdv93d/a2Ki878MMAzDMAzDMAzDMAzDMF/KP09VUmxBAiI3AAAAAElFTkSuQmCC"
                    class="w-24 h-24 object-cover rounded-[50%] border-white border-4 mt-10">
            </div>
            <div class="w-full h-[66%] flex flex-col items-center pt-12">
                <h1 class="title_text">name</h1>
                <p class="option_text text-gray-400">XXX@msu.ac.th</p>
            </div>
        </div>
        <div class="flex flex-col w-[30%] h-[80%] bg-white shadow-md">
            <div class="grid grid-cols-2 grid-rows-3 w-full h-1/2">
                <div class="flex flex-col p-2 border-b border-r">
                    <h1 class="option_header_text">ชื่อ</h1>
                    <p class="option_text">name</p>
                </div>
                <div class="flex flex-col p-2 border-b border-r">
                    <h1 class="option_header_text">วันเกิด</h1>
                    <p class="option_text">birth date</p>
                </div>
                <div class="flex flex-col p-2 border-b border-r">
                    <h1 class="option_header_text">อีเมล</h1>
                    <p class="option_text">XXX@msu.ac.th</p>
                </div>
                <div class="flex flex-col p-2 border-b border-r">
                    <h1 class="option_header_text">เบอร์โทรศัพท์</h1>
                    <p class="option_text">XXX-XXX-XXXX</p>
                </div>
                <div class="flex flex-col p-2 border-b border-r">
                    <h1 class="option_header_text">เพศ</h1>
                    <p class="option_text">gender</p>
                </div>
            </div>
            <h1 class="option_header_text pl-4 pt-2">Status</h1>
            <div class="flex flex-col m-4 border h-full overflow-y-auto">
                <div class="flex flex-row w-full h-[50px] border-b min-h-[50px]">
                    <!-- ปรับด้วย -->
                    <div class="flex flex-row items-center w-1/2 px-4">
                        <h1 class="option_text font-bold text-lg">Title</h1>
                    </div>
                    <div class="flex flex-row items-center justify-end items-center w-1/2 px-4">
                        <h1 class="option_text text-lg">Status</h1>
                    </div>
                </div>
                <div class="flex flex-row w-full h-[50px] border-b min-h-[50px]">
                    <div class="flex flex-row items-center w-1/2 px-4">
                        <h1 class="option_text font-bold text-lg">Title</h1>
                    </div>
                    <div class="flex flex-row items-center justify-end items-center w-1/2 px-4">
                        <h1 class="option_text text-lg">Status</h1>
                    </div>
                </div>
                <div class="flex flex-row w-full h-[50px] border-b min-h-[50px]">
                    <div class="flex flex-row items-center w-1/2 px-4">
                        <h1 class="option_text font-bold text-lg">Title</h1>
                    </div>
                    <div class="flex flex-row items-center justify-end items-center w-1/2 px-4">
                        <h1 class="option_text text-lg">Status</h1>
                    </div>
                </div>
                <div class="flex flex-row w-full h-[50px] border-b min-h-[50px]">
                    <div class="flex flex-row items-center w-1/2 px-4">
                        <h1 class="option_text font-bold text-lg">Title</h1>
                    </div>
                    <div class="flex flex-row items-center justify-end items-center w-1/2 px-4">
                        <h1 class="option_text text-lg">Status</h1>
                    </div>
                </div>
            </div>
        </div>

    </main>
</body>

</html>