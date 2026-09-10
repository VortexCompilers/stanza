<?php
/*
DECLARAÇÃO DE USO DE INTELIGÊNCIA ARTIFICIAL

Tool: Claude Code
Stage: Development
Purpose: Writing the two PDO queries that feed the landing page -- the hero
         mini-cards (the "most viewed" ranking backend/home.php uses) and the
         explore carousel (the "recently published" ranking, minus whatever the
         hero already shows). Both are restricted to texts that have a cover
         image and narrowed to the columns those cards render. The NOT IN list
         is built from bound placeholders, one per id, so no value is ever
         concatenated into the SQL string.
Validation: Queries run against the seeded database with the XAMPP mysql client
            and the returned rows compared with the "Most viewed" and "Recently
            published" carousels on the home page, checking that the rankings
            match, that non-public and cover-less texts are absent, and that no
            text appears in both the hero and the carousel.
*/

require_once __DIR__ . '/config/database.php';

$stmt = $pdo->prepare(
    "SELECT id, title, category, cover_image
     FROM texts
     WHERE visibility = 'public'
       AND cover_image IS NOT NULL
       AND cover_image <> ''
     ORDER BY read_count DESC
     LIMIT 2"
);
$stmt->execute();
$highlights = $stmt->fetchAll(PDO::FETCH_ASSOC);

$highlight_ids = array_column($highlights, 'id');

$sql = "SELECT id, title, category, cover_image
        FROM texts
        WHERE visibility = 'public'
          AND cover_image IS NOT NULL
          AND cover_image <> ''";

if ($highlight_ids) {
    $sql .= ' AND id NOT IN (' . implode(',', array_fill(0, count($highlight_ids), '?')) . ')';
}

$sql .= ' ORDER BY created_at DESC, id DESC LIMIT 3';

$stmt = $pdo->prepare($sql);
$stmt->execute($highlight_ids);
$explore = $stmt->fetchAll(PDO::FETCH_ASSOC);
