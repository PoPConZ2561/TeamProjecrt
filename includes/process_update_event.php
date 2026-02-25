<?php
session_start();
require_once("../includes/database.php"); // ตรวจสอบ path ให้ถูกต้องตามโครงสร้างของคุณ

// 1. เช็คการล็อกอินและความปลอดภัย
if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit();
}

$conn = getConnection();
$user_id = $_SESSION['user_id'];
$event_id = $_POST['event_id'];

// ตรวจสอบว่าเป็นเจ้าของกิจกรรมจริงหรือไม่ก่อนให้อัปเดต
$check_owner_sql = "SELECT event_id FROM events WHERE event_id = ? AND user_id = ?";
$stmt = $conn->prepare($check_owner_sql);
$stmt->bind_param("ii", $event_id, $user_id);
$stmt->execute();
if ($stmt->get_result()->num_rows === 0) {
    die("คุณไม่มีสิทธิ์แก้ไขกิจกรรมนี้");
}
$stmt->close();

// 2. รับค่าจากฟอร์ม
$title = $_POST['title'];
$max_participants = $_POST['max_participants'];
$location = $_POST['location'];
$description = $_POST['description'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

// 3. อัปเดตข้อมูลพื้นฐานในตาราง events [cite: 16, 17]
$sql_update = "UPDATE events SET 
                title = ?, 
                max_participants = ?, 
                location = ?, 
                description = ?, 
                start_date = ?, 
                end_date = ? 
              WHERE event_id = ? AND user_id = ?";

$stmt = $conn->prepare($sql_update);
$stmt->bind_param("sissssii", $title, $max_participants, $location, $description, $start_date, $end_date, $event_id, $user_id);

if ($stmt->execute()) {
    
    // 4. จัดการรูปภาพ (ถ้ามีการอัปโหลดใหม่) [cite: 22, 23]
    if (!empty($_FILES['pictures']['name'][0])) {
        $upload_dir = "../uploads/events/"; // อย่าลืมสร้างโฟลเดอร์นี้และตั้ง permission
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // ในตัวอย่างนี้จะจัดการแบบ 1 กิจกรรมต่อ 1 รูปหลัก (ตาม UI ที่ส่งมา)
        $file_name = time() . "_" . basename($_FILES['pictures']['name'][0]);
        $target_path = $upload_dir . $file_name;
        $db_path = "uploads/events/" . $file_name;

        if (move_uploaded_file($_FILES['pictures']['tmp_name'][0], $target_path)) {
            // ลบรูปเก่าออกก่อน (ทางเลือก) หรืออัปเดตทับ
            // ตรวจสอบว่ามีข้อมูลรูปภาพเดิมใน event_images หรือยัง
            $check_img = "SELECT image_id FROM event_images WHERE event_id = ?";
            $st_img = $conn->prepare($check_img);
            $st_img->bind_param("i", $event_id);
            $st_img->execute();
            $res_img = $st_img->get_result();

            if ($res_img->num_rows > 0) {
                // มีรูปเดิม -> อัปเดต path
                $sql_img = "UPDATE event_images SET image_path = ? WHERE event_id = ?";
                $st_up = $conn->prepare($sql_img);
                $st_up->bind_param("si", $db_path, $event_id);
                $st_up->execute();
            } else {
                // ยังไม่มีรูป -> เพิ่มใหม่
                $sql_img = "INSERT INTO event_images (event_id, image_path) VALUES (?, ?)";
                $st_in = $conn->prepare($sql_img);
                $st_in->bind_param("is", $event_id, $db_path);
                $st_in->execute();
            }
        }
    }

    // อัปเดตสำเร็จ กลับไปหน้าจัดการพร้อมส่ง event_id เดิมกลับไป
    header("Location: manage_event.php?event_id=" . $event_id . "&status=success");
} else {
    echo "เกิดข้อผิดพลาด: " . $conn->error;
}

$stmt->close();
$conn->close();
?>