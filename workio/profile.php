<?php
session_start(); // เริ่มต้น session เพื่อเก็บข้อมูลของผู้ใช้งาน
include('condb.php'); // รวมไฟล์ที่เชื่อมต่อกับฐานข้อมูล

$m_id = $_SESSION['m_id']; // เก็บค่า ID ของผู้ใช้จาก session
$m_level = $_SESSION['m_level']; // เก็บระดับการเข้าถึงของผู้ใช้จาก session

// ถ้าผู้ใช้ไม่ได้เป็น staff ก็จะพาไปหน้า logout เพื่อออกจากระบบ
if ($m_level != 'staff') {
    header("Location: logout.php"); // เปลี่ยนเส้นทางไปที่หน้า logout.php
    exit(); // หยุดการทำงานของสคริปต์ตรงนี้
}

$queryemp = "SELECT * FROM tbl_emp WHERE m_id=$m_id"; // สร้างคำสั่ง SQL เพื่อดึงข้อมูลผู้ใช้จากตาราง tbl_emp ที่มี id ตรงกับ $m_id
$resultm = mysqli_query($condb, $queryemp) or die("Error in query: $queryemp " . mysqli_error($condb)); // รันคำสั่ง SQL และเก็บผลลัพธ์ไว้ใน $resultm
$rowm = mysqli_fetch_array($resultm); // แปลงผลลัพธ์ที่ได้เป็น array และเก็บไว้ใน $rowm

$timenow = date('H:i:s'); // เก็บเวลาปัจจุบันในรูปแบบ ชั่วโมง:นาที:วินาที
$datenow = date('Y-m-d'); // เก็บวันที่ปัจจุบันในรูปแบบ ปี-เดือน-วัน

