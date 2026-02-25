<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require("database.php");
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

    <div class="flex flex-col gap-6 w-full pb-10">
    <!-- ถ้ามีกิจกรรม: วนลูปแสดงกล่องกิจกรรม -->
    <?php while ($row = $result->fetch_assoc()) : ?>
        
        <?php
            // ==========================================
            // ตรรกะเช็คสถานะปุ่ม (Logic เช็คตามเงื่อนไข 8 ข้อ)
            // ==========================================
            $now = time(); 
            $start_date = strtotime($row["start_date"]); 
            $end_date = strtotime($row["end_date"]);     
            
            $max_participants = $row["max_participants"];
            $current_participants = $row["current_participants"];
            $status = $row["status"]; 
            $event_owner_id = $row["user_id"]; 

            $btn_text = "";
            $btn_class = "";
            $btn_link = "";
            $is_disabled = true;

            // [เคสพิเศษ] ถ้าคนที่ล็อกอินอยู่ คือ "เจ้าของกิจกรรม"
            if ($current_user_id == $event_owner_id && $current_user_id != 0) {
                $btn_text = "จัดการกิจกรรม (ของคุณ)";
                $btn_class = "bg-purple-600 hover:bg-purple-700 text-white shadow-sm hover:-translate-y-0.5";
                $btn_link = "manage_event.php?event_id=" . $row['event_id']; 
                $is_disabled = false;
            } 
            // 4. กิจกรรมสิ้นสุดแล้ว
            elseif ($now > $end_date) {
                $btn_text = "กิจกรรมสิ้นสุดแล้ว";
                $btn_class = "bg-gray-200 text-gray-500 cursor-not-allowed";
            } 
            // 6. เช็คสถานะการสมัครของ User คนนี้ (โดนปฏิเสธ)
            elseif ($status === 'rejected') {
                $btn_text = "ไม่สามารถเข้าร่วมได้";
                $btn_class = "bg-red-50 text-red-500 border border-red-200 cursor-not-allowed";
            } 
            // 6. เช็คสถานะการสมัครของ User คนนี้ (รอดำเนินการ)
            elseif ($status === 'pending') {
                $btn_text = "รอดำเนินการตรวจสอบ";
                $btn_class = "bg-amber-100 text-amber-700 border border-amber-200 cursor-not-allowed";
            } 
            // 6. เช็คสถานะการสมัครของ User คนนี้ (ผ่านแล้ว)
            elseif ($status === 'approved') {
                if ($now >= $start_date && $now <= $end_date) {
                    $btn_text = "เข้าร่วมกิจกรรม";
                    $btn_class = "bg-blue-600 hover:bg-blue-700 text-white shadow-md hover:-translate-y-0.5";
                    $btn_link = "attend_event.php?event_id=" . $row['event_id']; 
                    $is_disabled = false;
                } else {
                    $btn_text = "สมัครเรียบร้อยแล้ว";
                    $btn_class = "bg-emerald-50 text-emerald-600 border border-emerald-200 cursor-not-allowed";
                }
            } 
            // 5. กิจกรรมเริ่มไปแล้ว สำหรับคนที่ไม่ได้สมัคร
            elseif ($now >= $start_date) {
                $btn_text = "กิจกรรมกำลังดำเนินการ";
                $btn_class = "bg-gray-100 text-gray-500 cursor-not-allowed";
            } 
            // 2. เช็คจำนวนคน (เต็มแล้ว)
            elseif ($max_participants > 0 && $current_participants >= $max_participants) {
                $btn_text = "ที่นั่งเต็มแล้ว";
                $btn_class = "bg-red-500 text-white shadow-sm cursor-not-allowed";
            } 
            // [เคสพิเศษ] Guest ยังไม่ได้ล็อกอิน
            elseif ($current_user_id == 0) {
                $btn_text = "เข้าสู่ระบบเพื่อสมัคร";
                $btn_class = "bg-blue-50 text-blue-600 border border-blue-200 hover:bg-blue-100 transition-colors";
                $btn_link = "login.php";
                $is_disabled = false;
            } 
            // 1. พร้อมให้สมัคร
            else {
                $btn_text = "สมัครเข้าร่วมกิจกรรม";
                $btn_class = "bg-green-600 hover:bg-green-700 text-white shadow-md hover:-translate-y-0.5";
                $btn_link = "../includes/reg_event.php?user_id={$current_user_id}&event_id={$row['event_id']}";
                $is_disabled = false;
            }
        ?>

        <!-- กล่องแสดงกิจกรรมแต่ละอัน (Responsive: ซ้อนกันในมือถือ, แบ่งซ้ายขวาในคอม) -->
        <div class="group flex flex-col md:flex-row w-full bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
            
            <!-- ส่วนรูปภาพ (ซ้าย/บน) -->
            <div class="relative w-full md:w-[40%] h-[200px] md:h-auto overflow-hidden bg-gray-100 shrink-0">
                <?php if (!empty($row['image_path'])): ?>
                    <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                        src="../<?php echo htmlspecialchars($row['image_path']); ?>"
                        alt="Event Image">
                <?php else: ?>
                    <div class="w-full h-full flex items-center justify-center bg-gray-100">
                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                <?php endif; ?>
                
                <!-- Badge สถานะมุมขวาบนของรูป (แสดงเฉพาะตอนเต็ม หรือ จบแล้ว) -->
                <?php if ($now > $end_date): ?>
                    <div class="absolute top-3 right-3 bg-black/70 backdrop-blur-sm text-white text-xs font-medium px-3 py-1 rounded-full">สิ้นสุดแล้ว</div>
                <?php elseif ($max_participants > 0 && $current_participants >= $max_participants): ?>
                    <div class="absolute top-3 right-3 bg-red-500/90 backdrop-blur-sm text-white text-xs font-medium px-3 py-1 rounded-full">เต็มแล้ว</div>
                <?php endif; ?>
            </div>

            <!-- ส่วนข้อมูลกิจกรรม (ขวา/ล่าง) -->
            <div class="flex flex-col flex-grow p-6 lg:p-8">
                
                <!-- ชื่อกิจกรรม -->
                <h1 class="text-xl lg:text-2xl font-bold text-gray-900 mb-3 line-clamp-2 leading-tight group-hover:text-blue-600 transition-colors">
                    <?php echo htmlspecialchars($row["title"]) ?>
                </h1>
                
                <!-- ข้อมูล วันที่ และ สถานที่ (ใช้ Icon) -->
                <div class="flex flex-col gap-2.5 mb-4 text-sm text-gray-600">
                    <!-- วันที่ -->
                    <div class="flex items-start gap-2.5">
                        <svg class="w-5 h-5 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="font-medium">
                            <?php 
                                $fDate = date("d M Y", strtotime($row["start_date"]));
                                $eDate = date("d M Y", strtotime($row["end_date"]));
                                echo ($fDate == $eDate) ? "วันที่ " . $fDate : "วันที่ " . $fDate . " - " . $eDate;
                            ?>
                        </span>
                    </div>
                    <!-- สถานที่ -->
                    <div class="flex items-start gap-2.5">
                        <svg class="w-5 h-5 text-red-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span class="line-clamp-1"><?php echo htmlspecialchars($row["location"]) ?></span>
                    </div>
                </div>

                <!-- รายละเอียด (ซ่อนเนื้อหาที่ยาวเกินไป) -->
                <p class="text-gray-500 text-sm line-clamp-2 mb-6 leading-relaxed">
                    <?php echo htmlspecialchars($row["description"]) ?>
                </p>
                
                <!-- แถบด้านล่างสุด (แสดงจำนวนคน และ ปุ่ม) -->
                <div class="mt-auto pt-4 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    
                    <!-- จำนวนคนรับ -->
                    <div class="flex items-center gap-2 text-sm">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span class="font-medium text-gray-600">
                            <?php if ($max_participants == 0 || empty($max_participants)): ?>
                                รับ: <span class="text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md text-xs">ไม่จำกัด</span>
                            <?php else: ?>
                                รับแล้ว: 
                                <span class="<?php echo ($current_participants >= $max_participants) ? 'text-red-500' : 'text-blue-600'; ?>">
                                    <?php echo $current_participants; ?>/<?php echo $max_participants; ?>
                                </span>
                            <?php endif; ?>
                        </span>
                    </div>

                    <!-- ปุ่ม Action -->
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

    <!-- ถ้าไม่มีกิจกรรมในฐานข้อมูลเลย -->
    <div class="flex flex-col items-center justify-center w-full min-h-[400px] bg-white rounded-2xl border border-gray-100 shadow-sm mb-4">
        <div class="w-32 h-32 bg-gray-50 rounded-full flex items-center justify-center mb-6">
            <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-800 mb-2" style="font-family: 'Kanit', sans-serif;">ยังไม่มีกิจกรรมในขณะนี้</h2>
        <p class="text-gray-500" style="font-family: 'Kanit', sans-serif;">รอผู้จัดกิจกรรมเพิ่มกิจกรรมใหม่เร็วๆ นี้...</p>
    </div>

<?php endif; ?>