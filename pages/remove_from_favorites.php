<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once '../settings/connect.php';

if (!isset($_POST['product_id']) || !isset($_SESSION['guest_token'])) {
    echo json_encode(['success' => false, 'message' => 'Некорректный запрос']);
    exit;
}

$product_id = (int) $_POST['product_id'];
$token = $_SESSION['guest_token'];

$stmt = $link->prepare("DELETE FROM guest_favorites WHERE product_id = ? AND guest_token = ?");
$stmt->bind_param("is", $product_id, $token);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Ошибка базы данных']);
}
