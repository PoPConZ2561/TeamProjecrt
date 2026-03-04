<?php
session_start();

if (!isset($_POST['email']) || !isset($_POST['password'])) {
    header("Location: ../templates/login.php");
    exit();
} else {
    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';

    require_once __DIR__ . "/../includes/database.php";
    $conn = getConnection();
    
    // ใช้ Prepared Statement ป้องกัน SQL Injection
    $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION["user_id"] = $row["user_id"];
        $_SESSION["name"] = $row["name"];
        $_SESSION["email"] = $row["email"];
        $_SESSION["phone_number"] = $row["phone_number"];
        $_SESSION["birthdate"] = $row["birthdate"];
        $_SESSION["gender"] = $row["gender"];
        $_SESSION["password"] = $row["password"];

        $stmt->close();
        $conn->close();
        
        // 🌟 แก้ไข: ส่ง status=login_success ไปที่หน้า index ด้วย
        header("Location: ../templates/index.php?status=login_success");
        exit();
    } else {
        $stmt->close();
        $conn->close();
        header("Location: ../templates/login.php?error=1");
        exit();
    }
}
?>