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

$stmt = $pdo->prepare(
    "SELECT id, author_id, title, category, read_count, cover_image
     FROM texts
     WHERE visibility = 'public'
     ORDER BY read_count DESC
     LIMIT 5"
);
$stmt->execute();
$most_viewed = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare(
    "SELECT id, author_id, title, category, favorites, cover_image
     FROM texts
     WHERE visibility = 'public'
     ORDER BY favorites DESC
     LIMIT 5"
);
$stmt->execute();
$most_favorited = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare(
    "SELECT id, author_id, title, category, read_count, cover_image
     FROM texts
     WHERE visibility = 'public'
     ORDER BY created_at DESC
     LIMIT 5"
);
$stmt->execute();
$recents = $stmt->fetchAll(PDO::FETCH_ASSOC);

$recently_viewed = [];
if (isset($_SESSION['user_id'])) {
$stmt = $pdo->prepare(
    "SELECT rl.reader_id, rl.text_id, txt.cover_image, txt.title, txt.read_count, txt.category
    FROM reading_logs as rl
    INNER JOIN texts as txt on rl.text_id = txt.id
    WHERE reader_id = ? and visibility = 'public'
    GROUP BY txt.id
    ORDER BY MAX(started_at) DESC
    LIMIT 5"
);
$stmt->execute([$_SESSION['user_id']]);
$recently_viewed = $stmt->fetchAll(PDO::FETCH_ASSOC);
}


