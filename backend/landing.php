<?php
/*
/*
DECLARATION OF ARTIFICIAL INTELLIGENCE USE

Tool: Claude Code
Stage: Development
Purpose: Correction, review, and refinement of the code
Validation: All changes tested by the dev
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
