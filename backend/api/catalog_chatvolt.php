<?php
/*
DECLARAÇÃO DE USO DE INTELIGÊNCIA ARTIFICIAL

Tool: Claude Code
Stage: Development
Purpose: Writing this read-only JSON catalog endpoint that feeds the StanzAI
         chat agent hosted on Chatvolt: the PDO query joining texts and users
         with the visibility = 'public' filter, the static-token check in the
         X-API-Key header, and the assembly of the ready-to-use reading URL so
         the agent never handles internal IDs.
Validation: Endpoint called with curl with a valid token, an invalid token and
            no token at all; the returned JSON compared field by field against
            the rows in the texts table, checking that private texts are absent
            and that each read_url opens the matching text in the browser.
*/

require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json; charset=utf-8');

/**
 * Sends a JSON error and stops. Kept short so every exit path below looks
 * the same to the caller.
 */
function api_error($status, $message)
{
    http_response_code($status);
    echo json_encode(['error' => $message], JSON_UNESCAPED_UNICODE);
    exit;
}

// This endpoint is read-only: anything other than a read verb is refused.
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
if ($method !== 'GET' && $method !== 'HEAD') {
    header('Allow: GET');
    api_error(405, 'Only GET is allowed on this endpoint.');
}

// Static token, kept out of the repository. See api_token.example.php.
$token_file = __DIR__ . '/../config/api_token.php';
if (!is_file($token_file)) {
    api_error(500, 'API token is not configured on the server.');
}
$expected_token = require $token_file;

$sent_token = $_SERVER['HTTP_X_API_KEY'] ?? '';

// hash_equals compares in constant time, so the response time does not leak
// how much of the token was guessed correctly.
if (!is_string($sent_token) || !hash_equals($expected_token, $sent_token)) {
    api_error(401, 'Missing or invalid API token.');
}

// Optional paging. Both values are cast to int and clamped before reaching the
// SQL string, so no caller input is ever concatenated into the query.
$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 100;
$offset = isset($_GET['offset']) ? (int) $_GET['offset'] : 0;

if ($limit < 1) {
    $limit = 1;
}
if ($limit > 200) {
    $limit = 200;
}
if ($offset < 0) {
    $offset = 0;
}

// Same visibility rule as the catalog and home screens: public texts only.
$stmt = $pdo->prepare(
    'SELECT texts.id, texts.title, texts.description, texts.category,
            texts.language, users.name AS author_name
     FROM texts
     JOIN users ON users.id = texts.author_id
     WHERE texts.visibility = \'public\'
     ORDER BY texts.created_at DESC
     LIMIT ' . $limit . ' OFFSET ' . $offset
);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = (int) $pdo->query(
    'SELECT COUNT(*) FROM texts WHERE visibility = \'public\''
)->fetchColumn();

// Base URL of the site, so the agent can hand the reader a link that works
// from outside. Derived from the request, which keeps it correct behind the
// ngrok domain as well as on localhost.
$scheme = ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '')
    ?: ((($_SERVER['HTTPS'] ?? 'off') !== 'off') ? 'https' : 'http');
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';

// /stanza/backend/api/catalog.php -> /stanza
$app_path = dirname(dirname(dirname($_SERVER['SCRIPT_NAME'] ?? '')));
$app_path = rtrim(str_replace('\\', '/', $app_path), '/');

$base_url = $scheme . '://' . $host . $app_path;

// The site stores languages as enum slugs; these are the tags a reader would
// recognise if the agent repeats them.
$language_tags = [
    'enus' => 'en-US',
    'ptbr' => 'pt-BR',
    'es' => 'es',
];

$books = [];
foreach ($rows as $row) {
    $books[] = [
        'title' => $row['title'],
        'author' => $row['author_name'],
        'category' => $row['category'],
        'language' => $language_tags[$row['language']] ?? null,
        'synopsis' => $row['description'],
        'read_url' => $base_url . '/frontend/read.php?id=' . (int) $row['id'],
    ];
}

echo json_encode(
    [
        'catalog' => 'Stanza',
        'total' => $total,
        'returned' => count($books),
        'books' => $books,
    ],
    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
);
