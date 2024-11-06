<meta charset="utf-8">
<?php 
include("condb.php"); // นำเข้าไฟล์เชื่อมต่อกับฐานข้อมูล

//print_r($_POST); // ใช้ตรวจสอบข้อมูลที่ส่งมาจากฟอร์ม (คอมเม้นท์ไว้เพื่อไม่ให้แสดงผล)

// บันทึกเวลาเข้างาน
if(isset($_POST["workin"])){ // ตรวจสอบว่ามีการส่งข้อมูล workin มาหรือไม่

    $workdate = date('Y-m-d'); // กำหนดวันที่ปัจจุบันในรูปแบบปี-เดือน-วัน
    $m_id = mysqli_real_escape_string($condb,$_POST["m_id"]); // รับค่า m_id และป้องกัน SQL Injection
    $workin = mysqli_real_escape_string($condb,$_POST["workin"]); // รับค่า workin และป้องกัน SQL Injection

    // สร้างคำสั่ง SQL สำหรับการเพิ่มข้อมูลเวลางานเข้า
    $sql = "INSERT INTO tbl_work_io
    (workdate, m_id, workin)
    VALUES
    ('$workdate', '$m_id', '$workin')";
    $result = mysqli_query($condb, $sql) or die ("Error in query: $sql " . mysqli_error($sql)); // รันคำสั่ง SQL และตรวจสอบว่ามีข้อผิดพลาดหรือไม่

    mysqli_close($condb); // ปิดการเชื่อมต่อกับฐานข้อมูล
    if($result){ // ถ้าบันทึกข้อมูลสำเร็จ
        echo "<script type='text/javascript'>";
        echo "alert('บันทึกข้อมูลสำเร็จ');"; // แสดงข้อความแจ้งเตือนว่าบันทึกข้อมูลสำเร็จ
        echo "window.location = 'profile.php'; "; // เปลี่ยนหน้าไปที่ profile.php
        echo "</script>";
    } else { // ถ้าบันทึกข้อมูลไม่สำเร็จ
        echo "<script type='text/javascript'>";
        echo "alert('Error');"; // แสดงข้อความแจ้งเตือนว่ามีข้อผิดพลาด
        echo "window.location = 'profile.php'; "; // เปลี่ยนหน้าไปที่ profile.php
        echo "</script>";
    }

    // บันทึกเวลาออกงาน
}elseif(isset($_POST["workout"])) { // ตรวจสอบว่ามีการส่งข้อมูล workout มาหรือไม่

    // echo $_POST["workout"]; // ใช้สำหรับตรวจสอบข้อมูลที่ส่งมา (คอมเม้นท์ไว้)
    // exit; // หยุดการทำงานของโค้ดหลังจากนี้ (คอมเม้นท์ไว้)

    $workdate = date('Y-m-d'); // กำหนดวันที่ปัจจุบันในรูปแบบปี-เดือน-วัน
    $m_id = mysqli_real_escape_string($condb,$_POST["m_id"]); // รับค่า m_id และป้องกัน SQL Injection
    $workout = mysqli_real_escape_string($condb,$_POST["workout"]); // รับค่า workout และป้องกัน SQL Injection

    // สร้างคำสั่ง SQL สำหรับการอัปเดตข้อมูลเวลาออกงาน
    $sql2 = "UPDATE tbl_work_io SET 
    workout='$workout'
    WHERE m_id=$m_id  AND workdate='$workdate'";
    $result2 = mysqli_query($condb, $sql2) or die ("Error in query: $sql2 " . mysqli_error($sql2)); // รันคำสั่ง SQL และตรวจสอบว่ามีข้อผิดพลาดหรือไม่

    // echo $sql2; // ใช้สำหรับตรวจสอบคำสั่ง SQL (คอมเม้นท์ไว้)
    // exit; // หยุดการทำงานของโค้ดหลังจากนี้ (คอมเม้นท์ไว้)

    mysqli_close($condb); // ปิดการเชื่อมต่อกับฐานข้อมูล
    if($result2){ // ถ้าอัปเดตข้อมูลสำเร็จ
        echo "<script type='text/javascript'>";
        echo "alert('บันทึกข้อมูลสำเร็จ');"; // แสดงข้อความแจ้งเตือนว่าบันทึกข้อมูลสำเร็จ
        echo "window.location = 'profile.php'; "; // เปลี่ยนหน้าไปที่ profile.php
        echo "</script>";
    } else { // ถ้าอัปเดตข้อมูลไม่สำเร็จ
        echo "<script type='text/javascript'>";
        echo "alert('Error');"; // แสดงข้อความแจ้งเตือนว่ามีข้อผิดพลาด
        echo "window.location = 'profile.php'; "; // เปลี่ยนหน้าไปที่ profile.php
        echo "</script>";
    }

} else { // กรณีที่ไม่มีข้อมูล workin หรือ workout ถูกส่งมา
    echo "<script type='text/javascript'>";
    echo "alert('คุณได้บันทึกเวลาเข้า-ออกงานวันนี้เรียบร้อยแล้ว');"; // แจ้งเตือนว่าบันทึกเวลาเข้า-ออกงานเรียบร้อยแล้ว
    echo "window.location = 'profile.php'; "; // เปลี่ยนหน้าไปที่ profile.php
    echo "</script>";
}	
?> 
