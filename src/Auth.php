<?php
namespace App;

class Auth
{
    public static function register(string $login, string $password, string $bg, string $font): void
    {
        $pdo = Db::connect();
        $stmt = $pdo->prepare('INSERT INTO users (login, password_hash, bg_color, font_color) VALUES (?,?,?,?)');
        $stmt->execute([$login, password_hash($password, PASSWORD_DEFAULT), $bg, $font]);
    }

    public static function login(string $login, string $password): ?array
    {
        $pdo = Db::connect();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE login = ?');
        $stmt->execute([$login]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password_hash'])) {
            return $user;
        }
        return null;
    }

    public static function remember(int $userId): string
    {
        $token = bin2hex(random_bytes(32));
        $pdo = Db::connect();
        $stmt = $pdo->prepare('UPDATE users SET auth_token = ? WHERE id = ?');
        $stmt->execute([$token, $userId]);
        setcookie('remember', $token, [
            'expires' => time() + 86400 * 30,
            'path' => '/',
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        return $token;
    }

    public static function autoLogin(): ?array
    {
        if (empty($_COOKIE['remember'])) {
            return null;
        }
        $pdo = Db::connect();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE auth_token = ?');
        $stmt->execute([$_COOKIE['remember']]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public static function logout(int $userId): void
    {
        $pdo = Db::connect();
        $stmt = $pdo->prepare('UPDATE users SET auth_token = NULL WHERE id = ?');
        $stmt->execute([$userId]);
        setcookie('remember', '', time() - 3600, '/');
        session_destroy();
    }
}