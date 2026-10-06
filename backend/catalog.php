<?php
/*
AI USE DECLARATION

Tool: Codex
Stage: Development
Purpose: Build advanced catalog filtering with genre tags and optional semantic
         reordering through the FAISS embeddings API.
Validation: Code reviewed with diffs and checked with php -l.
*/

require_once __DIR__ . '/../backend-php/src/Services/MlClient.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/tags.php';

$query = trim($_GET['search'] ?? $_GET['catal'] ?? '');
$order = $_GET['order'] ?? 'recent';
$category = $_GET['category'] ?? '';
$selectedTags = $_GET['tags'] ?? [];
$catalogError = null;

if (!is_array($selectedTags)) {
    $selectedTags = [$selectedTags];
}

$selectedTags = array_values(array_unique(array_filter(
    array_map('intval', $selectedTags),
    fn ($id) => $id > 0
)));

$validOrders = ['recent', 'save', 'view'];
if (!in_array($order, $validOrders, true)) {
    $order = 'recent';
}

$validCategories = ['book', 'poetry', 'story'];
if (!in_array($category, $validCategories, true)) {
    $category = '';
}

$genres = getAllGenres($pdo);

$where = ["t.visibility = 'public'"];
$params = [];

if ($category !== '') {
    $where[] = 't.category = ?';
    $params[] = $category;
}

foreach ($selectedTags as $tagId) {
    $where[] = 'EXISTS (
        SELECT 1
        FROM text_genres tg_filter
        WHERE tg_filter.text_id = t.id
        AND tg_filter.genre_id = ?
    )';
    $params[] = $tagId;
}

$orderSql = match ($order) {
    'save' => 't.favorites DESC, t.created_at DESC',
    'view' => 't.read_count DESC, t.created_at DESC',
    default => 't.created_at DESC',
};

$sql = "SELECT
            t.id,
            t.author_id,
            t.title,
            t.category,
            t.read_count,
            t.favorites,
            t.cover_image,
            GROUP_CONCAT(g.name ORDER BY g.name SEPARATOR ', ') AS tags
        FROM texts t
        LEFT JOIN text_genres tg ON tg.text_id = t.id
        LEFT JOIN genres g ON g.id = tg.genre_id
        WHERE " . implode(' AND ', $where) . "
        GROUP BY t.id, t.author_id, t.title, t.category, t.read_count, t.favorites, t.cover_image, t.created_at
        ORDER BY $orderSql";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($query !== '' && !empty($books)) {
    $filteredIds = array_column($books, 'id');

    try {
        $semanticResults = mlBuscarFiltrado($query, $filteredIds, count($filteredIds));
        $booksById = [];

        foreach ($books as $book) {
            $booksById[(int) $book['id']] = $book;
        }

        $rankedBooks = [];
        foreach ($semanticResults as $result) {
            $id = (int) ($result['id'] ?? 0);

            if (isset($booksById[$id])) {
                $book = $booksById[$id];
                $book['semantic_score'] = $result['score'] ?? null;
                $rankedBooks[] = $book;
                unset($booksById[$id]);
            }
        }

        $books = array_merge($rankedBooks, array_values($booksById));
    } catch (Throwable $e) {
        $catalogError = 'catalog_semantic_unavailable';
    }
}
