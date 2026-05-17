<?php
header('Content-Type: application/json');
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'درخواست نامعتبر']);
    exit;
}

$full_name = trim($_POST['full_name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$booking_date = trim($_POST['booking_date'] ?? '');
$booking_time = trim($_POST['booking_time'] ?? '');
$description = trim($_POST['description'] ?? '');

// اعتبارسنجی
if (empty($full_name) || empty($phone) || empty($booking_date) || empty($booking_time)) {
    echo json_encode(['success' => false, 'message' => 'لطفاً همه فیلدهای الزامی را پر کنید']);
    exit;
}

// بررسی عدم تداخل نوبت (اختیاری، ساده)
$check = $conn->prepare("SELECT id FROM bookings WHERE booking_date = ? AND booking_time = ? AND status != 'canceled'");
$check->bind_param("ss", $booking_date, $booking_time);
$check->execute();
$result = $check->get_result();
if ($result->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'متأسفانه این زمان قبلاً رزرو شده است. زمان دیگری انتخاب کنید.']);
    $check->close();
    $conn->close();
    exit;
}
$check->close();

// ذخیره نوبت
$stmt = $conn->prepare("INSERT INTO bookings (full_name, phone, booking_date, booking_time, description, status) VALUES (?, ?, ?, ?, ?, 'pending')");
$stmt->bind_param("sssss", $full_name, $phone, $booking_date, $booking_time, $description);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'نوبت شما با موفقیت ثبت شد. همکاران ما برای تأیید نهایی با شما تماس می‌گیرند.']);
} else {
    echo json_encode(['success' => false, 'message' => 'خطا در ثبت نوبت. لطفاً دوباره تلاش کنید.']);
}
$stmt->close();
$conn->close();
?>
