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
    $email = $_POST["email"];
    $phone_number = $_POST["phone_number"];
    $birthdate = $_POST["birthdate"];
    $gender = $_POST["gender"];

    $sql_update = "UPDATE users 
                   SET username = '$name', phone_number = '$phone_number', birthdate = '$birthdate', gender = '$gender' 
                   WHERE user_id = '$user_id'";
    if (mysqli_query($conn, $sql_update)) {
        echo "อัปเดตข้อมูลสำเร็จ!";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
    $_SESSION['username'] = $name;
    $_SESSION['phone_number'] = $phone_number;
    $_SESSION['birthdate'] = $birthdate;
    $_SESSION['gender'] = $gender;
    
    mysqli_close($conn);
    header("Location: ../templates/profile.php");
}
