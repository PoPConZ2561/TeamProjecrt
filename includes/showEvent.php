<?php

session_start();

require("database.php");
$conn = getConnection();

$sqlEvent = "SELECT * FROM events";
$result = $conn->query($sqlEvent);
$_SESSION["title"] = $result->fetch_assoc()["title"];
$_SESSION["description"] = $result->fetch_assoc()["description"];
$_SESSION["start_date"] = $result->fetch_assoc()["start_date"];
$_SESSION["end_date"] = $result->fetch_assoc()["end_date"];
$_SESSION["location"] = $result->fetch_assoc()["location"];
$_SESSION["max_participants"] = $result->fetch_assoc()["max_participants"];

$sqlEventImage = "SELECT * FROM event_images";
$resultImage = $conn->query($sqlEventImage);
$_SESSION["image_id"] = $resultImage->fetch_assoc()["image_id"];
$_SESSION["event_id"] = $resultImage->fetch_assoc()["event_id"];
$_SESSION["image_path"] = $resultImage->fetch_assoc()["image_path"];

?>
<?php foreach ($result as $row) : ?>
    <div class="flex flex-row w-full h-[280px] min-h-[280px] bg-white rounded-lg border shadow-sm">
        <img class="h-full w-[40%] object-cover rounded-l-lg" src="https://images.unsplash.com/photo-1522158637959-30385a09e0da?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTF8fGV2ZW50fGVufDB8fDB8fHww">
        <div class="flex flex-col gap-2 h-full w-[60%] flex-col px-4 py-6">
            <h1 class="title_event_text">
                <?php echo $row["title"] ?>
            </h1>
            <div class="w-[70%] gap-2">
                <p class="description">
                    <?php echo $row["description"] ?>
                </p>
                <!-- วันที่ตามผู้สร้าง -->
                <p class="description mt-2 text-bold">
                    <?php echo "วันที่ " . date("d M Y", strtotime($row["start_date"])) . " - " . date("d M Y", strtotime($row["end_date"])) ?>
                </p>
            </div>
            <div class="flex flex-row items-center w-full mt-auto">
                <div class="flex flex-row items-center w-1/2">
                    <!-- รูปผู้จัด เผื่ออยากเอา ไม่เอาก็ลบ
                                        <image src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAM1BMVEXk5ueutLfn6eqrsbTp6+zg4uOwtrnJzc/j5earsbW0uby4vcDQ09XGyszU19jd3+G/xMamCvwDAAAFLklEQVR4nO2d2bLbIAxAbYE3sDH//7WFbPfexG4MiCAcnWmnrzkjIRaD2jQMwzAMwzAMwzAMwzAMwzAMwzAMwzAMwzAMwzAMw5wQkHJczewxZh2lhNK/CBOQo1n0JIT74/H/qMV0Z7GU3aCcVPuEE1XDCtVLAhgtpme7H0s1N1U7QjO0L8F7llzGeh1hEG/8Lo7TUmmuSrOfns9xnGXpXxsONPpA/B6OqqstjC6Ax/0ujkNdYQQbKNi2k64qiiEZ+ohi35X+2YcZw/WujmslYewiAliVYrxgJYrdwUmwXsU+RdApUi83oNIE27YvrfB/ZPg8+BJETXnqh9CVzBbTQHgojgiCvtqU9thFJg/CKz3VIMKMEkIXxIWqIpIg2SkjYj+xC816mrJae2aiWGykxRNsW0UwiJghJDljYI5CD8GRiCtIsJxizYUPQ2pzItZy5pcisTRdk/a9m4amtNNfBuQkdVhSaYqfpNTSFGfb9GRIakrE2Pm+GFLaCQPqiu0OpWP+HMPQQcgQMiQprWXNmsVwIjQjYi/ZrhAqNTCgr2gu0Jnz85RSSjso0HkMFZ0YZjKkc26a/jlmh9JiDyDxi9oeorTYAzZkwwoMz19pzj9bnH/GP/+qbchjSGflneWYhtTuKdMOmNKZcJ5TjInQKcYXnESd/jQxy0ENpULTNGOGgxpap/oyw9pbUAqhfx2Dbkhovvfgz4iUzoM9+GlK6/Mh4q29hyC1mwro30hpVVLPF9wYQr71RazOeM5/cw81iBRD+A03aM9/C/obbrKjbYSpCmIVG3qT/Q8oeUo3Rz0IL7vI1tEbCB9pSiu8I/aV8x3Kg/BGWrWp4ZVs0nZfmAoEG4h/61yHYIJiFSl6Q0Vk6tTW1N8kYp8hdOkfHYYMXd2Qft+8CYwqYDSKvqIh+MCF8Wgca2u/cwdgeW3TtuVn6+1oBs3yLo5C2JpK6CvQzGpfUkz9UG/87gCsi5o2LIXolxN0FbwAsjOLEr+YJmXn7iR6N0BCt5p5cMxm7eAsfS+/CACQf4CTpKjzgkvr2cVarVTf96372yut7XLJ1sa7lv6VcfgYrWaxqr3Wlo1S6pvStr22sxOtTNPLzdY3nj20bPP+ejFdJYkLsjGLdtPBEbe/mr2bQKiXWJDroA+vtzc0p9aahuwqHMDYrQEXHEw9jwQl3drMpts9JBU1SdktPe5FBRdJQ6bwXBpa57ib2A8kukQDzMjh++Uo7Fo6Wd02Pkf4fknqoo4HtvAIjsqUcjx6DIPgWCaOML9rKI/oqD9/lgNrn+eF+p7j8tnzHBiR7+kdUGw/+V1Kzkc75mMy6U+FMaxjPibiM1U1uGM+puInHpmALZCgP4pt7i840MV8+0R1zPsRB6UTcqpizncYwZ89syDydfyWCwXB1l8/zRNGWbTG/GHKUm9AkxHMc/EGSk3z2+ArEhPEV5TUBLEvUGFcjEUH80J/jveTGOAJEljJbILWGQT3zRYiwuKsUXN1EEJAzBhRJFll7mBUG7KD8EqPkKekBREaL8hMDZLQSG6AQjtHPYmvTQnX0TtpC1SYCe2YdkkyLP3jj5BSbKiuR585eQhTgoje6yIb0Yb0C+mV6EYvebqw5SDy2WmubogZiF2AVxPC2FpDf8H2Q9QWo6IkjUxTWVEI3WY/wrCeSuqJ+eRWzXR/JXwgVjUMozbCOfoEZiSiKVGepqv5CJ8RyR4D7xBeamqa7z3BJ/z17JxuBPdv93d/a2Ki878MMAzDMAzDMAzDMAzDMF/KP09VUmxBAiI3AAAAAElFTkSuQmCC"
                                            class="rounded-[50%] h-[100%] object-cover w-10 h-10">
                                        <p class="option_text pl-2">Jonh Smith</p> -->
                    <p class="option_text pl-2 text-red-500"></p>
                </div>
                <div class="flex flex-row items-center justify-end w-1/2">
                    <form action="#" method="post ">
                        <!-- จำนวนคนที่ลงได้อิงจากผู้สร้าง ถ้าคนลงเต็มกดลงไม่ได้ เปลี่ยน text  -->
                        <button type="submit" class="option_text w-24 h-10 rounded-md shadow-md bg-green-400">
                            จำนวนผู้สมัคร <?php echo $row["max_participants"] ?>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>