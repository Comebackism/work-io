<?php
session_start(); 
// เริ่มการทำงานของ session เพื่อให้สามารถใช้ตัวแปร $_SESSION ได้

include('condb.php'); 
// นำเข้าการเชื่อมต่อฐานข้อมูลจากไฟล์ condb.php

$m_id = $_GET['m_id']; 
// รับค่า m_id จาก URL ที่ส่งมา ซึ่งเป็นรหัสพนักงานที่ต้องการแก้ไข

$m_level = $_SESSION['m_level']; 
// ดึงข้อมูลระดับผู้ใช้งานจาก session เพื่อตรวจสอบสิทธิ์

if ($m_level != 'admin') { 
    Header("Location: logout.php"); 
    // ถ้าไม่ใช่ admin ให้เด้งไปที่หน้า logout.php ทันที
}

// Query employee details
$query = "SELECT * FROM tbl_emp WHERE m_id=$m_id"; 
// สร้างคำสั่ง SQL เพื่อดึงข้อมูลพนักงานจากฐานข้อมูล โดยอิงจาก m_id

$result = mysqli_query($condb, $query) or die ("Error in query: $query " . mysqli_error($condb)); 
// รันคำสั่ง SQL และเก็บผลลัพธ์ลงในตัวแปร $result ถ้าผิดพลาดจะแสดง error

$row = mysqli_fetch_assoc($result); 
// ดึงข้อมูลพนักงานมาเป็นแถวหนึ่งและเก็บไว้ในตัวแปร $row

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    // ตรวจสอบว่ามีการส่งฟอร์มมาทาง POST หรือไม่

    $m_username = $_POST['m_username']; 
    $m_password = $_POST['m_password'];
    $m_firstname = $_POST['m_firstname'];
    $m_name = $_POST['m_name'];
    $m_lastname = $_POST['m_lastname'];
    $m_position = $_POST['m_position'];
    $m_level = $_POST['m_level'];
    $m_img = $_POST['m_img']; 
    // รับค่าจากฟอร์มและเก็บลงในตัวแปร

    // If password is not empty, hash it
    if (!empty($m_password)) { 
        // ถ้ารหัสผ่านไม่ว่าง ให้เข้ารหัสผ่านด้วย sha1 ก่อน
        $m_password = sha1($m_password);

        // Update employee details including password
        $query = "UPDATE tbl_emp SET m_username='$m_username', m_password='$m_password', m_firstname='$m_firstname', m_name='$m_name', m_lastname='$m_lastname', m_position='$m_position',m_level='$m_level',m_img='$m_img' WHERE m_id=$m_id"; 
        // อัพเดตข้อมูลพนักงานรวมถึงรหัสผ่านใหม่
    } else {
        // Update employee details without password
        $query = "UPDATE tbl_emp SET m_username='$m_username', m_firstname='$m_firstname', m_name='$m_name', m_lastname='$m_lastname', m_position='$m_position',m_level='$m_level',m_img='$m_img' WHERE m_id=$m_id"; 
        // ถ้ารหัสผ่านว่าง ให้แก้ไขข้อมูลพนักงานโดยไม่แตะต้องรหัสผ่าน
    }

    mysqli_query($condb, $query) or die ("Error in query: $query " . mysqli_error($condb)); 
    // รันคำสั่ง SQL เพื่ออัพเดตข้อมูลพนักงาน

    Header("Location: manage_employee.php"); 
    // เสร็จแล้วให้เด้งไปที่หน้า manage_employee.php
}
?>


<!doctype html>
<html lang="en">
<head>
    <!-- กำหนด character set และปรับให้หน้าเว็บรองรับอุปกรณ์ต่าง ๆ -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- นำเข้าการใช้งาน Bootstrap และ FontAwesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Kanit Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;700&display=swap">

    <style>
        /* ตั้งค่าพื้นหลังและฟอนต์ของเว็บ */
        body {
            background-color: #f8f9fa;
            font-family: 'Kanit', sans-serif;
        }
        .jumbotron {
            background-color: #007bff;
            color: white;
        }
        .btn-primary {
            background-color: #007bff;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- ส่วนหัวของหน้าเพจ -->
    <div class="jumbotron text-center">
        <h1 class="display-4">Edit Employee</h1>
        <p class="lead">Edit the details of the employee below</p>
        <a href="manage_employee.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Manage Employees</a>
    </div>

    <!-- แบบฟอร์มแก้ไขข้อมูลพนักงาน -->
    <div class="row">
        <div class="col-12">
            <form action="" method="post">
                <!-- ฟิลด์กรอกข้อมูล Username -->
                <div class="form-group">
                    <label for="m_username">Username</label>
                    <input type="text" class="form-control" name="m_username" value="<?php echo $row['m_username']; ?>" required>
                </div>
                <!-- ฟิลด์กรอกข้อมูล Password -->
                <div class="form-group">
                    <label for="m_password">Password</label>
                    <input type="password" class="form-control" name="m_password" placeholder="Leave blank to keep current password">
                </div>
                <!-- ฟิลด์กรอกข้อมูล First Name -->
                <div class="form-group">
                    <label for="m_firstname">First Name</label>
                    <input type="text" class="form-control" name="m_firstname" value="<?php echo $row['m_firstname']; ?>" required>
                </div>
                <!-- ฟิลด์กรอกข้อมูล Name -->
                <div class="form-group">
                    <label for="m_name">Name</label>
                    <input type="text" class="form-control" name="m_name" value="<?php echo $row['m_name']; ?>" required>
                </div>
                <!-- ฟิลด์กรอกข้อมูล Last Name -->
                <div class="form-group">
                    <label for="m_lastname">Last Name</label>
                    <input type="text" class="form-control" name="m_lastname" value="<?php echo $row['m_lastname']; ?>" required>
                </div>
                <!-- ฟิลด์กรอกข้อมูล Position -->
                <div class="form-group">
                    <label for="m_position">Position</label>
                    <input type="text" class="form-control" name="m_position" value="<?php echo $row['m_position']; ?>" required>
                </div>
                <!-- ฟิลด์กรอกข้อมูล Level -->
                <div class="form-group">
                    <label for="m_level">Level</label>
                    <input type="text" class="form-control" name="m_level" value="<?php echo $row['m_level']; ?>" required>
                </div>
                <!-- ฟิลด์กรอกข้อมูล Profile Image -->
                <div class="form-group">
                    <label for="m_img">Profile Image</label>
                    <input type="file" class="form-control-file" name="m_img" value="<?php echo $row['m_img']; ?>">
                </div>
                <!-- ปุ่มบันทึกการแก้ไข -->
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
