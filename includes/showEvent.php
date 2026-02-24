<?php
require("database.php");
$conn = getConnection();

// ใช้ GROUP BY เพื่อให้ 1 กิจกรรมแสดงแค่ 1 รูป (รูปแรกที่เจอ) 
// ป้องกันหน้าเว็บแสดงกิจกรรมซ้ำถ้ามีหลายรูป
$sql = "SELECT e.*, i.image_path
        FROM events e 
        LEFT JOIN event_images i ON e.event_id = i.event_id
        GROUP BY e.event_id"; 
$result = $conn->query($sql);
?>

<?php foreach ($result as $row) : ?>
    <div class="flex flex-row w-full h-[280px] bg-white rounded-lg border shadow-sm mb-4">
        <div class="h-full w-[40%] overflow-hidden rounded-l-lg">
            <?php if (!empty($row['image_path'])): ?>
                <img class="h-full w-full object-cover" 
                     src="/../<?php echo htmlspecialchars($row['image_path']); ?>" 
                     alt="Event Image">
            <?php else: ?>
                <img class="h-full w-full object-cover" 
                     src="https://via.placeholder.com/300?text=No+Image">
            <?php endif; ?>
        </div>

        <div class="flex flex-col gap-2 h-full w-[60%] px-4 py-6">
            <h1 class="title_event_text text-xl font-bold">
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