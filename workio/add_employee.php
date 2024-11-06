<?php
session_start(); // เริ่มการใช้งาน session เพื่อเก็บข้อมูลข้ามหน้าเว็บ
include('condb.php'); // เชื่อมต่อกับฐานข้อมูลด้วยไฟล์ condb.php
$m_level = $_SESSION['m_level']; // ดึงระดับผู้ใช้งานจาก session เพื่อตรวจสอบสิทธิ์

if ($m_level != 'admin') { // ถ้าไม่ใช่ admin ให้เด้งไปหน้า logout.php เพื่อออกจากระบบ
    Header("Location: logout.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // เช็คว่ามีการส่งข้อมูลผ่านแบบฟอร์ม (POST) หรือไม่
    $m_username = $_POST['m_username']; // รับค่าชื่อผู้ใช้งานจากฟอร์ม
    $m_password = sha1($_POST['m_password']); // รับรหัสผ่านแล้วเข้ารหัสด้วย sha1 (ไม่ค่อยปลอดภัยแล้ว ควรใช้ hash ที่แข็งแรงกว่านี้)
    $m_firstname = $_POST['m_firstname']; // รับค่า First Name จากฟอร์ม
    $m_name = $_POST['m_name']; // รับค่า Name จากฟอร์ม
    $m_lastname = $_POST['m_lastname']; // รับค่า Last Name จากฟอร์ม
    $m_position = $_POST['m_position']; // รับค่าตำแหน่งงานจากฟอร์ม
    $m_phone = $_POST['m_phone']; // รับค่าเบอร์โทรจากฟอร์ม
    $m_email = $_POST['m_email']; // รับค่าอีเมลจากฟอร์ม
    $m_level = $_POST['m_level']; // รับค่าระดับผู้ใช้งานจากฟอร์ม (admin/staff)
    
    // จัดการอัพโหลดไฟล์รูปภาพโปรไฟล์
    if(isset($_FILES['m_img']) && $_FILES['m_img']['error'] == UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['m_img']['tmp_name']; // เก็บตำแหน่งไฟล์ชั่วคราว
        $file_name = $_FILES['m_img']['name']; // เก็บชื่อไฟล์จริงๆ
        move_uploaded_file($file_tmp, "uploads/" . $file_name); // ย้ายไฟล์จากชั่วคราวไปที่โฟลเดอร์ uploads
        $m_img = $file_name; // เก็บชื่อไฟล์ที่อัพโหลดแล้ว
    } else {
        $m_img = ''; // ถ้าไม่มีรูปภาพอัพโหลดก็เก็บเป็นค่าว่าง
    }
    
    // สร้างคำสั่ง SQL เพื่อเพิ่มข้อมูลพนักงานใหม่ลงในฐานข้อมูล
    $query = "INSERT INTO tbl_emp (m_username, m_password, m_firstname, m_name, m_lastname, m_position, m_phone, m_email, m_level, m_img) 
              VALUES ('$m_username', '$m_password', '$m_firstname', '$m_name', '$m_lastname', '$m_position', '$m_phone', '$m_email', '$m_level', '$m_img')";
    mysqli_query($condb, $query) or die ("Error in query: $query " . mysqli_error($condb)); // รันคำสั่ง SQL และถ้ามีข้อผิดพลาดจะแสดงข้อความ error

    Header("Location: manage_employee.php"); // ถ้าเพิ่มข้อมูลสำเร็จให้ย้ายไปที่หน้า manage_employee.php
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"> <!-- ตั้งค่ารูปแบบอักขระให้รองรับ UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> <!-- ทำให้หน้าเว็บแสดงผลได้ดีในอุปกรณ์ต่างๆ -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"> <!-- ลิงค์ CSS ของ Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> <!-- ลิงค์ CSS ของ Font Awesome -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;700&display=swap"> <!-- ลิงค์ฟอนต์ Kanit -->
    <title>Add Employee</title> <!-- ชื่อเรื่องของหน้าเว็บ -->
    <style>
        body {
            background-color: #f8f9fa; /* ตั้งค่าสีพื้นหลังของหน้าเว็บ */
            font-family: 'Kanit', sans-serif; /* ตั้งค่าฟอนต์ของหน้าเว็บให้เป็น Kanit */
        }
        .jumbotron {
            background-color: #007bff; /* ตั้งค่าสีพื้นหลังของ jumbotron */
            color: white; /* ตั้งค่าสีข้อความใน jumbotron ให้เป็นสีขาว */
        }
        .btn-primary {
            background-color: #007bff; /* ตั้งค่าสีปุ่มให้เป็นสีฟ้า */
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light"> <!-- สร้างเมนูนำทางที่ใช้ Bootstrap -->
    <a class="navbar-brand" href="admin.php">Admin Panel</a> <!-- ลิงค์กลับไปยังหน้า Admin Panel -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span> <!-- ปุ่มสำหรับยุบ/ขยายเมนูในจอเล็ก -->
    </button>
    <div class="collapse navbar-collapse" id="navbarNav"> <!-- ส่วนของเมนูที่จะยุบ/ขยายได้ -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="admin.php"><i class="fas fa-arrow-left"></i> Back to Dashboard</a> <!-- ลิงค์กลับไปที่หน้า Dashboard -->
            </li>
        </ul>
    </div>
</nav>
<div class="container">
    <div class="jumbotron text-center">
        <h1 class="display-4">Add New Employee</h1> <!-- หัวข้อใหญ่ที่บอกว่านี่คือหน้าสำหรับเพิ่มพนักงานใหม่ -->
        <p class="lead">Fill in the details below to add a new employee</p> <!-- ข้อความนำเพื่อบอกว่าให้กรอกรายละเอียดพนักงานใหม่ -->
    </div>
    <div class="row">
        <div class="col-12">
            <form action="" method="post" enctype="multipart/form-data"> <!-- ฟอร์มสำหรับกรอกข้อมูลพนักงานใหม่ และอัพโหลดรูป -->
                <div class="form-group">
                    <label for="m_username">Username</label> <!-- ป้ายกำกับฟิลด์ชื่อผู้ใช้งาน -->
                    <input type="text" class="form-control" name="m_username" required> <!-- ช่องกรอกชื่อผู้ใช้งาน -->
                </div>
                <div class="form-group">
                    <label for="m_password">Password</label> <!-- ป้ายกำกับฟิลด์รหัสผ่าน -->
                    <input type="password" class="form-control" name="m_password" required> <!-- ช่องกรอกรหัสผ่าน -->
                </div>
                <div class="form-group">
                    <label for="m_firstname">First Name</label> <!-- ป้ายกำกับฟิลด์ First Name -->
                    <input type="text" class="form-control" name="m_firstname" required> <!-- ช่องกรอก First Name -->
                </div>
                <div class="form-group">
                    <label for="m_name">Name</label> <!-- ป้ายกำกับฟิลด์ Name -->
                    <input type="text" class="form-control" name="m_name" required> <!-- ช่องกรอก Name -->
                </div>
                <div class="form-group">
                    <label for="m_lastname">Last Name</label> <!-- ป้ายกำกับฟิลด์ Last Name -->
                    <input type="text" class="form-control" name="m_lastname" required> <!-- ช่องกรอก Last Name -->
                </div>
                <div class="form-group">
                    <label for="m_position">Position</label> <!-- ป้ายกำกับฟิลด์ตำแหน่งงาน -->
                    <input type="text" class="form-control" name="m_position" required> <!-- ช่องกรอกตำแหน่งงาน -->
                </div>
                <div class="form-group">
                    <label for="m_phone">Phone</label> <!-- ป้ายกำกับฟิลด์เบอร์โทร -->
                    <input type="text" class="form-control" name="m_phone" required> <!-- ช่องกรอกเบอร์โทร -->
                </div>
                <div class="form-group">
                    <label for="m_email">Email</label> <!-- ป้ายกำกับฟิลด์อีเมล -->
                    <input type="email" class="form-control" name="m_email" required> <!-- ช่องกรอกอีเมล -->
                </div>
                <div class="form-group">
                    <label for="m_level">Level</label> <!-- ป้ายกำกับฟิลด์ระดับผู้ใช้งาน -->
                    <select class="form-control" name="m_level" required> <!-- เมนูเลือกระดับผู้ใช้งาน (admin/staff) -->
                        <option value="admin">Admin</option>
                        <option value="staff">Staff</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="m_img">Profile Image</label> <!-- ป้ายกำกับฟิลด์รูปภาพโปรไฟล์ -->
                    <input type="file" class="form-control-file" name="m_img"> <!-- ช่องอัพโหลดรูปภาพโปรไฟล์ -->
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Add Employee</button> <!-- ปุ่มสำหรับส่งฟอร์มเพื่อเพิ่มพนักงาน -->
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script> <!-- ลิงค์ JS ของ jQuery -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script> <!-- ลิงค์ JS ของ Popper.js -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script> <!-- ลิงค์ JS ของ Bootstrap -->
</body>
</html>
