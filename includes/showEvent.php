<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// เช็ค path ของ database.php ให้ถูกต้องด้วยนะครับ (ถ้า database.php อยู่โฟลเดอร์เดียวกันให้ใช้ไฟล์นี้)
require_once("database.php");
$conn = getConnection();

$current_user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

// รับค่าจาก AJAX / GET (รับค่าค้นหา, วันที่, และการเรียงลำดับ)
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'latest'; // รับค่าการจัดเรียง

// ---------------------------------------------
// สร้าง Dynamic SQL Query
// ---------------------------------------------
$sql = "SELECT e.*, 
        (SELECT image_path FROM event_images WHERE event_id = e.event_id LIMIT 1) AS image_path,
        (SELECT COUNT(*) FROM registrations WHERE event_id = e.event_id AND status IN ('approved','attended')) AS current_participants,
        (SELECT status FROM registrations WHERE event_id = e.event_id AND user_id = ?) AS status
        FROM events e ";

$conditions = [];
$params = [$current_user_id];
$types = "i";

// 1. ถ้ามีคำค้นหา (ค้นหาจากชื่อ, รายละเอียด, และสถานที่)
if (!empty($search)) {
    $conditions[] = "(e.title LIKE ? OR e.description LIKE ? OR e.location LIKE ?)";
    $search_param = "%" . $search . "%";
    array_push($params, $search_param, $search_param, $search_param);
    $types .= "sss";
}
// 2. ถ้ามีวันเริ่มต้น
if (!empty($start_date)) {
    $conditions[] = "e.start_date >= ?";
    $params[] = $start_date . " 00:00:00";
    $types .= "s";
}
// 3. ถ้ามีวันสิ้นสุด
if (!empty($end_date)) {
    $conditions[] = "e.end_date <= ?";
    $params[] = $end_date . " 23:59:59";
    $types .= "s";
}

// เอาเงื่อนไข WHERE มารวมกัน
if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

