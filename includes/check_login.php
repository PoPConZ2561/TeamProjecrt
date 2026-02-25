<?php
if (!isset($_POST['email']) || !isset($_POST['password'])) {
    header("Location: login.php");
    exit();
} else {
    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';

    require("database.php");
    $conn = getConnection();
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION["name"] = $row["name"];
        $_SESSION["email"] = $row["email"];
        $_SESSION["password"] = $row["password"];

        $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($conn, $sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["name"] = $row["name"];
            $_SESSION["email"] = $row["email"];
            $_SESSION["phone_number"] = $row["phone_number"];
            $_SESSION["birthdate"] = $row["birthdate"];
            $_SESSION["gender"] = $row["gender"];
            header("Location: /../templates/index.php");
        }
        
        header("Location: /../templates/index.php");
        exit();
    } else {
        header("Location: login.php?error=1");
        exit();
    }
}
