<?php
session_start();

// اضبط كلمة المرور هنا
define('PAGE_PASSWORD', 'mechanism123');

// تحقق من جلسة تسجيل الدخول
if (!isset($_SESSION['authorized'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!empty($_POST['password']) && $_POST['password'] === PAGE_PASSWORD) {
            $_SESSION['authorized'] = true;
            header("Location: ".$_SERVER['PHP_SELF']);
            exit;
        } else {
            $error = "كلمة المرور خاطئة";
        }
    }

    // نموذج تسجيل الدخول
    ?>
    <!DOCTYPE html>
    <html lang="ar">
    <head>
        <meta charset="UTF-8">
        <title>حماية الصفحة</title>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    </head>
    <body style="font-family:Cairo,sans-serif;text-align:center;margin-top:50px;">
        <h2>الرجاء إدخال كلمة المرور للدخول</h2>
        <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="POST">
            <input type="password" name="password" placeholder="كلمة المرور" required>
            <button type="submit">دخول</button>
        </form>
    </body>
    </html>
    <?php
    exit;
}
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/v4-shims.min.css">
    <title>Mechanism Bridge Co.</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/styles.css">
    <!-- iconfav -->
    <link rel="icon" href="/imgs/mechanismbridge.svg" type="image/png">
</head>

<body>
    <header>
        <div onclick="window.location.href='./'" class="logo">
            <img src="imgs/mechanismbridge.svg" alt="">
        

        </div>
        <nav>
            <ul class="nav-links">
                <li><a href="./#why">لماذا ميكانزم بريدج؟</a></li>
                <li><a href="./#how">كيفية التسجيل</a></li>
                <!-- <li><a href="./#much">أرقامنا</a></li> -->
                <li><a href="./#share">شاركنا</a></li>
                <li><a href="./#about">عن ميكانزم بريدج</a></li>
            </ul>
        </nav>
        <div class="actions">
            <div class="signup" onclick="window.location.href='./profile.html'">حسابي</div>
            <div class="login" onclick="window.location.href='./logout.php'">تسجيل خروج</div>
        </div>
        <div class="lang">
            <div class="lang-ar">عربي</div>
            <div class="lang-en">English</div>
            <i class="icon fa fa-globe mx-1"></i>
        </div>
    </header>
    <div class="hero profile">
        <img src="imgs/transparent-th.png" alt="">
        <h1>شكرا لك لتسجيلك معنا</h1>
        <h2>سنتواصل معك لحظة بدء الفرص</h2>
    </div>
    <footer class="footer">
        <div class="footer-content">
            <p>جميع الحقوق محفوظة &copy; 2025 ميكانزم بريدج</p>
            <ul class="social-links">
                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                <!-- whatsapp -->
                <li><a href="https://api.whatsapp.com/send?phone=966542399527" target="_blank"><i
                            class="fab fa-whatsapp"></i></a></li>
            </ul>
        </div>
    </footer>
    <script src="assets/script.js"></script>

</body>

</html>