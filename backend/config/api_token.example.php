<?php
/*
 * Copy this file to api_token.php and replace the value with a real secret.
 * api_token.php is gitignored: the token must never be committed.
 *
 * Generate one with:
 *   php -r "echo bin2hex(random_bytes(24));"
 *
 * The same value goes in the Chatvolt HTTP Tool, as the X-API-Key header.
 */

return 'replace-me-with-a-real-token';
