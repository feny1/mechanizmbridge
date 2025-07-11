<?php
header('Content-Type: application/json');
include_once 'data.php'; // الاتصال بقاعدة البيانات

function getAllUsers($mysqli) {
    $stmt = $mysqli->prepare("SELECT * FROM users");
    $stmt->execute();
    $result = $stmt->get_result();

    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    return [
        'status' => 'success',
        'data' => $users
    ];
}

function getUser($mysqli, $id) {
    $stmt = $mysqli->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        return [
            'status' => 'success',
            'data' => $row
        ];
    }

    return [
        'status' => 'error',
        'message' => 'User not found'
    ];
}

function deleteUser($mysqli, $id) {
    $stmt = $mysqli->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        return [
            'status' => 'success',
            'message' => 'User deleted'
        ];
    }

    return [
        'status' => 'error',
        'message' => 'User not found or already deleted'
    ];
}

// 🧭 معالجة الطلب
try {
    $action = $_GET['action'] ?? null;
    $id = isset($_GET['id']) ? intval($_GET['id']) : null;

    switch ($action) {
        case 'getAll':
            echo json_encode(getAllUsers($mysqli), JSON_UNESCAPED_UNICODE);
            break;

        case 'get':
            if (!$id) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Missing id'
                ]);
                break;
            }
            echo json_encode(getUser($mysqli, $id), JSON_UNESCAPED_UNICODE);
            break;

        case 'delete':
            if (!$id) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Missing id'
                ]);
                break;
            }
            echo json_encode(deleteUser($mysqli, $id), JSON_UNESCAPED_UNICODE);
            break;

        default:
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid action'
            ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
