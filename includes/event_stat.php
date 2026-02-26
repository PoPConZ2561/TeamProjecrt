<?php 

require("../includes/database.php");
$conn = getConnection();

if (!isset($_SESSION['user_id'])) {
    die("กรุณาเข้าสู่ระบบก่อน");
}

$event_id = $_GET['event_id'] ?? null;
if (!$event_id) {
    die("ไม่พบกิจกรรม");
}


$stmt = $conn->prepare("
SELECT 
    e.title,
    e.location,
    e.start_date,
    e.end_date,
    e.max_participants,

    COUNT(r.reg_id) AS total_registered,

    SUM(CASE WHEN r.status = 'pending' THEN 1 ELSE 0 END) AS total_pending,
    SUM(CASE WHEN r.status = 'approved' THEN 1 ELSE 0 END) AS total_approved,
    SUM(CASE WHEN r.status = 'attended' THEN 1 ELSE 0 END) AS total_attended,

    SUM(CASE WHEN u.gender = 'ชาย' THEN 1 ELSE 0 END) AS total_male,
    SUM(CASE WHEN u.gender = 'หญิง' THEN 1 ELSE 0 END) AS total_female,

    ROUND(AVG(TIMESTAMPDIFF(YEAR, u.birthdate, CURDATE())),1) AS avg_age

FROM events e
LEFT JOIN registrations r ON e.event_id = r.event_id
LEFT JOIN users u ON r.user_id = u.user_id

WHERE e.event_id = ?

GROUP BY e.event_id
");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();
$stats = $result->fetch_assoc();
$stmt->close();

$total_registered = $stats['total_registered'] ?? 0;
$total_pending = $stats['total_pending'] ?? 0;
$total_approved = $stats['total_approved'] ?? 0;
$total_attended = $stats['total_attended'] ?? 0;

$title = $stats['title'] ?? 'N/A';
$location = $stats['location'] ?? 'N/A';
$start_date = $stats['start_date'] ?? 'N/A';
$end_date = $stats['end_date'] ?? 'N/A';
$max_participants = $stats['max_participants'] ?? 'N/A';

$total_male = $stats['total_male'] ?? 0;
$total_female = $stats['total_female'] ?? 0;
$avg_age = $stats['avg_age'] ?? 0;
