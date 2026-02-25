<?php
session_start();
require("database.php");
$conn = getConnection();

$id = $_SESSION["user_id"];

// --- ส่วนที่ 1: ดึงข้อมูลกิจกรรมทั้งหมดของผู้ใช้ ---
$sqlEventdata = "SELECT e.*, i.image_path 
        FROM events e 
        LEFT JOIN event_images i ON e.event_id = i.event_id 
        WHERE e.user_id = ? 
        GROUP BY e.event_id"; 

$stmt = $conn->prepare($sqlEventdata);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// ดึงข้อมูลกิจกรรมทั้งหมดมาเก็บไว้ใน Array ก่อน เพื่อป้องกัน Commands out of sync
$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = $row;
}
$stmt->close(); // ปิด statement แรกทันทีเมื่อใช้งานเสร็จ 

$_SESSION["myevent"] = $events;

// ทดสอบแสดงผลข้อมูลกิจกรรม
foreach ($events as $event) {
    echo "กิจกรรม: " . $event['title'] . "<br>";
}

// --- ส่วนที่ 2: ดึงรายชื่อคนเข้าร่วม (ตัวอย่างสำหรับกิจกรรมแรก) ---
if (!empty($events)) {
    // สมมติว่าต้องการดูคนเข้าร่วมของกิจกรรมแรกที่ดึงมาได้
    $event_id = $events[0]['event_id']; 

    $sqlUserFormEvent = "SELECT u.username, u.email, u.phone_number, r.status 
            FROM registrations r
            JOIN users u ON r.user_id = u.user_id
            WHERE r.event_id = ? 
            AND r.status = 'approved'";

    $stmt1 = $conn->prepare($sqlUserFormEvent);
    $stmt1->bind_param("i", $event_id);
    $stmt1->execute();
    $result1 = $stmt1->get_result(); // เปลี่ยนเป็น $stmt1 ให้ถูกต้อง 

    echo "<h3>รายชื่อผู้เข้าร่วม:</h3>";
    while ($row1 = $result1->fetch_assoc()) {
        echo $row1['username'] . " - " . $row1['email'] . "<br>";
    }
    $stmt1->close();
}


?>