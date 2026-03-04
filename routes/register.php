<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require("../includes/database.php"); // ปรับ Path ให้ถอยกลับไปหา includes
    $conn = getConnection();

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];
    $password = $_POST['password']; 

    // ใช้ Prepared Statement
    $sql = "INSERT INTO users (name, email, phone_number, birthdate, gender, password) 
            VALUES (?, ?, ?, ?, ?, ?)";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $name, $email, $phone_number, $birthdate, $gender, $password);
    
    // สั่งรันคำสั่ง
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        // สมัครสำเร็จ ให้เด้งไปหน้า login พร้อมส่ง status=register_success ไปด้วย
        header("Location: ../templates/login.php?status=register_success");
        exit();
    } else {
        $stmt->close();
        $conn->close();
        // สมัครไม่สำเร็จ (เช่น อีเมลซ้ำ) เด้งกลับไปหน้า register พร้อมส่ง error
        header("Location: ../templates/register.php?status=error");
        exit();
    }
}
?>