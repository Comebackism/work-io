<?php
$condb= mysqli_connect("localhost","root","","66309010028") or die("Error: " . mysqli_error($condb)); 
// เชื่อมต่อกับฐานข้อมูล MySQL ที่รันอยู่บน localhost โดยใช้ username คือ "root" และ password ว่าง (ไม่มี)
// ถ้าเชื่อมต่อไม่สำเร็จ จะแสดงข้อความ "Error" พร้อมรายละเอียดของข้อผิดพลาด

mysqli_query($condb, "SET NAMES 'utf8' "); 
// ตั้งค่าการเชื่อมต่อให้รองรับการใช้งานภาษาไทยหรือภาษาอื่น ๆ ที่ใช้ชุดตัวอักษร UTF-8

date_default_timezone_set('Asia/Bangkok'); 
// ตั้งค่าเขตเวลาของเซิร์ฟเวอร์ให้เป็นเวลาในโซน Asia/Bangkok (ประเทศไทย)
?>
