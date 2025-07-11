<?php
header('Content-Type: application/json');
include_once 'data.php';

$phone = trim($_POST['phone'] ?? '');
$password = trim($_POST['password'] ?? '');

if (empty($phone) || empty($password)) {
    echo json_encode(['status' => 'error', 'message' => 'جميع الحقول مطلوبة']);
    exit;
}

$stmt = $mysqli->prepare("SELECT password FROM users WHERE phone = ?");
$stmt->bind_param('s', $phone);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['status' => 'invalid']);
    exit;
}

$row = $result->fetch_assoc();
if (!password_verify($password, $row['password'])) {
    echo json_encode(['status' => 'invalid']);
    exit;
}

echo json_encode(['status' => 'valid']);
