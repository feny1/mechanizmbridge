<?php
// write the variables $localhost, $db_user, $db_pass, $db_name
$localhost = 'localhost';
$db_user = 'mechanizmbridge_user';
$db_pass = 'L88fZaWIJh58V@Db';
$db_name = 'mechanizmbridge_db';
$mysqli = new mysqli($localhost, $db_user, $db_pass, $db_name);
if ($mysqli->connect_errno) {
    echo json_encode(['status' => 'error', 'message' => 'فشل الاتصال بقاعدة البيانات']);
    exit;
}