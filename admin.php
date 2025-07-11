<?php
session_start();

// كلمة المرور
define('PAGE_PASSWORD', 'Mwed9@!kdfgM');

// تحقق من الجلسة
if (!isset($_SESSION['authorized'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!empty($_POST['password']) && $_POST['password'] === PAGE_PASSWORD) {
            $_SESSION['authorized'] = true;
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $error = "كلمة المرور خاطئة";
        }
    }
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

// 🧭 هنا نستدعي ./actions/get_users.php ونلتقط ناتجه
$_GET['action'] = 'getAll';

ob_start(); // ابدأ الالتقاط
include './actions/get_users.php';
$response = ob_get_clean();

$data = json_decode($response, true);

$users = [];
if ($data && $data['status'] === 'success') {
    $users = $data['data'];
} else {
    $error = $data['message'] ?? 'خطأ غير معروف عند جلب المستخدمين';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mechanism Bridge Co.</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles.css">
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
                <li><a href="./#share">شاركنا</a></li>
                <li><a href="./#about">عن ميكانزم بريدج</a></li>
            </ul>
        </nav>
        <div class="actions">
            <div class="signup" onclick="window.location.href='./profile.html'">حسابي</div>
            <div class="login" onclick="window.location.href='./logout.php'">تسجيل خروج</div>
        </div>
    </header>

    <div class="hero profile">
        <img src="imgs/transparent-th.png" alt="">
        <div class="users-list">
            <h3>المستخدمون المسجلون:</h3>
            <table id="users-table" style="margin:auto;text-align:center;border-collapse:collapse;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>الاسم</th>
                        <th>الإيميل</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user['id']) ?></td>
                                <td><?= htmlspecialchars($user['name']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3"><?= htmlspecialchars($error ?? 'لا يوجد مستخدمون') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer class="footer">
        <p>جميع الحقوق محفوظة &copy; 2025 ميكانزم بريدج</p>
    </footer>

</body>

</html>