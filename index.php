<?php
require_once './settings/connect.php';

$page = $_GET['page'] ?? 'index';
$pagePath = 'pages/' . $page . '.php';

if (!isset($_GET['ajax'])) {
    if ($page != 'add_to_favorites') {
        include './templates/header.php';
    }
}
if (file_exists($pagePath)) {
    include $pagePath;
} else {
    include 'pages/404.php';
}

if (!isset($_GET['ajax'])) {
    if ($page != 'add_to_favorites') {
        include './templates/footer.php';
    }
}
?>