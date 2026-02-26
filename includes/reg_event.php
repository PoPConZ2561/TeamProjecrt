<?php
session_start();
require("../includes/database.php");

$conn = getConnection();

/* =========================
   ต้อง login ก่อน
========================= */
if (!isset($_SESSION['user_id'])) {
    die("กรุณาเข้าสู่ระบบก่อน");
}

$user_id = $_GET['user_id'];
$event_id = $_GET['event_id'] ?? null;

if (!$event_id) {
    die("ไม่พบกิจกรรม");
}





/* =========================
   1. ตรวจสอบว่าสมัครแล้วหรือยัง
========================= */

$check = $conn->prepare("
SELECT * FROM registrations
WHERE user_id = ? AND event_id = ?
");

$check->bind_param("ii", $user_id, $event_id);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    die("คุณส่งคำขอสมัครแล้ว");
}





/* =========================
   2. เช็คจำนวนคนที่อนุมัติแล้ว
========================= */

$count = $conn->prepare("
SELECT COUNT(*) as total
FROM registrations
WHERE event_id = ?
AND status = 'approved'
");

$count->bind_param("i", $event_id);
$count->execute();
$total = $count->get_result()->fetch_assoc()['total'];

$limit = $conn->prepare("
SELECT max_participants
FROM events
WHERE event_id = ?
");

$limit->bind_param("i", $event_id);
$limit->execute();
$max = $limit->get_result()->fetch_assoc()['max_participants'];

if ($total >= $max && $max > 0) {
    die("กิจกรรมเต็มแล้ว");
}





/* =========================
   3. สมัคร (status = pending)
========================= */

$insert = $conn->prepare("
INSERT INTO registrations (user_id, event_id, status)
VALUES (?, ?, 'pending')
");

$insert->bind_param("ii", $user_id, $event_id);

if ($insert->execute()) {
    header("Location: /../templates/index.php");
    exit();
} else {
    echo "สมัครไม่สำเร็จ";
}