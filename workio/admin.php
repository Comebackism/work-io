<?php
session_start(); // เริ่มต้น session เพื่อเก็บข้อมูลระหว่างหน้า
include('condb.php'); // เรียกใช้ไฟล์เชื่อมต่อกับฐานข้อมูล
$m_level = $_SESSION['m_level']; // เอาข้อมูลระดับผู้ใช้จาก session มาเก็บในตัวแปร $m_level

if ($m_level != 'admin') { // ถ้าไม่ใช่ admin ก็เตะออกไปหน้า logout ทันที
    Header("Location: logout.php");
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"> <!-- กำหนดการเข้ารหัสอักขระเป็น UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> <!-- ทำให้เว็บดูดีในทุกอุปกรณ์ -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"> <!-- ลิงก์ไปที่ไฟล์ CSS ของ Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> <!-- ลิงก์ไปที่ไฟล์ CSS ของ Font Awesome -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;700&display=swap"> <!-- ลิงก์ไปที่ฟอนต์ Kanit จาก Google Fonts -->
    <title>Admin Dashboard</title> <!-- ชื่อหน้าเว็บ -->
    <style>
        body {
            background-color: #f8f9fa; /* ตั้งค่าสีพื้นหลังเป็นสีเทาอ่อน */
            font-family: 'Kanit', sans-serif; /* ใช้ฟอนต์ Kanit ทั้งหน้าเว็บ */
        }
        .nav-pills .nav-link {
            margin-right: 10px; /* เว้นช่องว่างระหว่างปุ่มเมนู */
        }
        .nav-pills .nav-link.active {
            background-color: #007bff; /* ตั้งค่าสีพื้นหลังของปุ่มที่เลือกอยู่ */
        }
        .jumbotron {
            background-color: #007bff; /* ตั้งค่าสีพื้นหลังของ jumbotron */
            color: white; /* ตั้งค่าสีตัวอักษรใน jumbotron เป็นสีขาว */
        }
        .btn-logout {
            margin-top: 10px; /* เพิ่มระยะห่างด้านบนของปุ่ม Logout */
        }
    </style>
</head>
<body>
<div class="container"> <!-- ส่วนที่รวบรวมเนื้อหาทั้งหมดเข้าด้วยกัน -->
    <div class="jumbotron text-center"> <!-- กล่องใหญ่สีฟ้าสำหรับหัวข้อและปุ่ม Logout -->
        <h1 class="display-4">Admin Dashboard</h1> <!-- หัวข้อใหญ่ที่บอกว่าหน้านี้คือ Admin Dashboard -->
        <p class="lead">Manage your employees easily</p> <!-- ข้อความบอกว่าใช้หน้าเว็บนี้จัดการพนักงานได้ง่ายๆ -->
        <a href="logout.php" class="btn btn-danger btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a> <!-- ปุ่ม Logout พร้อมไอคอนออกจากระบบ -->
    </div>
    <div class="row"> <!-- เริ่มส่วนของแถวใน Bootstrap -->
        <div class="col-12"> <!-- ใช้พื้นที่เต็มคอลัมน์สำหรับเมนู -->
            <nav class="nav nav-pills nav-fill"> <!-- เมนูที่ทำเป็นปุ่มแบบ pill -->
                <a class="nav-item nav-link active" href="admin.php">Home</a> <!-- ปุ่มไปหน้า Home (หน้าแรก) -->
                <a class="nav-item nav-link" href="add_employee.php">Add Employee</a> <!-- ปุ่มไปหน้าเพิ่มพนักงาน -->
                <a class="nav-item nav-link" href="manage_employee.php">Manage Employees</a> <!-- ปุ่มไปหน้าจัดการพนักงาน -->
            </nav>
        </div>
    </div>
    <div class="row mt-4"> <!-- เริ่มแถวใหม่ พร้อมเพิ่มระยะห่างด้านบน -->
        <div class="col-12 text-center"> <!-- กึ่งกลางข้อความทั้งหมดในคอลัมน์นี้ -->
            <h3>Welcome to the Admin Dashboard</h3> <!-- ข้อความต้อนรับผู้ใช้สู่หน้า Admin Dashboard -->
            <p>Select an option from the menu above to get started.</p> <!-- บอกผู้ใช้ให้เลือกเมนูเพื่อเริ่มทำงาน -->
        </div>
    </div>
</div>
</body>
</html>
