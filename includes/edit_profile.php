<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require("database.php");
    $conn = getConnection();

    $user_id = $_SESSION["user_id"];
    $name = $_POST["name"];
    // ส่วน email เราไม่ได้อัปเดต เพราะตั้งเป็น readonly ไว้
    $phone_number = $_POST["phone_number"];
    $birthdate = $_POST["birthdate"];
    $gender = $_POST["gender"];

    $sql_update = "UPDATE users 
                   SET name = ?, phone_number = ?, birthdate = ?, gender = ? 
                   WHERE user_id = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("ssssi", $name, $phone_number, $birthdate, $gender, $user_id);
    
    // ตรวจสอบว่าอัปเดตสำเร็จหรือไม่
    if ($stmt->execute()) {
        // อัปเดตข้อมูลใน Session ด้วย เพื่อให้หน้าเว็บเปลี่ยนตามทันที
        $_SESSION['name'] = $name;
        $_SESSION['phone_number'] = $phone_number;
        $_SESSION['birthdate'] = $birthdate;
        $_SESSION['gender'] = $gender;
        
        mysqli_close($conn);
        
        // 🌟 เพิ่ม Alert แจ้งเตือนว่าสำเร็จ แล้วค่อยเด้งไปหน้าโปรไฟล์
        echo "<script>
                alert('อัปเดตข้อมูลส่วนตัวเรียบร้อยแล้ว!');
                window.location.href = '../templates/profile.php';
              </script>";
        exit();
    } else {
        mysqli_close($conn);
        
        // 🌟 เพิ่ม Alert กรณีเกิดข้อผิดพลาด
        echo "<script>
                alert('เกิดข้อผิดพลาดในการอัปเดตข้อมูล กรุณาลองใหม่อีกครั้ง');
                window.history.back();
              </script>";
        exit();
    }
}