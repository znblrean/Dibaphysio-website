<?php
// تنظیمات دیتابیس - این مقادیر را با اطلاعات هاست خودت جایگزین کن
define('DB_HOST', 'localhost');
define('DB_USER', 'your_db_username');
define('DB_PASS', 'your_db_password');
define('DB_NAME', 'your_db_name');

// ایجاد اتصال به دیتابیس
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// بررسی اتصال
if ($conn->connect_error) {
    die("اتصال به دیتابیس失敗: " . $conn->connect_error);
}

// تنظیم کاراکتر set به UTF-8 برای پشتیبانی از فارسی
$conn->set_charset("utf8mb4");
?>
