<?php
/**
 * Language configuration — the single source of truth for which languages
 * the site ships. Both lang/load.php (reads the active language) and
 * lang/set-language.php (writes it) include this file, so the list never
 * drifts between the two.
 *
 * To add a language: add its code to $allowedLanguages, add the matching
 * BCP-47 tag to $htmlLangs, and drop a lang/<code>.php dictionary next to
 * this file with the same keys as enus.php.
 */

$allowedLanguages = ['enus', 'es', 'ptbr'];
$default = 'enus';

// Internal code => value for <html lang="...">. Our codes (enus, ptbr) are
// not valid BCP-47 tags, so they are mapped here.
$htmlLangs = ['enus' => 'en-US', 'es' => 'es', 'ptbr' => 'pt-BR'];
