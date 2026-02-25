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

    $sql = "INSERT INTO users (user_id, name, email, phone_number, birthdate, gender, password) 
    VALUES ('', '$name', '$email', '$phone_number', '$birthdate', '$gender', '$password')";

    mysqli_query($conn, $sql);

    header("Location: /../templates/login.php");
}
