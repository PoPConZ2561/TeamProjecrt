<?php
require("database.php");

if (!isset($_POST['email']) || !isset($_POST['password'])) {
    header("Location: login.php");
    exit();
}
else {
        $email = $_POST["email"] ?? '';
        $password = $_POST["password"] ?? '';

    
    $conn = getConnection();
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION["name"] = $row["name"];
        $_SESSION["email"] = $row["email"];
        $_SESSION["password"] = $row["password"];
        header("Location: index.php");
        exit();
    } else {
        header("Location: login.php?error=1");
        exit();
    }
}