<?php

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
    "SELECT id, author_id, title, category, read_count, cover_image
     FROM texts
     WHERE visibility = 'public'
     ORDER BY created_at DESC
     LIMIT 5"
);
$stmt->execute();
$recents = $stmt->fetchAll(PDO::FETCH_ASSOC);


