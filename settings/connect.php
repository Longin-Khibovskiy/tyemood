<?php
global $link;
$link = mysqli_connect('localhost', 'root', 'root', 'tyemood');

if ($link === false) {
    die('Ошибка: Невозможно подключиться к MySQL ' . mysqli_connect_error());
}
if (!isset($_SESSION['session_id'])) {
    $_SESSION['session_id'] = session_create_id();
}
global $session_id;
$session_id = $_SESSION['session_id'];
