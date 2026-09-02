<?php
/**
 * Language loader.
 *
 * Included at the very top of every page, before any HTML output. It only
 * READS the active language and exposes translator(). Switching the language
 * is lang/set-language.php's job.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/config.php'; // $allowedLanguages, $default, $htmlLangs

// Which language is active for this visitor? Never trust the stored value:
// if it is not one we ship, fall back to the default. This is what makes the
// require below safe.
$lang = $_SESSION['lang'] ?? $default;

if (!in_array($lang, $allowedLanguages, true)) {
    $lang = $default;
}

// Load the base dictionary first and keep a copy, then load the active one on
// top. Both files define $strings, so without the copy the second require
// would wipe the fallback.
require __DIR__ . '/' . $default . '.php';
$stringsBase = $strings;

if ($lang !== $default) {
    require __DIR__ . '/' . $lang . '.php';
}

// translator('key') -> translated text, already escaped for safe HTML output.
// Missing in the active language -> falls back to English. Missing everywhere
// -> returns the key itself, so the gap shows on screen instead of rendering
// blank. Wrapped in function_exists() because the file may be included twice
// in one request (a page and one of its partials).
if (!function_exists('translator')) {
    function translator($key)
    {
        global $strings, $stringsBase;

        if (isset($strings[$key])) {
            return htmlspecialchars($strings[$key], ENT_QUOTES, 'UTF-8');
        }

        if (isset($stringsBase[$key])) {
            return htmlspecialchars($stringsBase[$key], ENT_QUOTES, 'UTF-8');
        }

        return $key;
    }
}

// Value for <html lang="...">. The ?? guard keeps a bad state from producing
// an empty attribute if the two lists in config.php ever drift.
$htmlLang = $htmlLangs[$lang] ?? 'en';
