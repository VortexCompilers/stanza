<?php

function ensureTagSchema(PDO $pdo): void
{
    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS genres (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL UNIQUE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci"
    );

    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS text_genres (
            text_id INT NOT NULL,
            genre_id INT NOT NULL,
            PRIMARY KEY (text_id, genre_id),
            FOREIGN KEY (text_id) REFERENCES texts(id) ON DELETE CASCADE ON UPDATE CASCADE,
            FOREIGN KEY (genre_id) REFERENCES genres(id) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci"
    );

    $defaultGenres = [
        'Fantasia',
        'Drama',
        'Romance',
        'Terror',
        'Ficção Científica',
        'Suspense',
        'Aventura',
        'Mistério',
        'Poesia Lírica',
        'Realismo Mágico',
        'Comédia',
        'Distopia',
        '#romance',
        '#romantico',
        '#amor',
        '#love',
        '#romcom',
        '#comediaromantica',
        '#slowburn',
        '#friends2lovers',
        '#enemiestolovers',
        '#friendswithbenefits',
        '#firstlove',
        '#younglove',
        '#forbiddenlove',
        '#truelove',
        '#secondchance',
        '#childhoodfriends',
        '#drama',
        '#angst',
        '#emotional',
        '#feelings',
        '#heartbreak',
        '#superacao',
        '#segredos',
        '#mentiras',
        '#traicao',
        '#amizade',
        '#familia',
        '#conflitos',
        '#plotwist',
        '#twist',
        '#surpresa',
        '#misterio',
        '#mystery',
        '#suspense',
        '#thriller',
        '#investigacao',
        '#segredo',
        '#desaparecimento',
        '#enigma',
        '#crime',
        '#conspiracao',
        '#fantasia',
        '#fantasy',
        '#magia',
        '#magic',
        '#reino',
        '#kingdom',
        '#princesa',
        '#principe',
        '#rainha',
        '#rei',
        '#dragao',
        '#fadas',
        '#bruxas',
        '#feiticeiros',
        '#profecia',
        '#guerra',
        '#aventura',
        '#mitologia',
        '#fantasiamedieval',
        '#paranormal',
        '#sobrenatural',
        '#vampiros',
        '#vampire',
        '#lobisomem',
        '#werewolf',
        '#fantasmas',
        '#ghosts',
        '#demonios',
        '#anjos',
        '#imortais',
        '#supernatural',
        '#teenfiction',
        '#youngadult',
        '#juvenil',
        '#escola',
        '#colegio',
        '#highschool',
        '#faculdade',
        '#universidade',
        '#college',
        '#popular',
        '#nerd',
        '#novato',
        '#adolescencia',
        '#comingofage',
        '#comedia',
        '#humor',
        '#funny',
        '#comedy',
        '#situacoesengracadas',
        '#caos',
        '#sarcasmo',
        '#acao',
        '#action',
        '#adventure',
        '#batalha',
        '#heroi',
        '#heroina',
        '#missao',
        '#jornada',
        '#sobrevivencia',
        '#viagem',
        '#exploracao',
        '#ficcaocientifica',
        '#sciencefiction',
        '#scifi',
        '#futuro',
        '#espaco',
        '#aliens',
        '#extraterrestres',
        '#distopia',
        '#utopia',
        '#tecnologia',
        '#robos',
        '#viagemnotempo',
        '#timeTravel',
        '#terror',
        '#horror',
        '#medo',
        '#assustador',
        '#creepy',
        '#casaassombrada',
        '#lendaurbana',
        '#fanfic',
        '#fanfiction',
        '#fandom',
        '#crossover',
        '#alternateuniverse',
        '#au',
        '#oc',
        '#originalcharacter',
        '#reader',
        '#imagines',
        '#friendstolovers',
        '#strangers2lovers',
        '#fakeDating',
        '#forcedproximity',
        '#oppositesattract',
        '#loveTriangle',
        '#onlyonebed',
        '#secretrelationship',
        '#brasil',
        '#saopaulo',
        '#riodejaneiro',
        '#newyork',
        '#londres',
        '#paris',
        '#cidadepequena',
        '#smalltown',
        '#praia',
        '#interior',
        '#cidadegrande',
        '#medieval',
        '#primeirapessoa',
        '#terceirapessoa',
        '#multiplospov',
        '#pov',
        '#diario',
        '#cartas',
        '#mensagens',
        '#chatfic',
        '#shortstory',
        '#oneshot',
        '#serie',
        '#trilogia',
        '#completed',
        '#ongoing',
    ];

    $defaultGenres = array_values(array_unique($defaultGenres));

    $stmt = $pdo->prepare('INSERT IGNORE INTO genres (name) VALUES (?)');
    foreach ($defaultGenres as $genre) {
        $stmt->execute([$genre]);
    }
}

function getAllGenres(PDO $pdo): array
{
    ensureTagSchema($pdo);

    $stmt = $pdo->query('SELECT id, name FROM genres ORDER BY name ASC');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function normalizeGenreIds(array $rawGenreIds, array $genres): array
{
    $validIds = array_map('intval', array_column($genres, 'id'));

    return array_values(array_intersect(
        array_values(array_unique(array_filter(
            array_map('intval', $rawGenreIds),
            fn ($id) => $id > 0
        ))),
        $validIds
    ));
}

function getSelectedGenreIdsFromPost(array $genres): array
{
    $rawGenreIds = $_POST['tags'] ?? [];

    if (!is_array($rawGenreIds)) {
        $rawGenreIds = [$rawGenreIds];
    }

    return normalizeGenreIds($rawGenreIds, $genres);
}

function getTextGenreIds(PDO $pdo, int $textId): array
{
    ensureTagSchema($pdo);

    $stmt = $pdo->prepare('SELECT genre_id FROM text_genres WHERE text_id = ?');
    $stmt->execute([$textId]);

    return array_map('intval', $stmt->fetchAll(PDO::FETCH_COLUMN));
}

function syncTextGenres(PDO $pdo, int $textId, array $genreIds): void
{
    $deleteStmt = $pdo->prepare('DELETE FROM text_genres WHERE text_id = ?');
    $deleteStmt->execute([$textId]);

    if (empty($genreIds)) {
        return;
    }

    $insertStmt = $pdo->prepare(
        'INSERT INTO text_genres (text_id, genre_id) VALUES (?, ?)'
    );

    foreach ($genreIds as $genreId) {
        $insertStmt->execute([$textId, (int) $genreId]);
    }
}

function getGenreNamesByIds(array $genres, array $genreIds): array
{
    $namesById = [];
    foreach ($genres as $genre) {
        $namesById[(int) $genre['id']] = $genre['name'];
    }

    $names = [];
    foreach ($genreIds as $genreId) {
        if (isset($namesById[(int) $genreId])) {
            $names[] = $namesById[(int) $genreId];
        }
    }

    return $names;
}
