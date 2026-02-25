<?php
session_start();
require("database.php");
$conn = getConnection();

$id = $_SESSION["user_id"];

$sqlEventdata = "SELECT e.*, i.image_path 
        FROM events e 
        LEFT JOIN event_images i ON e.event_id = i.event_id 
        WHERE e.user_id = ? 
        GROUP BY e.event_id"; // Group ไว้เพื่อให้ 1 กิจกรรมโชว์แค่ 1 แถว

$stmt = $conn->prepare($sqlEventdata);
$stmt->bind_param("i", $id); // "i" หมายถึง integer
$stmt->execute();
$result = $stmt->get_result();

$row = mysqli_fetch_assoc($result);
$n = mysqli_num_rows($result);

//ข้อมูลกิจกรรม
for($i = 0; $i<$n; $i++){
    print_r($row);
}

$sqlUserFormEvent = "SELECT u.username, u.email, u.phone_number, r.status 
        FROM registrations r
        JOIN users u ON r.user_id = u.user_id
        WHERE r.event_id = ? 
        AND r.status = 'approved'";

$stmt = $conn->prepare($sqlUserFormEvent);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo $row['username'] . " - " . $row['email'];
}

?>