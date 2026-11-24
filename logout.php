<?php
require 'vendor/autoload.php';
session_start();

use App\Auth;

if (!empty($_SESSION['user'])) {
    Auth::logout((int)$_SESSION['user']['id']);
}
$_SESSION = [];
session_destroy();
header('Location: login.php');
exit;