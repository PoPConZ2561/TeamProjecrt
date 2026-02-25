<?php
// ตรวจสอบว่ามีการ start session หรือยัง เพื่อดึง user_id
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("database.php");
$conn = getConnection();

// ถ้ายังไม่ล็อกอิน ให้ตั้งค่า user_id เป็น 0 (Guest)
$current_user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

/* SQL ดึงข้อมูลพร้อม Subquery:
  1. ดึงรูปภาพแรกสุดของกิจกรรม
  2. นับจำนวนคนที่ได้รับการอนุมัติแล้ว (current_participants)
  3. ดึงสถานะการสมัครของ user คนนี้ (status)
*/
$sql = "SELECT e.*, 
        (SELECT image_path FROM event_images WHERE event_id = e.event_id LIMIT 1) AS image_path,
        (SELECT COUNT(*) FROM registrations WHERE event_id = e.event_id AND status = 'approved') AS current_participants,
        (SELECT status FROM registrations WHERE event_id = e.event_id AND user_id = ?) AS status
        FROM events e ORDER BY e.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $current_user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!-- เช็คว่ามีข้อมูลกิจกรรมหรือไม่ -->
<?php if ($result && $result->num_rows > 0): ?>

    <!-- ถ้ามีกิจกรรม: วนลูปแสดงกล่องกิจกรรม -->
    <?php while ($row = $result->fetch_assoc()) : ?>
        
        <?php
            // ==========================================
            // ตรรกะเช็คสถานะปุ่ม (Logic เช็คตามเงื่อนไข 8 ข้อ)
            // ==========================================
            $now = time(); // ดึงเวลาปัจจุบัน (อิงตามเซิร์ฟเวอร์ ถึงระดับวินาที)
            $start_date = strtotime($row["start_date"]); // เวลาเริ่มกิจกรรมตามฐานข้อมูล
            $end_date = strtotime($row["end_date"]);     // เวลาสิ้นสุดกิจกรรมตามฐานข้อมูล
            
            $max_participants = $row["max_participants"];
            $current_participants = $row["current_participants"];
            $status = $row["status"]; // ค่าที่ได้จะเป็น null, 'pending', 'approved', 'rejected'
            $event_owner_id = $row["user_id"]; // ไอดีของคนสร้างกิจกรรมนี้

            $btn_text = "";
            $btn_class = "";
            $btn_link = "";
            $is_disabled = true;

            // [เคสพิเศษ] ถ้าคนที่ล็อกอินอยู่ คือ "เจ้าของกิจกรรม" ให้เห็นปุ่มจัดการเสมอ
            if ($current_user_id == $event_owner_id && $current_user_id != 0) {
                $btn_text = "จัดการกิจกรรม (ของคุณ)";
                $btn_class = "bg-purple-600 hover:bg-purple-700 text-white shadow-sm";
                $btn_link = "manage_event.php?event_id=" . $row['event_id']; 
                $is_disabled = false;
            } 
            // 4. กิจกรรมสิ้นสุดแล้ว (เวลาปัจจุบัน เลยวันที่ end_date ไปแล้ว)
            elseif ($now > $end_date) {
                $btn_text = "กิจกรรมสิ้นสุดแล้ว";
                $btn_class = "bg-gray-400 text-white cursor-not-allowed";
            } 
            // 6. เช็คสถานะการสมัครของ User คนนี้ (โดนปฏิเสธ)
            elseif ($status === 'rejected') {
                $btn_text = "ไม่สามารถเข้าร่วมได้";
                $btn_class = "bg-red-600 text-white cursor-not-allowed";
            } 
            // 6. เช็คสถานะการสมัครของ User คนนี้ (รอดำเนินการ)
            elseif ($status === 'pending') {
                $btn_text = "รอดำเนินการ";
                $btn_class = "bg-yellow-500 text-white cursor-not-allowed";
            } 
            // 6. เช็คสถานะการสมัครของ User คนนี้ (ผ่านแล้ว)
            elseif ($status === 'approved') {
                // 3. ถึงวันที่เริ่มงานแล้ว และสมัครผ่านแล้ว -> เข้าร่วมกิจกรรม
                if ($now >= $start_date && $now <= $end_date) {
                    $btn_text = "เข้าร่วมกิจกรรม";
                    $btn_class = "bg-blue-600 hover:bg-blue-700 text-white shadow-sm";
                    $btn_link = "attend_event.php?event_id=" . $row['event_id']; 
                    $is_disabled = false;
                } else {
                    // สมัครผ่านแล้ว แต่วันนี้ยังไม่ถึงเวลาเริ่มงาน
                    $btn_text = "สมัครเรียบร้อยแล้ว";
                    $btn_class = "bg-green-600 text-white cursor-not-allowed";
                }
            } 
            // 5. กิจกรรมเริ่มไปแล้ว สำหรับคนที่ไม่ได้สมัคร (หรือเพิ่งมาเห็น)
            elseif ($now >= $start_date) {
                $btn_text = "กิจกรรมเริ่มแล้ว";
                $btn_class = "bg-gray-500 text-white cursor-not-allowed";
            } 
            // 2. เช็คจำนวนคน (ถ้ามีการจำกัดจำนวน และคนเต็มแล้ว)
            elseif ($max_participants > 0 && $current_participants >= $max_participants) {
                $btn_text = "เต็มแล้ว";
                $btn_class = "bg-red-500 text-white cursor-not-allowed";
            } 
            // [เคสพิเศษ] ถ้าที่นั่งว่าง แต่งานยังไม่เริ่ม แล้วผู้ใช้ยังไม่ได้ล็อกอิน (Guest)
            elseif ($current_user_id == 0) {
                $btn_text = "ล็อกอินเพื่อสมัคร";
                $btn_class = "bg-blue-500 hover:bg-blue-600 text-white shadow-sm";
                $btn_link = "login.php";
                $is_disabled = false;
            } 
            // 1. ที่นั่งว่าง, ยังไม่ถึงวันเริ่ม, เข้าสู่ระบบแล้ว, ยังไม่ได้สมัคร -> โชว์ปุ่มสมัครปกติ
            else {
                $btn_text = "สมัคร";
                $btn_class = "bg-green-400 hover:bg-green-500 text-white shadow-sm";
                $btn_link = "join_event.php?user_id={$current_user_id}&event_id={$row['event_id']}";
                $is_disabled = false;
            }
        ?>

        <!-- กล่องแสดงกิจกรรมแต่ละอัน -->
        <div class="flex flex-row w-full h-[280px] bg-white rounded-lg border shadow-sm mb-4 transition hover:shadow-md">
            
            <!-- ส่วนรูปภาพด้านซ้าย -->
            <div class="h-full w-[40%] overflow-hidden rounded-l-lg bg-gray-100">
                <?php if (!empty($row['image_path'])): ?>
                    <img class="h-full w-full object-cover"
                        src="../<?php echo htmlspecialchars($row['image_path']); ?>"
                        alt="Event Image">
                <?php else: ?>
                    <img class="h-full w-full object-cover opacity-50"
                        src="https://via.placeholder.com/300?text=No+Image"
                        alt="No Image">
                <?php endif; ?>
            </div>

            <!-- ส่วนข้อมูลกิจกรรมด้านขวา -->
            <div class="flex flex-col gap-2 h-full w-[60%] px-5 py-6">
                <h1 class="title_event_text text-xl font-bold text-blue-950">
                    <?php echo htmlspecialchars($row["title"]) ?>
                </h1>
                <p class="description text-gray-600 line-clamp-3">
                    <?php echo htmlspecialchars($row["description"]) ?>
                </p>
                <p class="description mt-2 font-bold text-blue-600">
                    <?php echo "วันที่ " . date("d M Y", strtotime($row["start_date"])) . " - " . date("d M Y", strtotime($row["end_date"])) ?>
                </p>
                
                <!-- แถบด้านล่างสุด (แสดงจำนวนคน และ ปุ่ม) -->
                <div class="mt-auto flex justify-end items-center gap-4">
                    
                    <!-- แสดงสถานะจำนวนคนรับ (ถ้าไม่ได้จำกัดจำนวนให้โชว์ว่า ไม่จำกัด) -->
                    <span class="text-sm font-medium text-gray-500">
                        <?php if ($max_participants == 0 || empty($max_participants)): ?>
                            รับ: <span class="text-green-600 font-semibold">ไม่จำกัด</span>
                        <?php else: ?>
                            รับแล้ว: 
                            <span class="<?php echo ($current_participants >= $max_participants) ? 'text-red-500 font-semibold' : 'text-blue-600 font-semibold'; ?>">
                                <?php echo $current_participants; ?>/<?php echo $max_participants; ?>
                            </span> คน
                        <?php endif; ?>
                    </span>

                    <!-- แสดงปุ่มตามเงื่อนไขที่คำนวณไว้ด้านบน -->
                    <?php if ($is_disabled): ?>
                        <button disabled class="px-5 py-2.5 rounded-md font-medium transition-colors <?php echo $btn_class; ?>">
                            <?php echo $btn_text; ?>
                        </button>
                    <?php else: ?>
                        <a href="<?php echo $btn_link; ?>" class="px-5 py-2.5 rounded-md font-medium text-center transition-colors <?php echo $btn_class; ?>">
                            <?php echo $btn_text; ?>
                        </a>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    <?php endwhile; ?>

<?php else: ?>

    <!-- ถ้าไม่มีกิจกรรมในฐานข้อมูลเลย: แสดงกล่องข้อความนี้แทน -->
    <div class="flex flex-col items-center justify-center w-full h-[280px] bg-white rounded-lg border shadow-sm mb-4">
        <svg class="w-20 h-20 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
        </svg>
        <h2 class="text-2xl font-bold text-gray-400" style="font-family: 'Kanit', sans-serif;">ยังไม่มีกิจกรรมในขณะนี้</h2>
    </div>

<?php endif; ?>