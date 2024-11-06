<?php
session_start(); // เริ่มต้น session ใช้สำหรับเก็บข้อมูลผู้ใช้งานขณะออนไลน์
include('condb.php'); // เรียกใช้ไฟล์เชื่อมต่อฐานข้อมูล

// ตรวจสอบว่าผู้ใช้ล็อกอินหรือยัง และตรวจสอบว่าระดับผู้ใช้เป็น 'staff' หรือเปล่า
if (!isset($_SESSION['m_id']) || $_SESSION['m_level'] != 'staff') {
    header("Location: logout.php"); // ถ้าไม่ใช่ พาไปหน้า logout เพื่อออกจากระบบ
    exit(); // หยุดการทำงานของสคริปต์หลังจากเปลี่ยนหน้า
}

// ดึงข้อมูลของผู้ใช้จากฐานข้อมูล
$m_id = $_SESSION['m_id']; // เอา ID ผู้ใช้จาก session มาใช้
$queryemp = "SELECT * FROM tbl_emp WHERE m_id=$m_id"; // สร้างคำสั่ง SQL เพื่อดึงข้อมูลพนักงานจากฐานข้อมูล
$resultm = mysqli_query($condb, $queryemp) or die("Error in query: $queryemp " . mysqli_error($condb)); // รันคำสั่ง SQL และจัดการ error ถ้ามี
$rowm = mysqli_fetch_array($resultm); // เอาผลลัพธ์ที่ได้มาเก็บในตัวแปร $rowm
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8"> <!-- กำหนด charset เป็น UTF-8 เพื่อรองรับการแสดงผลภาษาไทย -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> <!-- กำหนดให้หน้าเว็บ responsive -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> <!-- ลิงค์ไปยัง Bootstrap CSS เพื่อใช้จัดหน้าเว็บ -->
    <!-- Kanit Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;700&display=swap"> <!-- ใช้ฟอนต์ Kanit จาก Google Fonts -->
    <title>ระบบบันทึกเวลาการทำงาน</title> <!-- ชื่อหน้าเว็บ -->
    <style>
        body {
            background-color: #f8f9fa; /* สีพื้นหลังของเว็บ */
            transition: background-color 0.5s, color 0.5s; /* เพิ่มเอฟเฟ็กต์ตอนเปลี่ยนสีธีม */
            font-family: 'Kanit', sans-serif; /* ใช้ฟอนต์ Kanit */
        }
        .jumbotron {
            background-color: #007bff; /* สีพื้นหลังของ jumbotron */
            color: white; /* สีข้อความใน jumbotron */
            margin-bottom: 30px; /* ระยะห่างจากด้านล่าง */
            padding: 2rem 1rem;
            border-radius: 0.3rem; /* ทำให้ขอบมน */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* เพิ่มเงา */
        }
        .btn-toggle-password {
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 38px;
            z-index: 2;
            color: #007bff; /* สีไอคอนสลับการแสดงผลรหัสผ่าน */
        }
        .theme-toggle {
            position: fixed;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 1.5em; /* ขนาดไอคอนสลับธีม */
        }
        .time-display {
            position: fixed;
            bottom: 10px;
            right: 10px;
            font-size: 1.2em; /* ขนาดข้อความที่แสดงเวลา */
            background-color: rgba(0, 0, 0, 0.1); /* สีพื้นหลังแบบโปร่งใส */
            padding: 5px 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* เพิ่มเงาให้ดูนูนขึ้น */
        }
        .btn-animate {
            transition: transform 0.2s; /* เพิ่มเอฟเฟ็กต์เวลาคลิกปุ่ม */
        }
        .btn-animate:active {
            transform: scale(0.95); /* ทำให้ปุ่มยุบเล็กน้อยเวลาคลิก */
        }
        .form-control:focus {
            border-color: #007bff; /* สีเส้นขอบตอนคลิกฟอร์ม */
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25); /* เงาที่เกิดขึ้นตอนโฟกัสฟอร์ม */
        }
        .dark-theme {
            background-color: #343a40; /* สีพื้นหลังในธีมมืด */
            color: white; /* สีข้อความในธีมมืด */
        }
        .dark-theme .jumbotron {
            background-color: #6c757d; /* สี jumbotron ในธีมมืด */
        }
        .dark-theme .form-control {
            background-color: #495057; /* สีฟอร์มในธีมมืด */
            color: white;
            border-color: #6c757d;
        }
        .dark-theme .form-control::placeholder {
            color: #ced4da; /* สี placeholder ในธีมมืด */
        }
        .dark-theme .btn-primary {
            background-color: #007bff; /* สีปุ่มในธีมมืด */
            border-color: #007bff;
        }
        .dark-theme .btn-primary:hover {
            background-color: #0056b3; /* สีปุ่มเมื่อ hover ในธีมมืด */
            border-color: #004085;
        }
        .dark-theme .btn-toggle-password {
            color: #007bff; /* สีไอคอนสลับรหัสผ่านในธีมมืด */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="jumbotron text-center">
            <h3>ระบบบันทึกเวลาการทำงาน</h3> <!-- หัวข้อของหน้า -->
        </div>
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="text-center">
                    <img src="img/<?php echo $rowm['m_img']; ?>" class="img-fluid rounded-circle mb-3" alt="User Image"> <!-- รูปโปรไฟล์ของผู้ใช้ -->
                    <h5><b><?php echo $rowm['m_firstname'] . ' ' . $rowm['m_name'] . ' ' . $rowm['m_lastname']; ?></b></h5> <!-- ชื่อผู้ใช้ -->
                    <p>ตำแหน่ง: <?php echo $rowm['m_position']; ?></p> <!-- ตำแหน่งของผู้ใช้ -->
                </div>
                <div class="list-group">
                    <a href="profile.php" class="list-group-item list-group-item-action active">หน้าหลัก</a> <!-- ลิงค์ไปหน้าหลัก -->
                    <a href="job.php" class="list-group-item list-group-item-action">งาน</a> <!-- ลิงค์ไปหน้าจัดการงาน -->
                    <a href="logout.php" class="list-group-item list-group-item-danger" onclick="return confirm('ต้องการออกจากระบบ?');">ออกจากระบบ</a> <!-- ลิงค์ไปหน้าล็อกเอาต์ -->
                </div>
            </div>

            <div class="col-md-9">
                <h3>List Job
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">+ Job</button> <!-- ปุ่มสำหรับเพิ่มงานใหม่ -->
                </h3>
                <?php
                // Query ข้อมูลงานที่เกี่ยวข้องกับผู้ใช้ปัจจุบัน
                $queryjob = "SELECT * FROM tbl_job WHERE ref_m_id = $m_id ORDER BY id DESC"; // ดึงข้อมูลงานจากฐานข้อมูล
                $rs = mysqli_query($condb, $queryjob) or die("Error: " . mysqli_error($condb)); // รันคำสั่ง SQL และจัดการ error ถ้ามี
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th width="5%">#</th> <!-- คอลัมน์ลำดับ -->
                                <th width="40%">Job Detail</th> <!-- คอลัมน์รายละเอียดงาน -->
                                <th width="30%">Job Remark</th> <!-- คอลัมน์ข้อสังเกตงาน -->
                                <th width="10%">Job By</th> <!-- คอลัมน์ผู้สั่งงาน -->
                                <th width="15%">Date</th> <!-- คอลัมน์วันที่ -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($rs as $row) { // วนลูปแสดงข้อมูลงาน
                                echo "<tr>";
                                echo "<td>" . $row["id"] . "</td>"; // แสดงลำดับ
                                echo "<td>" . $row["job_detail"] . "</td>"; // แสดงรายละเอียดงาน
                                echo "<td>" . $row["job_remark"] . "</td>"; // แสดงข้อสังเกตงาน
                                echo "<td>" . $row["job_by"] . "</td>"; // แสดงผู้สั่งงาน
                                echo "<td>" . date('d/m/Y', strtotime($row["date_save"])) . "</td>"; // แสดงวันที่บันทึกงาน
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal สำหรับเพิ่มงานใหม่ -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">บันทึกการทำงาน</h5> <!-- หัวข้อของ Modal -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span> <!-- ปุ่มปิด Modal -->
                    </button>
                </div>
                <div class="modal-body">
                    <form action="save_job.php" method="post"> <!-- ฟอร์มบันทึกงานใหม่ -->
                        <div class="form-group">
                            <label class="col-form-label">Job Detail:</label>
                            <textarea class="form-control" name="job_detail" required minlength="3"></textarea> <!-- ช่องกรอกข้อมูลรายละเอียดงาน -->
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Job Remark:</label>
                            <textarea class="form-control" name="job_remark" required minlength="3"></textarea> <!-- ช่องกรอกข้อสังเกตงาน -->
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Job By:</label>
                            <input type="text" name="job_by" class="form-control" required minlength="3" placeholder="ชื่อผู้สั่งงาน"> <!-- ช่องกรอกชื่อผู้สั่งงาน -->
                        </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="m_id" value="<?php echo $m_id; ?>"> <!-- เก็บค่า ID ของผู้ใช้ในฟอร์ม -->
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> <!-- ปุ่มปิด Modal -->
                    <button type="submit" class="btn btn-success">Save</button> <!-- ปุ่มบันทึกงานใหม่ -->
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> <!-- ลิงค์ไปยัง jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script> <!-- ลิงค์ไปยัง Popper.js -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script> <!-- ลิงค์ไปยัง Bootstrap JS -->
</body>
</html>
