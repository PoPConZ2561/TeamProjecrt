<?php
session_start();

// 1. ตรวจสอบการล็อกอิน
if (!isset($_SESSION['user_id'])) {
    header("Location: ../templates/login.php");
    exit();
}

require_once("../includes/database.php");
$conn = getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 2. รับค่าจากฟอร์ม
    $event_id = $_POST['event_id'];
    $title = $_POST['title'];
    $max_participants = $_POST['max_participants'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $user_id = $_SESSION['user_id'];

    // 3. ตรวจสอบความปลอดภัย: เช็คว่าเป็นเจ้าของกิจกรรมนี้จริงๆ หรือไม่
    $check_owner = $conn->prepare("SELECT user_id FROM events WHERE event_id = ?");
    $check_owner->bind_param("i", $event_id);
    $check_owner->execute();
    $res = $check_owner->get_result();

    // ถ้าไม่ใช่เจ้าของ หรือไม่มีกิจกรรมนี้ ให้เด้งออกไปเลยพร้อมแจ้ง Error
    if ($res->num_rows === 0 || $res->fetch_assoc()['user_id'] != $user_id) {
        header("Location: ../templates/manage_event.php?event_id=$event_id&status=error");
        exit();
    }
    $check_owner->close();

    // 4. อัปเดตข้อมูล Text ลงฐานข้อมูล
    $sql = "UPDATE events SET title=?, max_participants=?, location=?, description=?, start_date=?, end_date=? WHERE event_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sissssi", $title, $max_participants, $location, $description, $start_date, $end_date, $event_id);

    if ($stmt->execute()) {
        // 5. จัดการรูปภาพ (เพิ่มรูปใหม่เข้าไป โดยไม่ลบรูปเก่า)
        if (isset($_FILES['pictures']) && !empty($_FILES['pictures']['name'][0])) {
            $uploadDir = __DIR__ . "/../public/uploads/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            foreach ($_FILES['pictures']['name'] as $key => $name) {
                if ($_FILES['pictures']['error'][$key] === 0) {
                    $tmpName = $_FILES['pictures']['tmp_name'][$key];
                    $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));

                    if (in_array($extension, $allowed)) {
                        // สุ่มชื่อไฟล์ใหม่
                        $newName = bin2hex(random_bytes(8)) . "_" . time() . "." . $extension;
                        $uploadPath = $uploadDir . $newName;
                        $dbPath = "uploads/" . $newName; // Path ที่จะเก็บใน DB

                        // ย้ายไฟล์เข้าโฟลเดอร์ public/uploads/
                        if (move_uploaded_file($tmpName, $uploadPath)) {
                            // บันทึก Path รูปใหม่ลง DB (เพิ่มเข้าไปใหม่)
                            $stmt2 = $conn->prepare("INSERT INTO event_images (event_id, image_path) VALUES (?, ?)");
                            $stmt2->bind_param("is", $event_id, $dbPath);
                            $stmt2->execute();
                            $stmt2->close();
                        }
                    }
                }
            }
        }

        // 5. ลบรูปภาพที่ผู้ใช้กดลบ
        if (!empty($_POST['deleted_images'])) {
            foreach ($_POST['deleted_images'] as $image_id) {

                // ดึง path รูปจาก DB
                $stmtImg = $conn->prepare("SELECT image_path FROM event_images WHERE image_id=? AND event_id=?");
                $stmtImg->bind_param("ii", $image_id, $event_id);
                $stmtImg->execute();
                $resultImg = $stmtImg->get_result();

                if ($img = $resultImg->fetch_assoc()) {

                    $filePath = __DIR__ . "/../public/" . $img['image_path'];

                    // ลบไฟล์จริงใน server
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }

                    // ลบ record ใน database
                    $stmtDel = $conn->prepare("DELETE FROM event_images WHERE image_id=?");
                    $stmtDel->bind_param("i", $image_id);
                    $stmtDel->execute();
                    $stmtDel->close();
                }

                $stmtImg->close();
            }
        }

        // 6. อัปเดตสำเร็จ ส่ง Parameter status=success กลับไปให้ SweetAlert แสดงผล
        header("Location: ../templates/manage_event.php?event_id=$event_id&status=success");
        exit();
    } else {
        // อัปเดตไม่สำเร็จ ส่งสถานะ error กลับไป
        header("Location: ../templates/manage_event.php?event_id=$event_id&status=error");
        exit();
    }
} else {
    // ถ้าไม่ได้เข้ามาด้วย POST ให้เด้งกลับ
    header("Location: ../templates/index.php");
    exit();
}
