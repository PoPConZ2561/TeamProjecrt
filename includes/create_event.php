<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require("database.php");
    $conn = getConnection();

    $user_id = $_SESSION['user_id'] ?? '';
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $location = $_POST['location'] ?? '';
    $max_participants = $_POST['max_participants'] ?? 0;
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? '';

    // 1. บันทึกข้อมูลกิจกรรมลง DB หลักก่อน
    $sql = "INSERT INTO events (user_id, title, description, location, max_participants, start_date, end_date, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isssiss", $user_id, $title, $description, $location, $max_participants, $start_date, $end_date);

    if (mysqli_stmt_execute($stmt)) {
        // ได้ ID ของกิจกรรมที่เพิ่งสร้างเสร็จ
        $event_id = mysqli_insert_id($conn);

        // 2. จัดการอัปโหลดรูปภาพ (เขียนรวมให้เหลือ Loop เดียว ป้องกันบั๊ก)
        $uploadDir = __DIR__ . "/../public/uploads/"; 
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (isset($_FILES['img']) && !empty($_FILES['img']['name'][0])) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            foreach ($_FILES['img']['name'] as $key => $name) {
                if ($_FILES['img']['error'][$key] === 0) {
                    $tmpName = $_FILES['img']['tmp_name'][$key];
                    $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));

                    // ตรวจสอบนามสกุลไฟล์
                    if (in_array($extension, $allowed)) {
                        // สุ่มชื่อไฟล์ใหม่กันไฟล์ซ้ำทับกัน
                        $newName = bin2hex(random_bytes(8)) . "_" . time() . "." . $extension;
                        $uploadPath = $uploadDir . $newName;
                        
                        // เอาไว้เซฟลง DB เพื่อให้หน้าเว็บเรียกใช้ได้ง่ายๆ
                        $dbPath = "uploads/" . $newName;

                        if (move_uploaded_file($tmpName, $uploadPath)) {
                            // เซฟรูปลงตาราง event_images
                            $stmt2 = $conn->prepare("INSERT INTO event_images (event_id, image_path) VALUES (?, ?)");
                            $stmt2->bind_param("is", $event_id, $dbPath);
                            $stmt2->execute();
                        }
                    }
                }
            }
        }

        // 🌟 3. คืนค่าสถานะความสำเร็จกลับไปให้หน้าสร้างกิจกรรม เพื่อให้โชว์ SweetAlert
        header("Location: ../templates/create_event.php?status=success");
        exit();

    } else {
        // 🌟 กรณีเกิดข้อผิดพลาด
        header("Location: ../templates/create_event.php?status=error");
        exit();
    }
}