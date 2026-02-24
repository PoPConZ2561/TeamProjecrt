<?php

session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require("database.php");
    $conn = getConnection();
    echo "Connected successfully";

    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];

    $sql = "INSERT INTO users (user_id, username, email, phone_number, birthdate, gender, password) 
    VALUES ('', '$username', '$email', '$phone_number', '$birthdate', '$gender', '$password')";

    mysqli_query($conn, $sql);
}