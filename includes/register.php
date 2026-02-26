<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require("database.php");
    $conn = getConnection();

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];
    $password = $_POST['password']; // แนะนำว่าในอนาคตควรใช้ password_hash() นะครับ

    // 1. แก้ไข: เอาเครื่องหมาย ' ออกจาก ? ทั้งหมด
    $sql = "INSERT INTO users (name, email, phone_number, birthdate, gender, password) 
            VALUES (?, ?, ?, ?, ?, ?)";
            
    $stmt = $conn->prepare($sql);
    
    // ผูกตัวแปร 6 ตัว (s = string)
    $stmt->bind_param("ssssss", $name, $email, $phone_number, $birthdate, $gender, $password);
    
    // 2. สั่งรันคำสั่ง (และเช็คว่าสำเร็จไหม)
    if ($stmt->execute()) {
        // ถ้าสำเร็จให้ปิดการเชื่อมต่อแล้วเด้งไปหน้า Login
        $stmt->close();
        $conn->close();
        
        // แก้ไข path ให้ถูกต้อง
        header("Location: ../templates/login.php");
        exit(); // ควรใส่ exit() เสมอหลัง header location
    } else {
        // ถ้าไม่สำเร็จ (เช่น Email ซ้ำในระบบ) ให้โชว์ Error
        echo "เกิดข้อผิดพลาด: " . $stmt->error;
    }
}
?>