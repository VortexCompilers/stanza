<?php 
/*
DECLARATION OF ARTIFICIAL INTELLIGENCE USE

Tool: Claude Code
Stage: Development
Purpose: Correction, review, and refinement of the code
Validation: All changes tested by the dev
*/

require_once __DIR__ . '/../backend-php/src/Services/MlClient.php';
require_once __DIR__ . '/config/database.php';

$query = $_GET['search'] ?? '';

if (trim($query) === '') {
    // empty search
    header('Location: /');
    exit;
}

$data = mlBuscar($query, 20);


if (empty($data)) {
    $books = [];
} else {
    $BestsIDS = array_column($data, 'id');

    // it puts the placholder by the number of ids and in the pre-order, like: ('?','?','?')
    $placeholders = implode(',', array_fill(0, count($BestsIDS), '?'));

    // create the query with order by field to preserve the order of the ids
    $sql = "SELECT id, author_id, title, category, read_count, cover_image
            FROM texts
            WHERE visibility = 'public'
            AND id IN ($placeholders) 
            ORDER BY FIELD(id, " . implode(',', array_map('intval', $BestsIDS)) . ")";
            

    $stmt = $pdo->prepare($sql);
    $stmt->execute($BestsIDS);
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

}

