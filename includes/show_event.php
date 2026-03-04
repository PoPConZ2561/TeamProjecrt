<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// เช็ค path ของ database.php ให้ถูกต้อง
require_once("database.php");
$conn = getConnection();

$current_user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

// รับค่าจาก AJAX / GET
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'latest'; 

// 🌟 ตั้งค่า Default Ownership: ถ้าล็อกอินแล้วให้เป็น 'not_mine' ถ้ายังไม่ล็อกอินเป็น 'all'
$default_ownership = ($current_user_id != 0) ? 'not_mine' : 'all';
$ownership = (isset($_GET['ownership']) && $_GET['ownership'] !== '') ? $_GET['ownership'] : $default_ownership;

// ---------------------------------------------
// สร้าง Dynamic SQL Query 
// ---------------------------------------------
$sql = "SELECT e.*, 
        (SELECT COUNT(*) FROM registrations WHERE event_id = e.event_id AND status IN ('approved','attended')) AS current_participants,
        (SELECT status FROM registrations WHERE event_id = e.event_id AND user_id = ?) AS status
        FROM events e ";

$conditions = [];
$params = [$current_user_id];
$types = "i";

// 1. ค้นหาข้อความ
if (!empty($search)) {
    $conditions[] = "(e.title LIKE ? OR e.description LIKE ? OR e.location LIKE ?)";
    $search_param = "%" . $search . "%";
    array_push($params, $search_param, $search_param, $search_param);
    $types .= "sss";
}

// 2. วันเริ่มต้น
if (!empty($start_date)) {
    $conditions[] = "e.start_date >= ?";
    $params[] = $start_date . " 00:00:00";
    $types .= "s";
}

// 3. วันสิ้นสุด
if (!empty($end_date)) {
    $conditions[] = "e.end_date <= ?";
    $params[] = $end_date . " 23:59:59";
    $types .= "s";
}

// 🌟 4. ตัวกรองความเป็นเจ้าของกิจกรรม
if ($current_user_id != 0) {
    if ($ownership === 'not_mine') {
        $conditions[] = "e.user_id != ?"; // ค้นหาอันที่ user_id ไม่ตรงกับคนที่ล็อกอิน (ซ่อนของตัวเอง)
        $params[] = $current_user_id;
        $types .= "i";
    } elseif ($ownership === 'mine') {
        $conditions[] = "e.user_id = ?"; // ค้นหาเฉพาะอันที่เป็นของตัวเอง
        $params[] = $current_user_id;
        $types .= "i";
    }
}

// นำเงื่อนไข WHERE มารวมกัน
if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

// การเรียงลำดับ
if ($sort_by === 'registered_first') {
    $sql .= " ORDER BY CASE WHEN status IN ('pending', 'approved', 'attended') THEN 1 ELSE 2 END ASC, e.created_at DESC";
} elseif ($sort_by === 'upcoming_first') {
    $sql .= " ORDER BY e.start_date ASC";
} elseif ($sort_by === 'popular') {
    $sql .= " ORDER BY current_participants DESC, e.created_at DESC";
} elseif ($sort_by === 'seats_available') {
    $sql .= " ORDER BY CASE WHEN e.max_participants = 0 THEN 999999 ELSE (e.max_participants - current_participants) END DESC";
} elseif ($sort_by === 'title_asc') {
    $sql .= " ORDER BY e.title ASC";
} else {
    $sql .= " ORDER BY e.created_at DESC";
}

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>