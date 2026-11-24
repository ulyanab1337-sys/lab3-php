<?php
require 'vendor/autoload.php';
session_start();

use App\Auth;
use App\Settings;

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = Auth::login($_POST['login'] ?? '', $_POST['password'] ?? '');
    if ($user) {
        $_SESSION['user'] = ['id' => $user['id'], 'login' => $user['login']];
        Settings::apply($user);

        if (!empty($_POST['remember'])) {
            Auth::remember((int)$user['id']);
        }
        header('Location: index.php');
        exit;
    }
    $error = 'Неверный логин или пароль';
}
?>
<!DOCTYPE html>
<html><head><meta charset="utf-8"><title>Вход</title></head>
<body>
<h1>Вход</h1>
<?php if ($error): ?><p style="color:red"><?= htmlspecialchars($error) ?></p><?php endif; ?>
<form method="post">
    Логин: <input name="login" required><br>
    Пароль: <input type="password" name="password" required><br>
    <label><input type="checkbox" name="remember" value="1"> Запомнить меня</label><br>
    <button type="submit">Войти</button>
</form>
<p><a href="register.php">Регистрация</a></p>
</body></html>