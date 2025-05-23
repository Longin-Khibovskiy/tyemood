<?php
global $link;
$link = mysqli_connect('localhost', 'root', 'root', 'tyemood');

if ($link === false) {
    die('Ошибка: Невозможно подключиться к MySQL ' . mysqli_connect_error());
}
