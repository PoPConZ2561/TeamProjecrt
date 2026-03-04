<?php
session_start();
require_once("../includes/database.php");

// 1. ตรวจสอบสิทธิ์การเข้าถึง
if (!isset($_SESSION['user_id'])) {
    header("Location: ../public/login.php");
    exit();
}

if (!isset($_GET['action']) || !isset($_GET['user_id']) || !isset($_GET['event_id'])) {
    header("Location: manage.php");
    exit();
}

$conn = getConnection();
$action = $_GET['action'];
$target_user_id = $_GET['user_id'];
$event_id = $_GET['event_id'];
$owner_id = $_SESSION['user_id'];

// 2. Security Check: ตรวจสอบความเป็นเจ้าของกิจกรรม
$sql_check_owner = "SELECT user_id FROM events WHERE event_id = ? AND user_id = ?";
$stmt_check = $conn->prepare($sql_check_owner);
$stmt_check->bind_param("ii", $event_id, $owner_id);
$stmt_check->execute();
$res_check = $stmt_check->get_result();

if ($res_check->num_rows === 0) {
    die("Unauthorized access.");
}
$stmt_check->close();

// 3. กระบวนการตาม Action (ปรับปรุงส่วน reject)
switch ($action) {
    case 'approve':
        $sql = "UPDATE registrations SET status = 'approved' WHERE user_id = ? AND event_id = ?";
        break;

    case 'reject':
        // แก้ไขจาก DELETE เป็น UPDATE สถานะเป็น 'rejected'
        $sql = "UPDATE registrations SET status = 'rejected' WHERE user_id = ? AND event_id = ? AND status = 'pending'";
        break;

    case 'remove':
        // สำหรับการลบคนที่อนุมัติไปแล้ว อาจจะเลือกได้ว่าจะลบทิ้งเลยหรือเปลี่ยนเป็น rejected 
        // ในที่นี้ขอใช้เป็น DELETE เพื่อคืนโควต้าที่นั่งครับ
        $sql = "DELETE FROM registrations WHERE user_id = ? AND event_id = ?";
        break;

    default:
        header("Location: manage.php?event_id=$event_id");
        exit();
}

// 4. Execute
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $target_user_id, $event_id);

if ($stmt->execute()) {
    header("Location: /../templates/manage_event.php?event_id=$event_id&status=updated");
} else {
    header("Location: /../templates/manage_event.php?event_id=$event_id&status=error");
}

$stmt->close();
$conn->close();