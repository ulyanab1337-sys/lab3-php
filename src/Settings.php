<?php
namespace App;

class Settings
{
    public static function apply(array $user): void
    {
        setcookie('bg_color', $user['bg_color'], time() + 86400 * 30, '/');
        setcookie('font_color', $user['font_color'], time() + 86400 * 30, '/');
    }

    public static function update(int $userId, string $bg, string $font): void
    {
        $pdo = Db::connect();
        $stmt = $pdo->prepare('UPDATE users SET bg_color = ?, font_color = ? WHERE id = ?');
        $stmt->execute([$bg, $font, $userId]);
        setcookie('bg_color', $bg, time() + 86400 * 30, '/');
        setcookie('font_color', $font, time() + 86400 * 30, '/');
    }
}