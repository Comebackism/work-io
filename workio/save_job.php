<meta charset="utf-8">
<?php 
include("condb.php"); // นำเข้าไฟล์เชื่อมต่อกับฐานข้อมูล

// print_r($_POST); // ใช้สำหรับตรวจสอบข้อมูลที่ส่งมาจากฟอร์ม (ปิดการใช้งานด้วยการคอมเม้นท์)
// exit; // หยุดการทำงานของโค้ดหลังจากนี้ (ปิดการใช้งานด้วยการคอมเม้นท์)

// บันทึกงานใหม่
if(isset($_POST["job_detail"])){ // ตรวจสอบว่ามีข้อมูล job_detail ถูกส่งมาจากฟอร์มหรือไม่

    // กำหนดค่าให้ตัวแปรต่าง ๆ ด้วยค่าที่ส่งมาจากฟอร์ม และป้องกัน SQL Injection ด้วย mysqli_real_escape_string
    $m_id = mysqli_real_escape_string($condb,$_POST["m_id"]); 
    $job_detail = mysqli_real_escape_string($condb,$_POST["job_detail"]);
    $job_remark = mysqli_real_escape_string($condb,$_POST["job_remark"]);
    $job_by = mysqli_real_escape_string($condb,$_POST["job_by"]);

    // สร้างคำสั่ง SQL สำหรับการเพิ่มข้อมูลลงในตาราง tbl_job
    $sql = "INSERT INTO tbl_job
    (ref_m_id, job_detail, job_remark, job_by)
    VALUES
    ('$m_id', '$job_detail', '$job_remark', '$job_by')";
    
    // รันคำสั่ง SQL และตรวจสอบผลลัพธ์
    $result = mysqli_query($condb, $sql) or die ("Error in query: $sql " . mysqli_error($sql));

    mysqli_close($condb); // ปิดการเชื่อมต่อกับฐานข้อมูล
    
    if($result){ // ถ้าการบันทึกข้อมูลสำเร็จ
        echo "<script type='text/javascript'>";
        //echo "alert('บันทึกข้อมูลสำเร็จ');"; // แสดงข้อความแจ้งเตือนว่าบันทึกข้อมูลสำเร็จ (ปิดการใช้งานด้วยการคอมเม้นท์)
        echo "window.location = 'job.php'; "; // เปลี่ยนหน้าไปที่ job.php
        echo "</script>";
    } else { // ถ้าการบันทึกข้อมูลไม่สำเร็จ
        echo "<script type='text/javascript'>";
        echo "alert('Error');"; // แสดงข้อความแจ้งเตือนว่ามีข้อผิดพลาด
        echo "window.location = 'job.php'; "; // เปลี่ยนหน้าไปที่ job.php
        echo "</script>";
    }	

} else { // ถ้าไม่ได้รับข้อมูล job_detail จากฟอร์ม (กรณีเกิดข้อผิดพลาด)
    echo "<script type='text/javascript'>";
    echo "alert('error!!!');"; // แสดงข้อความแจ้งเตือนว่ามีข้อผิดพลาด
    echo "window.location = 'job.php'; "; // เปลี่ยนหน้าไปที่ job.php
    echo "</script>";
}	
?> 
