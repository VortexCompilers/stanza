<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/lang/config.php'; // $allowedLanguages (shared with lang/load.php)

$requested = $_GET['lang'] ?? '';

if (in_array($requested, $allowedLanguages, true)) {
    $_SESSION['lang'] = $requested;
}

$fallback = '/stanza/frontend/home.php';
$referer  = $_SERVER['HTTP_REFERER'] ?? '';

$path  = (string) parse_url($referer, PHP_URL_PATH);
$query = parse_url($referer, PHP_URL_QUERY);

if (str_starts_with($path, '/stanza/')) {
    $target = $path . (is_string($query) && $query !== '' ? '?' . $query : '');
} else {
    $target = $fallback;
}


header('Location: ' . $target);
exit;
