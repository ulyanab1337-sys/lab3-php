<?php
require 'vendor/autoload.php';
session_start();

use App\Auth;
use App\Settings;

if (empty($_SESSION['user']) && $user = Auth::autoLogin()) {
    $_SESSION['user'] = [
        'id' => $user['id'],
        'login' => $user['login'],
    ];
    Settings::apply($user);
}

if (empty($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$bg = $_COOKIE['bg_color'] ?? '#ffffff';
$font = $_COOKIE['font_color'] ?? '#000000';
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Главная</title></head>
<body style="background:<?= htmlspecialchars($bg) ?>; color:<?= htmlspecialchars($font) ?>">
    <h1>Привет, <?= htmlspecialchars($_SESSION['user']['login']) ?>!</h1>
    <p>Текущие настройки: фон <?= htmlspecialchars($bg) ?>, шрифт <?= htmlspecialchars($font) ?></p>
    <p>
        <a href="settings.php">Настройки</a> |
        <a href="logout.php">Выйти</a>
    </p>
</body>
</html>
