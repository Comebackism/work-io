<?php 
session_start(); // เริ่มต้น session เพื่อให้สามารถเก็บข้อมูลระหว่างหน้าเว็บได้
        if(isset($_POST['m_username'])){ // ตรวจสอบว่ามีการส่งค่า username มาจากฟอร์มหรือยัง
                  include("condb.php"); // เชื่อมต่อกับฐานข้อมูลโดยใช้ไฟล์ condb.php
                  $m_username = mysqli_real_escape_string($condb,$_POST['m_username']); // รับค่า username จากฟอร์มและป้องกัน SQL Injection
                  $m_password = mysqli_real_escape_string($condb,sha1($_POST['m_password'])); // รับค่า password จากฟอร์ม, เข้ารหัสด้วย sha1 และป้องกัน SQL Injection

                  $sql="SELECT * FROM tbl_emp 
                  WHERE  m_username='".$m_username."'  AND  m_password='".$m_password."' "; // สร้างคำสั่ง SQL เพื่อเช็คว่ามีผู้ใช้ที่มี username และ password ตรงกันในฐานข้อมูลหรือไม่

                  $result = mysqli_query($condb,$sql); // รันคำสั่ง SQL และเก็บผลลัพธ์ไว้ใน $result
				
                  if(mysqli_num_rows($result)==1){ // ถ้าพบผู้ใช้ 1 รายที่ตรงกับข้อมูลที่กรอกมา

                      $row = mysqli_fetch_array($result); // ดึงข้อมูลผู้ใช้มาเก็บไว้ใน $row

                      $_SESSION["m_id"] = $row["m_id"]; // เก็บ ID ของผู้ใช้ใน session
                      $_SESSION["m_level"] = $row["m_level"]; // เก็บระดับผู้ใช้ใน session

                      if($_SESSION["m_level"]=="admin"){ 
                       Header("Location: admin.php"); // ถ้าผู้ใช้เป็น admin ให้เด้งไปหน้า admin.php
                      }
                      if($_SESSION["m_level"]=="staff"){
                        Header("Location: profile.php"); // ถ้าผู้ใช้เป็น staff ให้เด้งไปหน้า profile.php
                      }
                  }else{ // ถ้าไม่พบผู้ใช้ที่ตรงกับข้อมูลที่กรอกมา
                    echo "<script>";
                        echo "alert(\" user หรือ  password ไม่ถูกต้อง\");";  // แจ้งเตือนว่าข้อมูลไม่ถูกต้อง
                        echo "window.history.back()"; // เด้งกลับไปที่หน้าเดิม
                    echo "</script>";

                  }

        }else{
             Header("Location: index.php"); // ถ้าไม่มีการกรอกข้อมูล ให้เด้งกลับไปที่หน้า login (index.php)
        }
?>
