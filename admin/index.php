<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
require_once '../backend/config.php';

// دریافت پیام‌ها
$messages = $conn->query("SELECT * FROM messages ORDER BY created_at DESC");

// دریافت نوبت‌ها
$bookings = $conn->query("SELECT * FROM bookings ORDER BY booking_date ASC, booking_time ASC");
?>
<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <title>داشبورد مدیریت | کلینیک دکتر اعتصامی فرد</title>
    <style>
        body { font-family: Tahoma, sans-serif; background: #f4f9f9; margin: 0; padding: 20px; }
        .container { max-width: 1200px; margin: auto; background: white; padding: 20px; border-radius: 20px; }
        h1 { color: #2c7da0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: right; }
        th { background: #2c7da0; color: white; }
        .status-pending { background: #ffc107; color: #000; padding: 3px 8px; border-radius: 20px; }
        .status-confirmed { background: #28a745; color: white; }
        .status-canceled { background: #dc3545; color: white; }
        .logout { background: #dc3545; color: white; padding: 10px 15px; text-decoration: none; border-radius: 8px; display: inline-block; margin-bottom: 20px; }
    </style>
</head>
<body>
<div class="container">
    <a href="logout.php" class="logout">خروج از پنل</a>
    <h1>پنل مدیریت کلینیک دکتر اعتصامی فرد</h1>
    
    <h2>پیام‌های تماس</h2>
    <table>
        <tr><th>نام</th><th>شماره تماس</th><th>ایمیل</th><th>پیام</th><th>زمان</th></tr>
        <?php while($row = $messages->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
            <td><?= $row['created_at'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <h2>نوبت‌های رزرو شده</h2>
    <table>
        <tr><th>نام کامل</th><th>شماره تماس</th><th>تاریخ</th><th>ساعت</th><th>توضیحات</th><th>وضعیت</th></tr>
        <?php while($row = $bookings->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['full_name']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td><?= $row['booking_date'] ?></td>
            <td><?= $row['booking_time'] ?></td>
            <td><?= htmlspecialchars($row['description']) ?></td>
            <td><span class="status-<?= $row['status'] ?>"><?= $row['status'] ?></span></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
