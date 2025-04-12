<?php
// اطلاعات اتصال به دیتابیس
$host = "localhost";
$username = "root";
$password = ""; // اگر رمز گذاشتی، اینجا واردش کن
$database = "dars"; // مثل: my_users_db

// اتصال به MySQL
$conn = new mysqli($host, $username, $password, $database);

// بررسی اتصال
if ($conn->connect_error) {
    die("خطا در اتصال به پایگاه‌داده: " . $conn->connect_error);
}

// // گرفتن اطلاعات از فرم
$fullname = $_GET['fullname'] ?? '';
$mobile   = $_GET['mobile'] ?? '';
$username = $_GET['username'] ?? '';
$email    = $_GET['email'] ?? '';
$password = $_GET['password'] ?? ''; // دقت کن: فیلد form باید name="password" باشه


// اعتبارسنجی ساده
if (empty($fullname) || empty($mobile) || empty($username) || empty($email) || empty($password)) {
    echo "لطفاً تمام فیلدها را پر کنید.";
    exit;
}

// جلوگیری از حملات
$fullname = mysqli_real_escape_string($conn, $fullname);
$mobile   = mysqli_real_escape_string($conn, $mobile);
$username = mysqli_real_escape_string($conn, $username);
$email    = mysqli_real_escape_string($conn, $email);
$password = mysqli_real_escape_string($conn, $password);

// هش کردن رمز عبور (پیشنهاد امنیتی)
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// بررسی تکراری نبودن ایمیل
$checkSql = "SELECT * FROM user WHERE email='$email'";
$checkResult = $conn->query($checkSql);

if ($checkResult->num_rows > 0) {
    echo "این ایمیل قبلاً ثبت‌نام کرده است.";
    exit;
}

// درج در جدول
$insertSql = "INSERT INTO user (fullname, mobile, username, email, password)
              VALUES ('$fullname', '$mobile', '$username', '$email', '$hashedPassword')";

if ($conn->query($insertSql) === TRUE) {
    echo "ثبت‌نام با موفقیت انجام شد!";
    // می‌تونی بعدش ریدایرکت هم کنی:
        header("Location: index.html");
    // <meta http-equiv=\"refresh\" content=\"2; url=index.html\">
 } 
//  else {
//     echo "خطا در ثبت اطلاعات: " . $conn->error;
// }

$conn->close();
?>
