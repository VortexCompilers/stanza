<?php

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/tags.php';

$genres = getAllGenres($pdo);
$selectedTags = [];
