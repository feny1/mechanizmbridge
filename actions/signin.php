<?php
header('Content-Type: application/json');

include_once 'data.php'; // ملف الاتصال بقاعدة البيانات


// استقبال البيانات
$username      = trim($_POST['username'] ?? '');
$phone         = trim($_POST['phone'] ?? '');
$commerical_id = trim($_POST['commericalid'] ?? '');
$city          = trim($_POST['city'] ?? '');
$password      = trim($_POST['password'] ?? '');
$repassword    = trim($_POST['repassword'] ?? '');

// تحقق من الحقول
if (empty($username) || empty($phone) || empty($commerical_id) || empty($city) || empty($password) || empty($repassword)) {
    echo json_encode(['status' => 'error', 'message' => 'جميع الحقول مطلوبة']);
    exit;
}

if ($password !== $repassword) {
    echo json_encode(['status' => 'error', 'message' => 'كلمتا المرور غير متطابقتين']);
    exit;
}

if (strlen($password) < 8) {
    echo json_encode(['status' => 'error', 'message' => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل']);
    exit;
}

// تحقق إن كان الرقم مستخدم
$stmt = $mysqli->prepare("SELECT id FROM users WHERE phone = ?");
$stmt->bind_param('s', $phone);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'رقم الجوال مستخدم بالفعل']);
    exit;
}


// إنشاء الحساب الجديد
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $mysqli->prepare("INSERT INTO users (username, phone, commerical_id, city, password) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param('sssss', $username, $phone, $commerical_id, $city, $hashedPassword);

if ($stmt->execute()) {
    echo json_encode([
        'status' => 'success',
        'message' => 'تم إنشاء الحساب بنجاح'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'حدث خطأ أثناء إنشاء الحساب'
    ]);
}
