<?php
session_start(); // เริ่ม session เพื่อใช้ตรวจสอบระดับการเข้าถึงของผู้ใช้
include('condb.php'); // ดึงไฟล์เชื่อมต่อกับฐานข้อมูลเข้ามาใช้
$m_level = $_SESSION['m_level']; // เก็บค่า 'm_level' ที่เก็บไว้ใน session ลงในตัวแปร $m_level

if ($m_level != 'admin') { // ถ้า $m_level ไม่ใช่ 'admin'
    Header("Location: logout.php"); // สั่งให้ไปหน้า logout.php (เพื่อออกจากระบบหรือจำกัดสิทธิ์การเข้าถึง)
}

// Query all employees
$query = "SELECT * FROM tbl_emp"; // คำสั่ง SQL เพื่อดึงข้อมูลพนักงานทั้งหมดจากตาราง tbl_emp
$result = mysqli_query($condb, $query) or die ("Error in query: $query " . mysqli_error($condb)); 
// รัน query ข้างต้น ถ้า error ให้แสดงข้อความ error

// Delete employee if ID is provided via GET parameter
if (isset($_GET['delete_id'])) { // ถ้ามีการส่งค่า 'delete_id' ผ่าน URL (เช่น manage_employee.php?delete_id=1)
    $delete_id = $_GET['delete_id']; // เอาค่านั้นมาเก็บในตัวแปร $delete_id
    $delete_query = "DELETE FROM tbl_emp WHERE m_id = $delete_id"; // คำสั่ง SQL เพื่อลบพนักงานที่มี m_id เท่ากับ $delete_id
    mysqli_query($condb, $delete_query) or die ("Error in query: $delete_query " . mysqli_error($condb)); 
    // รัน query ลบ ถ้า error ให้แสดงข้อความ error
    Header("Location: manage_employee.php"); // ลบเสร็จแล้ว ให้รีเฟรชหน้าจอใหม่เพื่อแสดงข้อมูลล่าสุด
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"> <!-- ตั้งค่ารูปแบบตัวอักษรเป็น UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
    <!-- ทำให้เว็บแสดงผลได้ดีบนหน้าจอมือถือ -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- โหลด Bootstrap CSS มาใช้ในการจัดการเลย์เอาต์ของเว็บ -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- โหลดไอคอนจาก Font Awesome -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;700&display=swap">
    <!-- โหลดฟอนต์ Kanit จาก Google Fonts -->
    <title>Manage Employees</title> <!-- ชื่อแท็บของหน้าเว็บ -->
    <style>
        body {
            background-color: #f8f9fa; /* สีพื้นหลังของเว็บ */
            font-family: 'Kanit', sans-serif; /* ตั้งฟอนต์หลักเป็น Kanit */
        }
        .jumbotron {
            background-color: #007bff; /* สีพื้นหลังของส่วน jumbotron */
            color: white; /* สีตัวอักษรใน jumbotron */
        }
        .btn-warning {
            background-color: #ffc107; /* สีปุ่ม edit */
        }
        .btn-danger {
            background-color: #dc3545; /* สีปุ่ม delete */
        }
    </style> <!-- ส่วนตกแต่งเว็บ -->
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="admin.php">Admin Panel</a> <!-- ลิงก์กลับไปหน้าหลักของ Admin -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span> <!-- ไอคอนปุ่มเมนูที่แสดงบนมือถือ -->
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="admin.php"><i class="fas fa-arrow-left"></i> Back to Dashboard</a> 
                <!-- ลิงก์กลับไปหน้า Dashboard -->
            </li>
        </ul>
    </div>
</nav>
<div class="container">
    <div class="jumbotron text-center">
        <h1 class="display-4">Manage Employees</h1> <!-- หัวข้อใหญ่ของหน้าเว็บ -->
        <p class="lead">View and manage your employees below</p> <!-- คำบรรยายสั้นๆ ใต้หัวข้อ -->
    </div>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-bordered"> <!-- ตารางที่แสดงข้อมูลพนักงาน -->
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?> <!-- ลูปแสดงข้อมูลพนักงานทีละคน -->
                        <tr>
                            <td><?php echo $row['m_id']; ?></td> <!-- แสดง ID พนักงาน -->
                            <td><?php echo $row['m_username']; ?></td> <!-- แสดง Username -->
                            <td><?php echo $row['m_firstname'] . ' ' . $row['m_name'] . ' ' . $row['m_lastname']; ?></td> 
                            <!-- แสดงชื่อ-นามสกุลพนักงาน -->
                            <td><?php echo $row['m_position']; ?></td> <!-- แสดงตำแหน่งพนักงาน -->
                            <td>
                                <a href="edit_employee.php?m_id=<?php echo $row['m_id']; ?>" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edit</a> <!-- ปุ่ม Edit -->
                                <a href="manage_employee.php?delete_id=<?php echo $row['m_id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this employee?');">
                                    <i class="fas fa-trash-alt"></i> Delete</a> <!-- ปุ่ม Delete พร้อมคำยืนยัน -->
                            </td>
                        </tr>
                    <?php endwhile; ?> <!-- จบลูปแสดงข้อมูล -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<!-- โหลด script สำหรับ Bootstrap -->
</body>
</html>
