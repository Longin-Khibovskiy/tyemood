<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../settings/connect.php';

if (!isset($_SESSION['guest_token'])) {
    echo json_encode(['success' => false, 'error' => 'guest_token отсутствует']);
    exit;
}

$guest_token = $_SESSION['guest_token'];

$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (!$data || !isset($data['action'], $data['product_id'], $data['size'])) {
    echo json_encode(['success' => false, 'error' => 'Неверный формат данных']);
    exit;
}

$action = $data['action'];
$product_id = (int)$data['product_id'];
$size = trim($data['size']);

$stmt = $link->prepare("SELECT quantity FROM guest_cart WHERE guest_token = ? AND product_id = ? AND size = ?");
$stmt->bind_param("sis", $guest_token, $product_id, $size);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$current_quantity = $row['quantity'] ?? 0;

if ($action === "add") {
    if ($current_quantity > 0) {
        $stmt = $link->prepare("UPDATE guest_cart SET quantity = quantity + 1 WHERE guest_token = ? AND product_id = ? AND size = ?");
        $stmt->bind_param("sis", $guest_token, $product_id, $size);
        $stmt->execute();
        echo json_encode(['success' => true, 'count' => $current_quantity + 1]);
    } else {
        $stmt = $link->prepare("INSERT INTO guest_cart (guest_token, product_id, size, quantity) VALUES (?, ?, ?, 1)");
        $stmt->bind_param("sis", $guest_token, $product_id, $size);
        $stmt->execute();
        echo json_encode(['success' => true, 'count' => 1]);
    }
    exit;
}

if ($action === "plus") {
    if ($current_quantity > 0) {
        $stmt = $link->prepare("UPDATE guest_cart SET quantity = quantity + 1 WHERE guest_token = ? AND product_id = ? AND size = ?");
        $stmt->bind_param("sis", $guest_token, $product_id, $size);
        $stmt->execute();
        echo json_encode(['success' => true, 'count' => $current_quantity + 1]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Товар не найден в корзине']);
    }
    exit;
}

if ($action === "minus") {
    if ($current_quantity > 1) {
        $stmt = $link->prepare("UPDATE guest_cart SET quantity = quantity - 1 WHERE guest_token = ? AND product_id = ? AND size = ?");
        $stmt->bind_param("sis", $guest_token, $product_id, $size);
        $stmt->execute();
        echo json_encode(['success' => true, 'count' => $current_quantity - 1]);
    } elseif ($current_quantity == 1) {
        $stmt = $link->prepare("DELETE FROM guest_cart WHERE guest_token = ? AND product_id = ? AND size = ?");
        $stmt->bind_param("sis", $guest_token, $product_id, $size);
        $stmt->execute();
        echo json_encode(['success' => true, 'count' => 0]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Товар не найден в корзине']);
    }
    exit;
}
if ($action === 'delete_from_cart') {
    $stmt = $link->prepare("DELETE FROM guest_cart WHERE guest_token = ? AND product_id = ? AND size = ?");
    $stmt->bind_param("sis", $guest_token, $product_id, $size);
    $stmt->execute();
    echo json_encode(['success' => true]);
    exit;
}
echo json_encode(['success' => false, 'error' => 'Неизвестное действие']);