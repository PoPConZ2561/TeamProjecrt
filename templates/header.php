<header class="flex flex-row items-center justify-between w-full h-[70px] bg-white px-6 md:px-12 fixed top-0 z-50 border-b border-gray-100 shadow-sm">
    
    <!-- ฝั่งซ้าย: โลโก้ และ เมนูนำทาง -->
    <div class="flex flex-row items-center gap-8 h-full">
        <!-- โลโก้ -->
        <a href="index.php" class="flex items-center shrink-0">
            <h1 class="[font-family:'Kanit',sans-serif] text-blue-900 font-extrabold text-2xl tracking-wide">EVENTLY</h1>
        </a>
        
        <!-- เมนูนำทาง (แทนที่การใช้ Select แบบเก่า) -->
        <nav class="hidden md:flex flex-row items-center gap-6 mt-1">
            <a href="index.php" class="text-sm font-medium <?= (isset($page) && $page == 'index') ? 'text-blue-600' : 'text-gray-500 hover:text-blue-600' ?> transition-colors">หน้าหลัก</a>
            
            <!-- โชว์เมนูสร้าง/จัดการกิจกรรม เฉพาะคนที่ล็อกอินแล้ว -->
            <?php if (isset($_SESSION["name"])): ?>
                <a href="create_event.php" class="text-sm font-medium <?= (isset($page) && $page == 'create') ? 'text-blue-600' : 'text-gray-500 hover:text-blue-600' ?> transition-colors">สร้างกิจกรรม</a>
                <a href="manage_event.php" class="text-sm font-medium <?= (isset($page) && $page == 'manage') ? 'text-blue-600' : 'text-gray-500 hover:text-blue-600' ?> transition-colors">จัดการกิจกรรม</a>
            <?php endif; ?>
        </nav>
    </div>

    <!-- ฝั่งขวา: โปรไฟล์ และ ปุ่มเข้าสู่ระบบ -->
    <div class="flex flex-row items-center gap-3 h-full mt-1">
        
        <?php if (isset($_SESSION["name"])): ?>
            
            <!-- === กรณีล็อกอินแล้ว === -->
            <div class="flex flex-row items-center gap-3 mr-2">
                <!-- สร้างรูปโปรไฟล์จากชื่อ User (ตัวอักษรย่อ) อัตโนมัติ -->
                <a href="profile.php" class="h-9 w-9 rounded-full overflow-hidden border border-gray-200 hover:border-blue-400 transition-colors shadow-sm shrink-0">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['name']) ?>&background=E0E7FF&color=3730A3&font-family=Kanit&bold=true" 
                         alt="Profile" 
                         class="h-full w-full object-cover">
                </a>
                
                <a href="profile.php" class="font-medium text-sm text-gray-700 hover:text-blue-600 transition-colors hidden sm:block">
                    <?php echo htmlspecialchars($_SESSION["name"]); ?>
                </a>
            </div>

            <div class="w-[1px] h-[40%] bg-gray-300 mx-1 hidden sm:block"></div>

            <a href="../routes/logout.php" onclick="return confirm('คุณต้องการออกจากระบบใช่หรือไม่?')"
               class="px-3 py-2 text-sm font-medium text-red-500 hover:text-red-700 hover:bg-red-50 rounded-md transition-colors">
                ออกจากระบบ
            </a>

        <?php else: ?>
            
            <!-- === กรณียังไม่ได้ล็อกอิน === -->
            <a href="login.php" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors">
                เข้าสู่ระบบ
            </a>
            <a href="register.php" class="px-5 py-2 text-sm font-medium bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors shadow-sm">
                สมัครสมาชิก
            </a>
            
        <?php endif; ?>
    </div>
</header>