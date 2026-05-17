<?php
session_start();
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    // نام کاربری و رمز عبور ساده - بعداً می‌توانید تغییر دهید
    if ($username === 'admin' && password_verify($password, password_hash('clinic2025', PASSWORD_DEFAULT))) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: index.php');
        exit;
    } else {
        // برای بررسی واقعی باید از هش استفاده کنید، ولی فعلاً ساده
        if (!($username === 'admin' && $password === 'clinic2025')) {
            $error = 'نام کاربری یا رمز عبور اشتباه است.';
        }
    }
}
?>
<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <title>ورود به پنل مدیریت | کلینیک دکتر اعتصامی فرد</title>
    <style>
        body { font-family: Tahoma, sans-serif; background: #f0f2f5; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .login-box { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); width: 300px; text-align: center; }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 8px; }
        button { background: #2c7da0; color: white; border: none; padding: 10px; width: 100%; border-radius: 8px; cursor: pointer; }
        .error { color: red; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>ورود به پنل مدیریت</h2>
        <?php if($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
        <form method="post">
            <input type="text" name="username" placeholder="نام کاربری" required>
            <input type="password" name="password" placeholder="رمز عبور" required>
            <button type="submit">ورود</button>
        </form>
    </div>
</body>
</html>
