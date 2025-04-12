<?php
// اتصال به پایگاه‌داده MySQL
$host = "localhost";
$username = "root";
$password = ""; // اگر رمز داری اینجا بنویس
$database = "dars"; // اینو خودت وارد کن

$conn = new mysqli($host, $username, $password, $database);

// بررسی اتصال
if ($conn->connect_error) {
    die("اتصال به پایگاه‌داده انجام نشد: " . $conn->connect_error);
}

// گرفتن اطلاعات از فرم
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// جلوگیری از حمله SQL Injection
$email = mysqli_real_escape_string($conn, $email);
$password = mysqli_real_escape_string($conn, $password);

// بررسی اعتبارسنجی اولیه
if (empty($email) || empty($password)) {
    echo "لطفاً همه فیلدها را پر کنید.";
    exit;
}

// جستجوی کاربر در جدول (نام جدول رو خودت بزار)
$sql = "SELECT * FROM user WHERE email='$email' LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // بررسی رمز عبور (اگر با رمز هش‌شده ذخیره کردی از password_verify استفاده کن)
    if ($password === $user['password']) {
        // ورود موفق
        echo "ورود موفقیت‌آمیز بود. خوش آمدید " . $user['fullname'];
        // اینجا می‌تونی جلسه (session) هم راه بندازی
    } else {
        echo "رمز عبور اشتباه است.";
    }
} else {
    echo "کاربری با این ایمیل یافت نشد.";
}

$conn->close();
?>
