<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require("database.php");
    $conn = getConnection();

    $user_id = $_SESSION['user_id'] ?? '';
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $location = $_POST['location'] ?? '';
    $max_participants = $_POST['max_participants'] ?? '';
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? '';
    $img = $_FILES['img']['name'][0];

    $sql = "INSERT INTO events (user_id, title, description, location, max_participants, start_date, end_date, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isssiss", $user_id, $title, $description, $location, $max_participants, $start_date, $end_date);

    if (mysqli_stmt_execute($stmt)) {
        $event_id = mysqli_insert_id($conn);

        // ... หลัง insert event และได้ $event_id มาแล้ว ...

        $uploadDir = __DIR__ . "/../uploads/"; // ใช้ __DIR__ เพื่ออ้างอิงตำแหน่งปัจจุบันของไฟล์ PHP
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (!isset($_FILES['img'])) {
            die("Error: ไม่พบข้อมูล ['img'] ตรวจสอบ enctype ในฟอร์ม HTML");
        }

        foreach ($_FILES['img']['name'] as $key => $name) {
            if ($_FILES['img']['error'][$key] !== 0) {
                echo "ไฟล์ $name มีปัญหา Error Code: " . $_FILES['img']['error'][$key] . "<br>";
                continue;
            }

            $tmpName = $_FILES['img']['tmp_name'][$key];
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            $newName = bin2hex(random_bytes(8)) . "_" . time() . "." . $extension;
            $uploadPath = $uploadDir . $newName;

            // บันทึกลง DB เฉพาะชื่อไฟล์ หรือ Path ที่ต้องการเอาไปแสดงผล
            $dbPath = "uploads/" . $newName;

            if (move_uploaded_file($tmpName, $uploadPath)) {
                $stmt2 = $conn->prepare("INSERT INTO event_images (event_id, image_path) VALUES (?, ?)");
                $stmt2->bind_param("is", $event_id, $dbPath);
                if ($stmt2->execute()) {
                    echo "ไฟล์ $name อัปโหลดสำเร็จ!<br>";
                    header("Location: /../templates/index.php");
                } else {
                    echo "DB Error: " . $stmt2->error . "<br>";
                }
            } else {
                echo "Error: ไม่สามารถย้ายไฟล์ไปที่ $uploadPath ได้ (ตรวจสอบ Folder Permissions)<br>";
                // ลองเช็คว่า Path ที่มันพยายามจะไปมีอยู่จริงไหม
                echo "Target Path: " . realpath($uploadDir) . "<br>";
            }
        }

        // 2. จัดการเรื่อง Folder
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // สร้าง folder ถ้ายังไม่มี
        }

        // 3. Loop อัปโหลดรูปภาพ
        if (!empty($_FILES['img']['name'][0])) {
            foreach ($_FILES['img']['name'] as $key => $name) {
                if ($_FILES['img']['error'][$key] === 0) {

                    $tmpName = $_FILES['img']['tmp_name'][$key];
                    $extension = pathinfo($name, PATHINFO_EXTENSION);
                    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

                    // ตรวจสอบนามสกุลไฟล์
                    if (in_array(strtolower($extension), $allowed)) {
                        // สร้างชื่อใหม่ที่ไม่มีทางซ้ำ
                        $newName = bin2hex(random_bytes(8)) . "_" . time() . "." . $extension;
                        $uploadPath = $uploadDir . $newName;

                        if (move_uploaded_file($tmpName, $uploadPath)) {
                            $stmt2 = $conn->prepare("INSERT INTO event_images (event_id, image_path) VALUES (?, ?)");
                            $stmt2->bind_param("is", $event_id, $uploadPath);
                            $stmt2->execute();
                        }
                    } else {
                        echo "ไฟล์ประเภท $extension ไม่ได้รับอนุญาต";
                    }
                }
            }
        }
        echo "สร้างกิจกรรมสำเร็จ!";
    }
}
