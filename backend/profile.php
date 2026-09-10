<?php
/*
DECLARATION OF ARTIFICIAL INTELLIGENCE USE

Tool: Claude Code
Stage: Development
Purpose: Correction, review, and refinement of the code
Validation: All changes tested by the dev
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
