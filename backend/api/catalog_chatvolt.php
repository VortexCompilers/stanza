<?php
/*
DECLARATION OF ARTIFICIAL INTELLIGENCE USE

Tool: Claude Code
Stage: Development
Purpose: Correction, review, and refinement of the code
Validation: All changes tested by the dev
*/

require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json; charset=utf-8');

function api_error($status, $message)
{
    http_response_code($status);
    echo json_encode(['error' => $message], JSON_UNESCAPED_UNICODE);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
if ($method !== 'GET' && $method !== 'HEAD') {
    header('Allow: GET');
    api_error(405, 'Only GET is allowed on this endpoint.');
}

$token_file = __DIR__ . '/../config/api_token.php';
if (!is_file($token_file)) {
    api_error(500, 'API token is not configured on the server.');
}
$expected_token = require $token_file;

$sent_token = $_SERVER['HTTP_X_API_KEY'] ?? '';

if (!is_string($sent_token) || !hash_equals($expected_token, $sent_token)) {
    api_error(401, 'Missing or invalid API token.');
}

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

$stmt = $pdo->prepare(
    'SELECT texts.id, texts.title, texts.description, texts.category,
            texts.language, texts.read_count, texts.favorites,
            users.name AS author_name
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

$scheme = ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '')
    ?: ((($_SERVER['HTTPS'] ?? 'off') !== 'off') ? 'https' : 'http');
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';

$app_path = dirname(dirname(dirname($_SERVER['SCRIPT_NAME'] ?? '')));
$app_path = rtrim(str_replace('\\', '/', $app_path), '/');

$base_url = $scheme . '://' . $host . $app_path;

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
        'views' => (int) $row['read_count'],
        'favorites' => (int) $row['favorites'],
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
