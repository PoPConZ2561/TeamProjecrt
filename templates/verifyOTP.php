<?php
require_once __DIR__ . "/../includes/verify.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
</head>

<body class="bg-slate-50 flex items-center justify-center min-h-screen">
    <div class="absolute top-4 left-4">
        <a href="/../templates/index.php" class="bg-bule-500">ย้อนกลับ</a>
    </div>
    <form method="POST" class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-sm" action="">
        <h1 class="text-xl font-bold mb-4">กรอก OTP</h1>
        <input type="text" name="otp" class="w-full border p-3 rounded-xl mb-4 outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Enter OTP" required>
        <button type="submit" name="button_click" class="w-full bg-indigo-500 text-white p-3 rounded-xl">ส่ง OTP</button>
    </from>
    <p class="flex items-center justify-center">
        <?php if($verify == "approved"){
            echo "ยืนยันสำเร็จ";
        } else if($verify == "pending" && $_SERVER['REQUEST_METHOD'] === 'POST') {
            echo "OTP ไม่ถูกต้อง";
        } ?>
    </p>
</body>

</html>