$queryworkio = "SELECT MAX(workdate) as lastdate, workin, workout FROM tbl_work_io WHERE m_id=$m_id AND workdate='$datenow'"; // สร้างคำสั่ง SQL เพื่อดึงข้อมูลการเข้างาน-ออกงานของผู้ใช้ในวันปัจจุบัน
$resultio = mysqli_query($condb, $queryworkio) or die("Error in query: $queryworkio " . mysqli_error($condb)); // รันคำสั่ง SQL และเก็บผลลัพธ์ไว้ใน $resultio
$rowio = mysqli_fetch_array($resultio); // แปลงผลลัพธ์ที่ได้เป็น array และเก็บไว้ใน $rowio
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Kanit Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;700&display=swap">
    <title>ระบบบันทึกเวลาการทำงาน</title>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Kanit', sans-serif;
        }
        .jumbotron {
            background-color: #007bff;
            color: white;
            margin-bottom: 30px;
            padding: 2rem 1rem;
            border-radius: 0.3rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .time-display {
            position: fixed;
            bottom: 10px;
            right: 10px;
            font-size: 1.2em;
            background-color: rgba(0, 0, 0, 0.1);
            padding: 5px 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        .btn-animate {
            transition: transform 0.2s;
        }
        .btn-animate:active {
            transform: scale(0.95);
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        .dark-theme {
            background-color: #343a40;
            color: white;
        }
        .dark-theme .jumbotron {
            background-color: #6c757d;
        }
        .dark-theme .form-control {
            background-color: #495057;
            color: white;
            border-color: #6c757d;
        }
        .dark-theme .form-control::placeholder {
            color: #ced4da;
        }
        .dark-theme .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .dark-theme .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
</head>
<body>
<div class="container"> <!-- กำหนด container สำหรับจัดระเบียบเนื้อหาในหน้า -->
        <div class="jumbotron text-center"> <!-- ใช้ jumbotron เพื่อแสดงหัวข้อหลักของเว็บ -->
            <h3>ระบบบันทึกเวลาการทำงาน</h3>
        </div>
        <div class="row"> <!-- สร้างแถวสำหรับจัดเนื้อหาในคอลัมน์ต่างๆ -->
            <div class="col-md-3 mb-4"> <!-- คอลัมน์ที่ 1 ที่มีขนาด 3 ส่วนจากทั้งหมด 12 -->
                <div class="text-center"> <!-- กำหนดเนื้อหาให้จัดอยู่ตรงกลาง -->
                    <img src="img/<?php echo $rowm['m_img']; ?>" class="img-fluid rounded-circle mb-3" alt="User Image"> <!-- แสดงรูปโปรไฟล์ของผู้ใช้ -->
                    <h5><b><?php echo $rowm['m_firstname'] . ' ' . $rowm['m_name'] . ' ' . $rowm['m_lastname']; ?></b></h5> <!-- แสดงชื่อเต็มของผู้ใช้ -->
                    <p>ตำแหน่ง: <?php echo $rowm['m_position']; ?></p> <!-- แสดงตำแหน่งของผู้ใช้ -->
                </div>
                <div class="list-group"> <!-- สร้างกลุ่มลิงค์เมนู -->
                    <a href="profile.php" class="list-group-item list-group-item-action active">หน้าหลัก</a> <!-- เมนูหน้าหลัก -->
                    <a href="job.php" class="list-group-item list-group-item-action">งาน</a> <!-- เมนูงาน -->
                    <a href="logout.php" class="list-group-item list-group-item-danger" onclick="return confirm('ต้องการออกจากระบบ?');">ออกจากระบบ</a> <!-- เมนูออกจากระบบ -->
                </div>
            </div>

            <div class="col-md-9"> <!-- คอลัมน์ที่ 2 ที่มีขนาด 9 ส่วนจากทั้งหมด 12 -->
                <h3>ลงเวลาเข้า-ออกงาน <?php echo date('d-m-Y'); ?></h3> <!-- แสดงวันที่ปัจจุบัน -->
                <form action="save.php" method="post" class="form-horizontal"> <!-- ฟอร์มสำหรับบันทึกเวลาเข้า-ออกงาน -->
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="m_id">รหัสพนักงาน</label>
                            <input type="text" class="form-control" name="m_id" value="<?php echo $rowm['m_id']; ?>" readonly> <!-- แสดงรหัสพนักงานแบบอ่านอย่างเดียว -->
                        </div>
                        <div class="form-group col-md-3">
                            <label for="workin">เวลาเข้างาน</label>
                            <?php if (isset($rowio['workin'])) { ?> <!-- ถ้ามีการบันทึกเวลาเข้าแล้ว -->
                                <input type="text" class="form-control" name="workin" value="<?php echo $rowio['workin']; ?>" disabled> <!-- แสดงเวลาเข้างานที่บันทึกแล้ว -->
                            <?php } else { ?> <!-- ถ้ายังไม่มีการบันทึกเวลาเข้า -->
                                <input type="text" class="form-control" name="workin" value="<?php echo date('H:i:s'); ?>" readonly> <!-- แสดงเวลาเข้าเป็นเวลาปัจจุบัน -->
                            <?php } ?>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="workout">เวลาออกงาน</label>
                            <?php
                            if ($timenow > '17:00:00') { // ถ้าเวลาปัจจุบันเกิน 17:00 น.
                                if (isset($rowio['workout'])) { ?> <!-- ถ้ามีการบันทึกเวลาออกแล้ว -->
                                    <input type="text" class="form-control" name="workout" value="<?php echo $rowio['workout']; ?>" disabled> <!-- แสดงเวลาออกงานที่บันทึกแล้ว -->
                                <?php } else { ?> <!-- ถ้ายังไม่มีการบันทึกเวลาออก -->
                                    <input type="text" class="form-control" name="workout" value="<?php echo date('H:i:s'); ?>" readonly> <!-- แสดงเวลาออกเป็นเวลาปัจจุบัน -->
                                <?php }
                            } else { // ถ้าเวลาปัจจุบันยังไม่เกิน 17:00 น.
                                echo '<br><font color="red">หลัง 17:00 น.</font>'; // แสดงข้อความว่าให้ลงเวลาออกหลัง 17:00 น.
                            }
                            ?>
                        </div>
                        <div class="form-group col-md-3 align-self-end">
                            <button type="submit" class="btn btn-primary btn-animate">บันทึก</button> <!-- ปุ่มบันทึกข้อมูล -->
                        </div>
                    </div>
                </form>

                <h3>รายการทำงาน</h3> <!-- หัวข้อแสดงรายการบันทึกเวลางาน -->
                <?php
                $querylist = "SELECT * FROM tbl_work_io WHERE m_id = $m_id ORDER BY workdate DESC"; // คำสั่ง SQL เพื่อดึงข้อมูลการบันทึกเวลางานของผู้ใช้เรียงจากวันที่ล่าสุดไปก่อน
                $resultlist = mysqli_query($condb, $querylist) or die("Error: " . mysqli_error($condb)); // รันคำสั่ง SQL และเก็บผลลัพธ์ไว้ใน $resultlist
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped"> <!-- ตารางแสดงรายการบันทึกเวลางาน -->
                        <thead class="thead-dark">
                            <tr>
                                <th>วันที่</th>
                                <th>เวลาเข้า</th>
                                <th>เวลาออก</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($resultlist as $value) { // วนลูปแสดงข้อมูลแต่ละแถวในตาราง
                                echo "<tr>";
                                echo "<td>" . $value["workdate"] .  "</td>"; // แสดงวันที่
                                echo "<td>" . $value["workin"] .  "</td>"; // แสดงเวลาเข้า
                                echo "<td>" . $value["workout"] .  "</td>"; // แสดงเวลาออก
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> <!-- ลิงค์ไปยังไฟล์ jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script> <!-- ลิงค์ไปยังไฟล์ Popper.js -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script> <!-- ลิงค์ไปยังไฟล์ Bootstrap JS -->
</body>
</html>
