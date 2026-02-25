<?php
require("database.php");
$conn = getConnection();

// ใช้ Subquery ป้องกันกิจกรรมโชว์ซ้ำถ้ามีหลายรูป
$sql = "SELECT e.*, 
        (SELECT image_path FROM event_images WHERE event_id = e.event_id LIMIT 1) AS image_path
        FROM events e ORDER BY e.created_at DESC"; 
$result = $conn->query($sql);
?>

<!-- เช็คว่ามีข้อมูลกิจกรรมหรือไม่ -->
<?php if ($result && $result->num_rows > 0): ?>

    <!-- ถ้ามีกิจกรรม: วนลูปแสดงกล่องกิจกรรม -->
    <?php foreach ($result as $row) : ?>
        <div class="flex flex-row w-full h-[280px] bg-white rounded-lg border shadow-sm mb-4">
            <div class="h-full w-[40%] overflow-hidden rounded-l-lg">
                <?php if (!empty($row['image_path'])): ?>
                    <!-- ปรับ Path รูปภาพให้ตรงกับโฟลเดอร์ของคุณ (ลบ /../ ออกถ้าภาพไม่ขึ้น) -->
                    <img class="h-full w-full object-cover" 
                         src="../<?php echo htmlspecialchars($row['image_path']); ?>" 
                         alt="Event Image">
                <?php else: ?>
                    <img class="h-full w-full object-cover" 
                         src="https://via.placeholder.com/300?text=No+Image"
                         alt="No Image">
                <?php endif; ?>
            </div>

            <div class="flex flex-col gap-2 h-full w-[60%] px-4 py-6">
                <h1 class="title_event_text text-xl font-bold text-blue-950">
                    <?php echo htmlspecialchars($row["title"]) ?>
                </h1>
                <p class="description text-gray-600 line-clamp-3">
                    <?php echo htmlspecialchars($row["description"]) ?>
                </p>
                <p class="description mt-2 font-bold text-blue-600">
                    <?php echo "วันที่ " . date("d M Y", strtotime($row["start_date"])) . " - " . date("d M Y", strtotime($row["end_date"])) ?>
                </p>
                <div class="mt-auto flex justify-end">
                    <button class="bg-green-400 hover:bg-green-500 text-white px-4 py-2 rounded-md shadow-sm transition-colors">
                        จำนวนที่รับ: <?php echo $row["max_participants"] ?> คน
                    </button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

<?php else: ?>

    <!-- ถ้าไม่มีกิจกรรม: แสดงกล่องข้อความนี้แทน -->
    <div class="flex flex-col items-center justify-center w-full h-[280px] bg-white rounded-lg border shadow-sm mb-4">
        <!-- ไอคอนกล่องว่างเปล่า -->
        <svg class="w-20 h-20 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
        </svg>
        <h2 class="text-2xl font-bold text-gray-400" style="font-family: 'Kanit', sans-serif;">ยังไม่มีกิจกรรม</h2>
    </div>

<?php endif; ?>