<?php
require 'vendor/autoload.php';
session_start();

use App\Auth;

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        Auth::register(
            $_POST['login'] ?? '',
            $_POST['password'] ?? '',
            $_POST['bg_color'] ?? '#ffffff',
            $_POST['font_color'] ?? '#000000'
        );
        header('Location: login.php');
        exit;
    } catch (\Throwable $e) {
        $error = 'Ошибка регистрации: ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html><head><meta charset="utf-8"><title>Регистрация</title></head>
<body>
<h1>Регистрация</h1>
<?php if ($error): ?><p style="color:red"><?= htmlspecialchars($error) ?></p><?php endif; ?>
<form method="post">
    Логин: <input name="login" required><br>
    Пароль: <input type="password" name="password" required><br>
    Цвет фона: <input type="color" name="bg_color" value="#ffffff"><br>
    Цвет шрифта: <input type="color" name="font_color" value="#000000"><br>
    <button type="submit">Зарегистрироваться</button>
</form>
<p><a href="login.php">Уже есть аккаунт? Войти</a></p>
</body></html>