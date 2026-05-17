<?php
header('Content-Type: application/json');
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'درخواست نامعتبر']);
    exit;
}

// دریافت و پالایش داده‌ها
$name = trim($_POST['name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

// اعتبارسنجی ساده
if (empty($name) || empty($phone) || empty($message)) {
    echo json_encode(['success' => false, 'message' => 'لطفاً نام، شماره تماس و متن پیام را وارد کنید']);
    exit;
}

// جلوگیری از SQL Injection
$stmt = $conn->prepare("INSERT INTO messages (name, phone, email, message) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $phone, $email, $message);

if ($stmt->execute()) {
    // (اختیاری) ارسال ایمیل به مدیر سایت – می‌توانید بعداً اضافه کنید
    echo json_encode(['success' => true, 'message' => 'پیام شما با موفقیت ارسال شد. در اسرع وقت تماس می‌گیریم.']);
} else {
    echo json_encode(['success' => false, 'message' => 'خطا در ثبت پیام. لطفاً دوباره تلاش کنید.']);
}
$stmt->close();
$conn->close();
?>
