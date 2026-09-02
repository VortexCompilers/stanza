<?php
/**
 * Language switcher endpoint.
 *
 * The only place that writes $_SESSION['lang']. The language links in the UI
 * point here (frontend/set-language.php); it validates the choice, stores it
 * and sends the visitor back to the page they came from. lang/load.php only
 * reads what this file writes.
 *
 * Pure PHP on purpose: it emits nothing but a Location header, so there must
 * be no output before it — no HTML, no blank line, no closing tag.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/lang/config.php'; // $allowedLanguages (shared with lang/load.php)

/* -- Steps 1-3: store the requested language only if it is one we ship ----- */

$requested = $_GET['lang'] ?? '';

if (in_array($requested, $allowedLanguages, true)) {
    $_SESSION['lang'] = $requested;
}
// A missing or invalid ?lang= is ignored on purpose: the current language stays.

/* -- Step 4: work out where to send the visitor back to ------------------- */

$fallback = '/stanza/frontend/home.php';
$referer  = $_SERVER['HTTP_REFERER'] ?? '';

// Take only the path (+ query) of the referer and drop scheme/host entirely,
// so the redirect can never leave our site. Accept it only when the path sits
// under /stanza/; anything else (external URL, no referer) goes to home. This
// keeps the original query string, e.g. read.php?id=42, intact.
$path  = (string) parse_url($referer, PHP_URL_PATH);
$query = parse_url($referer, PHP_URL_QUERY);

if (str_starts_with($path, '/stanza/')) {
    $target = $path . (is_string($query) && $query !== '' ? '?' . $query : '');
} else {
    $target = $fallback;
}

/* -- Step 5: redirect and stop ------------------------------------------- */

header('Location: ' . $target);
exit;
