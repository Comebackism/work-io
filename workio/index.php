<!doctype html>
<html lang="en">
<head>
    <!-- Meta tag ที่จำเป็น -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- ใส่ Bootstrap CSS เพื่อความสวยงาม -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" crossorigin="anonymous">
    
    <!-- ใช้ฟอนต์ Kanit เพิ่มความเป็นไทย -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;700&display=swap">
    
    <title>ระบบบันทึกเวลาการทำงาน</title>
    
    <style>
        /* ทำพื้นหลังสีเทาอ่อนๆ */
        body {
            background-color: #f8f9fa; 
            transition: background-color 0.5s, color 0.5s; /* ทำให้การเปลี่ยนสีลื่นไหล */
            font-family: 'Kanit', sans-serif; /* ใช้ฟอนต์ Kanit */
        }
        /* ตกแต่ง jumbotron ให้ดูเด่น */
        .jumbotron {
            background-color: #007bff; /* สีพื้นหลังของ jumbotron */
            color: white; /* สีตัวอักษรใน jumbotron */
            margin-bottom: 30px; /* เว้นระยะข้างล่าง */
            padding: 2rem 1rem;
            border-radius: 0.3rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* เพิ่มเงาให้ดูมิติ */
        }
        /* ไอคอนสำหรับสลับการมองเห็นพาสเวิร์ด */
        .btn-toggle-password {
            cursor: pointer; /* เปลี่ยนเคอร์เซอร์เป็นมือ */
            position: absolute;
            right: 10px;
            top: 38px;
            z-index: 2;
            color: #007bff;
        }
        /* ปุ่มสลับธีม (เช่น เปลี่ยนจากธีมสว่างไปเป็นมืด) */
        .theme-toggle {
            position: fixed;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 1.5em;
        }
        /* แสดงเวลาปัจจุบันที่มุมล่างขวา */
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
        /* ให้ปุ่มเด้งกลับเมื่อกด */
        .btn-animate {
            transition: transform 0.2s;
        }
        .btn-animate:active {
            transform: scale(0.95); /* ย่อขนาดปุ่มนิดหน่อย */
        }
        /* ตกแต่ง input ที่โฟกัส */
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        /* ธีมมืด */
        .dark-theme {
            background-color: #343a40; /* พื้นหลังสีเทาเข้ม */
            color: white; /* สีตัวอักษรขาว */
        }
        .dark-theme .jumbotron {
            background-color: #6c757d; /* jumbotron สีเทากลาง */
        }
        .dark-theme .form-control {
            background-color: #495057; /* input สีเทาเข้ม */
            color: white;
            border-color: #6c757d;
        }
        .dark-theme .form-control::placeholder {
            color: #ced4da; /* placeholder สีเทาอ่อน */
        }
        .dark-theme .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .dark-theme .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .dark-theme .btn-toggle-password {
            color: #007bff;
        }
        /* กรอบสีแดงสำหรับข้อความ */
        .alert-box {
            border: 2px solid red;
            padding: 10px;
            margin-top: 20px;
            border-radius: 5px;
            background-color: #ffe6e6; /* สีพื้นหลังอ่อนๆ */
            color: red;
            font-size: 0.9em;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- ปุ่มสลับธีม (แสดงรูปพระอาทิตย์ 🌞 หรือพระจันทร์ 🌜) -->
    <div class="theme-toggle" onclick="toggleTheme()">🌞</div>
    
    <div class="container">
        <!-- แสดงข้อความต้อนรับและชื่อระบบ -->
        <div class="row">
            <div class="col-sm-12">
                <h3 class="jumbotron text-center">ระบบบันทึกเวลาการทำงาน</h3>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- ฟอร์มล็อกอิน -->
        <div class="row justify-content-center">
            <div class="col-sm-4">
                <form id="loginForm" action="authen.php" method="post">
                    <div class="form-group">
                        <label for="m_username">รหัสพนักงาน</label>
                        <input type="text" class="form-control" id="m_username" name="m_username" placeholder="รหัสพนักงาน" minlength="2" required>
                    </div>
                    <div class="form-group position-relative">
                        <label for="m_password">รหัสผ่าน</label>
                        <input type="password" class="form-control" id="m_password" name="m_password" placeholder="รหัสผ่าน" minlength="2" required>
                        <span class="btn-toggle-password" onclick="togglePasswordVisibility()">👁️</span> <!-- ปุ่มสลับการมองเห็นรหัสผ่าน -->
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-animate">เข้าสู่ระบบ</button> <!-- ปุ่มเข้าสู่ระบบ -->
                </form>

                <!-- ข้อความในกรอบสีแดง -->
                <div class="alert-box">
                    โปรดติดต่อแอดมินเพื่อสมัครสมาชิก<br>*หากลืมรหัสผ่านให้ติดต่อแอดมิน
                </div>
            </div>
        </div>
    </div>

    <!-- แสดงเวลาปัจจุบัน -->
    <div class="time-display" id="timeDisplay"></div>

    <!-- สคริปต์ JavaScript -->
    <script>
        // ฟังก์ชันสลับการมองเห็นรหัสผ่าน
        function togglePasswordVisibility() {
            var passwordField = document.getElementById("m_password");
            var toggleButton = document.querySelector(".btn-toggle-password");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleButton.textContent = "🙈"; // เปลี่ยนไอคอนเป็นรูปหลับตา
            } else {
                passwordField.type = "password";
                toggleButton.textContent = "👁️"; // เปลี่ยนไอคอนเป็นรูปเปิดตา
            }
        }

        // ตรวจสอบการกรอกฟอร์มก่อนส่ง
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            var username = document.getElementById('m_username').value;
            var password = document.getElementById('m_password').value;
            if (username === "" || password === "") {
                event.preventDefault();
                alert("กรุณากรอกรหัสพนักงานและรหัสผ่าน");
            }
        });

        // ฟังก์ชันอัปเดตเวลา
        function updateTime() {
            var now = new Date();
            var timeDisplay = document.getElementById("timeDisplay");
            timeDisplay.textContent = now.toLocaleTimeString(); // แสดงเวลาปัจจุบัน
        }

        // ฟังก์ชันสลับธีม
        function toggleTheme() {
            var body = document.body;
            var themeToggle = document.querySelector(".theme-toggle");
            if (body.classList.contains("dark-theme")) {
                body.classList.remove("dark-theme");
                themeToggle.textContent = "🌞"; // สลับเป็นธีมสว่าง
            } else {
                body.classList.add("dark-theme");
                themeToggle.textContent = "🌜"; // สลับเป็นธีมมืด
            }
        }

        // เริ่มฟังก์ชันเมื่อหน้าเว็บโหลดเสร็จ
        document.addEventListener('DOMContentLoaded', function() {
            setInterval(updateTime, 1000); // อัปเดตเวลาทุกๆ วินาที
        });
    </script>
</body>
</html>
