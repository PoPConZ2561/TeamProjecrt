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
                   SET name = '?', phone_number = '?', birthdate = '?', gender = '?' 
                   WHERE user_id = '?'";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("ssssi", $name, $phone_number, $birthdate, $gender, $user_id);
    $stmt->execute();

    $_SESSION['name'] = $name;
    $_SESSION['phone_number'] = $phone_number;
    $_SESSION['birthdate'] = $birthdate;
    $_SESSION['gender'] = $gender;
    
    mysqli_close($conn);
    header("Location: ../templates/profile.php");
}
