<?php
session_start();
require("../includes/database.php");

$conn = getConnection();

/* =========================
   ต้อง login ก่อน
========================= */
if (!isset($_SESSION['user_id'])) {
    header("Location: ../templates/login.php");
    exit();
}

// 🌟 ความปลอดภัย: ใช้ user_id จาก Session ป้องกันคนเปลี่ยน URL แอบอ้างเป็นคนอื่น
$user_id = $_SESSION['user_id'];
$event_id = $_GET['event_id'] ?? null;

if (!$event_id) {
    header("Location: ../templates/index.php?reg_status=error_no_event");
    exit();
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
    $check->close();
    header("Location: ../templates/index.php?reg_status=already_registered");
    exit();
}
$check->close();

/* =========================
   2. เช็คจำนวนคนที่อนุมัติแล้ว
========================= */
$count = $conn->prepare("
SELECT COUNT(*) as total
FROM registrations
WHERE event_id = ?
AND status IN ('approved', 'attended')
");

$count->bind_param("i", $event_id);
$count->execute();
$total = $count->get_result()->fetch_assoc()['total'];
$count->close();

$limit = $conn->prepare("
SELECT max_participants
FROM events
WHERE event_id = ?
");

$limit->bind_param("i", $event_id);
$limit->execute();
$max = $limit->get_result()->fetch_assoc()['max_participants'];
$limit->close();

if ($total >= $max && $max > 0) {
    header("Location: ../templates/index.php?reg_status=full");
    exit();
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
    $insert->close();
    header("Location: ../templates/index.php?reg_status=success");
    exit();
} else {
    $insert->close();
    header("Location: ../templates/index.php?reg_status=error");
    exit();
}
?>