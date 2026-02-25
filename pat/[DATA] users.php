<!-- ทำรอไว้เฉยๆ ไปทำให้เสร็จด้วย -->
<?php
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $POST['phone_number'];
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];

    if(!isset($_SESSION['users'])){
        $_SESSION['users'] = [];
    }

    array_push($_SESSION['users'], [
        'name' => $name,
        'email' => $email,
        'phone_number' => $phone_number,
        'birthdate' => $birthdate,
        'gender' => $gender,
        'password' => $password
    ]);

    header("Location: index.php");
    exit();
}
?>