// ---------------------------------------------
// จัดการเงื่อนไขการเรียงลำดับ (ORDER BY)
// ---------------------------------------------
if ($sort_by === 'registered_first') {
    // ดันคนที่ลงทะเบียนแล้ว (pending, approved, attended) ขึ้นบนสุด
    $sql .= " ORDER BY CASE WHEN status IN ('pending', 'approved', 'attended') THEN 1 ELSE 2 END ASC, e.created_at DESC";

} elseif ($sort_by === 'upcoming_first') {
    // วันที่จัดงานใกล้ถึงที่สุด
    $sql .= " ORDER BY e.start_date ASC";

} elseif ($sort_by === 'popular') {
    // ยอดฮิต: เรียงตามจำนวนคนเข้าร่วมจากมากไปน้อย
    $sql .= " ORDER BY current_participants DESC, e.created_at DESC";

} elseif ($sort_by === 'seats_available') {
    // ที่นั่งเหลือเยอะสุด (ถ้ารับไม่จำกัด e.max_participants=0 ให้อยู่บนสุด)
    $sql .= " ORDER BY CASE WHEN e.max_participants = 0 THEN 999999 ELSE (e.max_participants - current_participants) END DESC";

} elseif ($sort_by === 'title_asc') {
    // เรียงตามตัวอักษร
    $sql .= " ORDER BY e.title ASC";

} else {
    // latest (ค่าเริ่มต้น): สร้างใหม่ล่าสุด
    $sql .= " ORDER BY e.created_at DESC";
}

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!-- ========================================== -->
<!-- ส่วนแสดงผล HTML -->
<!-- ========================================== -->
<?php if ($result && $result->num_rows > 0): ?>
    <div class="flex flex-col gap-6 w-full pb-10">
    <?php while ($row = $result->fetch_assoc()) : ?>
        
        <?php
            // ตรรกะเช็คสถานะปุ่ม
            $now = time(); 
            $start_date_ts = strtotime($row["start_date"]); 
            $end_date_ts = strtotime($row["end_date"]);  
            
            $max_participants = $row["max_participants"];
            $current_participants = $row["current_participants"];
            $status = $row["status"]; 
            $event_owner_id = $row["user_id"]; 

            $btn_text = "";
            $btn_class = "";
            $btn_link = "";
            $is_disabled = true;

            if ($current_user_id == $event_owner_id && $current_user_id != 0) {
                $btn_text = "จัดการกิจกรรม (ของคุณ)";
                $btn_class = "bg-purple-600 hover:bg-purple-700 text-white shadow-sm hover:-translate-y-0.5";
                $btn_link = "manage_event.php?event_id=" . $row['event_id']; 
                $is_disabled = false;
            } elseif ($now > $end_date_ts) {
                $btn_text = "กิจกรรมสิ้นสุดแล้ว";
                $btn_class = "bg-gray-200 text-gray-500 cursor-not-allowed";
            } elseif ($status === 'rejected') {
                $btn_text = "ไม่สามารถเข้าร่วมได้";
                $btn_class = "bg-red-50 text-red-500 border border-red-200 cursor-not-allowed";
            } elseif ($status === 'pending') {
                $btn_text = "รอดำเนินการตรวจสอบ";
                $btn_class = "bg-amber-100 text-amber-700 border border-amber-200 cursor-not-allowed";
            } elseif ($status === 'approved') {
                if ($now >= $start_date_ts && $now <= $end_date_ts) {
                    $btn_text = "เข้าร่วมกิจกรรม";
                    $btn_class = "bg-blue-600 hover:bg-blue-700 text-white shadow-md hover:-translate-y-0.5";
                    $btn_link = "../includes/OTP.php?event_id=" . $row['event_id']; // แก้ไข slash ให้ถูกต้อง
                    $is_disabled = false;
                } else {
                    $btn_text = "สมัครเรียบร้อยแล้ว";
                    $btn_class = "bg-emerald-50 text-emerald-600 border border-emerald-200 cursor-not-allowed";
                }
            } elseif($status === 'attended') {
                $btn_text = "เข้าร่วมกิจกรรมแล้ว";
                $btn_class = "bg-green-100 text-green-700 border border-green-200 cursor-not-allowed";
            } elseif ($now >= $start_date_ts) {
                $btn_text = "กิจกรรมกำลังดำเนินการ";
                $btn_class = "bg-gray-100 text-gray-500 cursor-not-allowed";
            } elseif ($max_participants > 0 && $current_participants >= $max_participants) {
                $btn_text = "ที่นั่งเต็มแล้ว";
                $btn_class = "bg-red-500 text-white shadow-sm cursor-not-allowed";
            } elseif ($current_user_id == 0) {
                $btn_text = "เข้าสู่ระบบเพื่อสมัคร";
                $btn_class = "bg-blue-50 text-blue-600 border border-blue-200 hover:bg-blue-100 transition-colors";
                $btn_link = "login.php";
                $is_disabled = false;
            } else {
                $btn_text = "สมัครเข้าร่วมกิจกรรม";
                $btn_class = "bg-green-600 hover:bg-green-700 text-white shadow-md hover:-translate-y-0.5";
                $btn_link = "../includes/reg_event.php?user_id={$current_user_id}&event_id={$row['event_id']}";
                $is_disabled = false;
            }
        ?>

        <div class="group flex flex-col md:flex-row w-full bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
            <!-- รูปภาพ -->
            <div class="relative w-full md:w-[40%] h-[200px] md:h-auto overflow-hidden bg-gray-100 shrink-0">
                <?php if (!empty($row['image_path'])): ?>
                    <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                        src="../<?php echo htmlspecialchars($row['image_path']); ?>" alt="Event Image">
                <?php else: ?>
                    <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-300">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                <?php endif; ?>
            </div>

            <!-- ข้อมูลกิจกรรม -->
            <div class="flex flex-col flex-grow p-6 lg:p-8">
                
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-semibold px-2 py-1 bg-orange-50 text-orange-600 rounded-md">
                        กิจกรรม
                    </span>
                    <div class="flex items-center text-sm text-gray-500 gap-1.5 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span>ผู้เข้าร่วม: <?php echo $current_participants; ?> / <?php echo $max_participants > 0 ? $max_participants : 'ไม่จำกัด'; ?></span>
                    </div>
                </div>

                <h1 class="text-xl lg:text-2xl font-bold text-gray-900 mb-2 line-clamp-2 leading-tight group-hover:text-blue-600 transition-colors">
                    <?php echo htmlspecialchars($row["title"]) ?>
                </h1>
                
                <div class="flex items-center gap-1.5 text-sm text-gray-500 mb-3">
                    <svg class="w-4 h-4 text-red-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span class="line-clamp-1"><?php echo htmlspecialchars($row["location"]) ?></span>
                </div>

                <p class="text-gray-500 text-sm line-clamp-2 mb-4 leading-relaxed">
                    <?php echo htmlspecialchars($row["description"]) ?>
                </p>

                <div class="flex flex-col gap-2 mt-auto mb-6">
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>เริ่มต้น: <?php echo date('d/m/Y H:i', $start_date_ts); ?> น.</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 mr-2 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>สิ้นสุด: <?php echo date('d/m/Y H:i', $end_date_ts); ?> น.</span>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <?php if ($is_disabled): ?>
                        <button disabled class="w-full sm:w-auto px-6 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 <?php echo $btn_class; ?>">
                            <?php echo $btn_text; ?>
                        </button>
                    <?php else: ?>
                        <a href="<?php echo $btn_link; ?>" class="w-full sm:w-auto px-6 py-2.5 rounded-lg text-sm font-semibold text-center transition-all duration-200 <?php echo $btn_class; ?>">
                            <?php echo $btn_text; ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
    </div>

<?php else: ?>
    <!-- กรณีไม่พบข้อมูล -->
    <div class="flex flex-col items-center justify-center w-full min-h-[300px] bg-white rounded-2xl border border-gray-100 shadow-sm mb-4 p-8">
        <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mb-4">
            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
        <h2 class="text-xl font-bold text-gray-800 mb-2 font-['Kanit']">ไม่พบกิจกรรมที่ค้นหา</h2>
        <p class="text-gray-500 text-sm font-['Kanit'] text-center">ลองเปลี่ยนคำค้นหา หรือยกเลิกตัวกรองบางอย่างดูนะ</p>
    </div>
<?php endif; ?>