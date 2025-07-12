<?php
session_start();

// كلمة المرور
define('PAGE_PASSWORD', 'Mwed9@!kdfgM');

// تحقق من الجلسة
if (!isset($_SESSION['authorized'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!empty($_POST['password']) && $_POST['password'] === PAGE_PASSWORD) {
            $_SESSION['authorized'] = true;
            header("Location: ad.php");
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

$users = getAllUsers($mysqli)['data'];
// $users = [
//     [
//         'id' => 1,
//         'username' => 'أحمد محمد',
//         'phone' => '0501234567',
//         'commercial_id' => '1012345678',
//         'created_at' => '2024-01-15 10:30:00',
//         'city' => 'الرياض'
//     ],
//     [
//         'id' => 2,
//         'username' => 'سارة علي',
//         'phone' => '0539876543',
//         'commercial_id' => '1098765432',
//         'created_at' => '2024-02-20 14:45:00',
//         'city' => 'جدة'
//     ],
//     [
//         'id' => 3,
//         'username' => 'محمد عبد الله',
//         'phone' => '0557654321',
//         'commercial_id' => '1023456789',
//         'created_at' => '2024-03-05 09:15:00',
//         'city' => 'الدمام'
//     ]
// ];


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

    <div class="hero admin">
        <img src="imgs/transparent-th.png" alt="">
        <div class="users-list">
            <h3>المستخدمون المسجلون:</h3>
            <table id="users-table" style="margin:auto;text-align:center;border-collapse:collapse;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>الاسم</th>
                        <th>رقم الجوال</th>
                        <th>رقم السجل</th>
                        <th>المدينة</th>
                        <th>تاريخ التسجيل</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    <?php if (isset($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user['id']) ?></td>
                                <td><?= htmlspecialchars($user['username']) ?></td>
                                <td><?= htmlspecialchars($user['phone']) ?></td>
                                <td><?= htmlspecialchars($user['commercial_id']) ?></td>
                                <td><?= htmlspecialchars($user['city']) ?></td>
                                <td><?= htmlspecialchars($user['created_at']) ?></td>
                                <td>
                                    <button class="user-delete" data-id="<?= $user['id'] ?>">حذف</button>
                                </td>
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


    <script src="assets/script.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll(".user-delete").forEach(button => {
                button.addEventListener("click", () => {
                    const userId = button.getAttribute("data-id");
                    if (confirm(`هل أنت متأكد أنك تريد حذف المستخدم رقم ${userId}؟`)) {
                        fetch(`./actions/get_users.php?action=delete&id=${userId}`)
                            .then(res => res.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    alert(`✅ ${data.message}`);
                                    location.reload();
                                } else {
                                    alert(`❌ ${data.message}`);
                                }
                            })
                            .catch(err => {
                                alert("حدث خطأ أثناء الحذف");
                            });
                    }
                });
            });
        });
    </script>


</body>

</html>