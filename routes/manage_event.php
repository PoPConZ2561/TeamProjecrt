<?php

// 1. เช็คการล็อกอิน
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once("../includes/database.php"); // ปรับ path ให้ตรงกับโครงสร้างของคุณ
$conn = getConnection();
$user_id = $_SESSION["user_id"];
$my_events = [];
// ==========================================
// 2. ดึงรายชื่อกิจกรรม "ทั้งหมด" ของผู้ใช้นี้ (เพื่อแสดงแถบซ้าย)
// ==========================================
$sql_my_events = "SELECT e.*, 
                 (SELECT image_path FROM event_images WHERE event_id = e.event_id LIMIT 1) AS image_path
                 FROM events e 
                 WHERE e.user_id = ? 
                 ORDER BY e.created_at DESC";

$stmt = $conn->prepare($sql_my_events);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result_events = $stmt->get_result();

while ($row = $result_events->fetch_assoc()) {
    $my_events[] = $row;
}
$stmt->close();

// ==========================================
// 3. กำหนดว่าจะโชว์ข้อมูลกิจกรรมไหนทางขวามือ (Selected Event)
// ==========================================
$selected_event_id = null;
$selected_event = null;

if (count($my_events) > 0) {
    // ถ้ามีการส่ง ?event_id= มา (คลิกมาจากหน้าโชว์กิจกรรม หรือคลิกจากเมนูซ้ายมือ)
    if (isset($_GET['event_id']) && !empty($_GET['event_id'])) {
        $selected_event_id = $_GET['event_id'];
        
        // ค้นหาข้อมูลกิจกรรมที่ตรงกับ ID ที่ส่งมา จากใน Array
        foreach ($my_events as $event) {
            if ($event['event_id'] == $selected_event_id) {
                $selected_event = $event;
                break;
            }
        }
    } 
    
    // ถ้าไม่มีการส่งค่ามา (มาจาก Header) หรือส่งค่ามั่วมา ให้เลือก "กิจกรรมล่าสุด (อันแรก)" อัตโนมัติ
    if ($selected_event == null) {
        $selected_event = $my_events[0];
        $selected_event_id = $selected_event['event_id'];
    }
}

// ==========================================
// 4. ดึงรายชื่อผู้เข้าร่วม เฉพาะกิจกรรมที่ถูกเลือกอยู่
// ==========================================
$pending_users = [];
$approved_users = [];

if ($selected_event_id != null) {
    $sql_participants = "SELECT u.user_id, u.name, u.email, u.phone_number, r.status 
                         FROM registrations r
                         JOIN users u ON r.user_id = u.user_id
                         WHERE r.event_id = ?";
                         
    $stmt2 = $conn->prepare($sql_participants);
    $stmt2->bind_param("i", $selected_event_id);
    $stmt2->execute();
    $res_participants = $stmt2->get_result();
    
    // แยกคนตามสถานะ เพื่อเอาไปวาด UI คนละกล่อง
    while ($p = $res_participants->fetch_assoc()) {
        if ($p['status'] == 'pending') {
            $pending_users[] = $p;
        } elseif ($p['status'] == 'approved' || $p['status'] == 'attended') { // นับทั้ง approved และ attended เป็นสมาชิกที่เข้าร่วมแล้ว
            $approved_users[] = $p;
        }
    }
    $stmt2->close();
}
?>