<?php
require_once './settings/connect.php';

$page = $_GET['page'] ?? 'index';
$pagePath = 'pages/' . $page . '.php';
include './templates/header.php';
if (file_exists($pagePath)) {
    include $pagePath;
} else {
    include 'pages/404.php';
}

include './templates/footer.php';
?>