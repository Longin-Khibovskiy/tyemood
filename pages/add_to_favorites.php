<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require_once '../settings/connect.php';

if (!isset($_POST['product_id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing product_id']);
    exit;
}

$product_id = (int)$_POST['product_id'];
$guest_token = $_SESSION['guest_token'] ?? null;

if (!$guest_token) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Guest token not set']);
    exit;
}

$stmt = $link->prepare("INSERT IGNORE INTO guest_favorites (guest_token, product_id) VALUES (?, ?)");
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $link->error]);
    exit;
}

$stmt->bind_param("si", $guest_token, $product_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Execute failed: ' . $stmt->error]);
}