<?php
/*
DECLARAÇÃO DE USO DE INTELIGÊNCIA ARTIFICIAL

Tool: Claude Code
Stage: Development
Purpose: Writing the session guard and the three PDO queries that feed the
         profile page -- the account row (name and creation date), the header
         counters aggregated with COUNT() and SUM() over the user's texts, and
         the list of texts the user has written. Every query is filtered by the
         session user id bound as a parameter, so one profile never reads
         another account's rows.
Validation: Queries run against the seeded database with the XAMPP mysql client
            and the page opened while logged in, checking that the counters
            match the rows the user owns, that the grid lists the same texts the
            catalog shows for that author, and that opening profile.php while
            logged out redirects to the login page.
*/

require_once __DIR__ . '/config/database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['user_id'])) {
    header('Location: ../frontend/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare('SELECT name, created_at FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    session_destroy();
    header('Location: ../frontend/login.php');
    exit;
}

$joined_at = date('F Y', strtotime($user['created_at']));

$stmt = $pdo->prepare(
    'SELECT COUNT(*) AS texts_written, COALESCE(SUM(read_count), 0) AS total_views
     FROM texts
     WHERE author_id = ?'
);
$stmt->execute([$user_id]);
$stats = $stmt->fetch(PDO::FETCH_ASSOC);

$texts_written = (int) $stats['texts_written'];
$total_views = (int) $stats['total_views'];
$texts_saved = 0;

$stmt = $pdo->prepare(
    'SELECT id, title, category, read_count, cover_image
     FROM texts
     WHERE author_id = ?
     ORDER BY created_at DESC, id DESC'
);
$stmt->execute([$user_id]);
$texts = $stmt->fetchAll(PDO::FETCH_ASSOC);
