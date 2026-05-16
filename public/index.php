<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    echo "سلام $name! داده با موفقیت دریافت شد.";
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>فرم PHP</title>
</head>
<body>
    <form method="post">
        <input type="text" name="name" placeholder="نام شما">
        <button type="submit">ارسال</button>
    </form>
</body>
</html>
