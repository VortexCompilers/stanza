<?php
/*
DECLARAÇÃO DE USO DE INTELIGÊNCIA ARTIFICIAL

Tool: Claude Code
Stage: Development
Purpose: Writing the PDO queries that feed the home carousels (most viewed,
         most favourited and recently published), with their ORDER BY and
         the visibility = 'public' filter.
Validation: Queries reviewed and run against the seeded database, checking
            the ranking and the public-only filter.
*/

require_once __DIR__ . '/config/database.php';

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


