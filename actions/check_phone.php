<?php
header('Content-Type: application/json');

include_once 'data.php'; // ملف الاتصال بقاعدة البيانات
// استقبال الرقم
$phone = trim($_POST['phone'] ?? '');

if (empty($phone)) {
    echo json_encode(['status' => 'error', 'message' => 'رقم الجوال مطلوب']);
    exit;
}

// تحقق إن كان الرقم موجود
$stmt = $mysqli->prepare("SELECT id FROM users WHERE phone = ?");
$stmt->bind_param('s', $phone);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['status' => 'exists', 'message' => 'رقم الجوال مستخدم بالفعل']);
} else {
    echo json_encode(['status' => 'available', 'message' => 'رقم الجوال متاح للتسجيل']);
}
