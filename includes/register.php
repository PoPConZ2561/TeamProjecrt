<?php

session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require("database.php");
    $conn = getConnection();
    echo "Connected successfully";

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];

    $sql = "INSERT INTO users (name, email, phone_number, birthdate, gender, password) 
            VALUES ('?', '?', '?', '?', '?', '?')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $name, $email, $phone_number, $birthdate, $gender, $password);
    $stmt->execute();

    mysqli_query($conn, $sql);

    header("Location: /../templates/login.php");
}
