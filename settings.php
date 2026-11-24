<?php
require 'vendor/autoload.php';
session_start();

use App\Settings;

if (empty($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Settings::update(
        (int)$_SESSION['user']['id'],
        $_POST['bg_color'] ?? '#ffffff',
        $_POST['font_color'] ?? '#000000'
    );
    header('Location: index.php');
    exit;
}

$bg = $_COOKIE['bg_color'] ?? '#ffffff';
$font = $_COOKIE['font_color'] ?? '#000000';
?>
<!DOCTYPE html>
<html><head><meta charset="utf-8"><title>Настройки</title></head>
<body style="background:<?= htmlspecialchars($bg) ?>; color:<?= htmlspecialchars($font) ?>">
<h1>Настройки</h1>
<form method="post">
    Цвет фона: <input type="color" name="bg_color" value="<?= htmlspecialchars($bg) ?>"><br>
    Цвет шрифта: <input type="color" name="font_color" value="<?= htmlspecialchars($font) ?>"><br>
    <button type="submit">Сохранить</button>
</form>
<p><a href="index.php">На главную</a></p>
</body></html>