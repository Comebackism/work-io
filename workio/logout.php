<?php
session_start(); // เริ่มต้น session เพื่อเข้าถึงข้อมูลใน session
session_destroy(); // ลบข้อมูลทั้งหมดใน session เพื่อออกจากระบบ
header("Location: index.php"); // เปลี่ยนเส้นทางไปยังหน้า index.php
?>
