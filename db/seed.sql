-- StanzAI demo seed data
-- Run once, right after db/schema.sql, against an empty database.
--
--   /opt/lampp/bin/mysql --default-character-set=utf8mb4 -u root stanza < db/seed.sql
--
-- (the --default-character-set flag matters: without it, accented characters
-- in the titles/bodies below can be mangled on import)
--
-- Demo login for the presentation:
--   email:    autor@gmail.com
--   password: 123456
--
-- All seeded accounts share the same password ("123456") purely for demo
-- convenience — never do this outside a throwaway demo database.

USE stanza;

-- ============================================================
-- Users
-- ============================================================

INSERT INTO users (name, email, birthdate, gender, password_hash, role) VALUES
('autor', 'autor@gmail.com', '1999-05-12', 'female',
 '$2y$10$xm0C7Lo4YsCwXnP3FbSfuOnECFlR3ffsNkUFtKeRNoA.zJmMExMTK', 'author');
SET @autor = LAST_INSERT_ID();

INSERT INTO users (name, email, birthdate, gender, password_hash, role) VALUES
('Rafael Nogueira', 'rafael.nogueira@stanzai.demo', '1994-09-03', 'male',
 '$2y$10$xm0C7Lo4YsCwXnP3FbSfuOnECFlR3ffsNkUFtKeRNoA.zJmMExMTK', 'author');
SET @rafael = LAST_INSERT_ID();

INSERT INTO users (name, email, birthdate, gender, password_hash, role) VALUES
('Camila Reis', 'camila.reis@stanzai.demo', '2001-02-20', 'female',
 '$2y$10$xm0C7Lo4YsCwXnP3FbSfuOnECFlR3ffsNkUFtKeRNoA.zJmMExMTK', 'author');
SET @camila = LAST_INSERT_ID();

-- A reader with no published texts, so the seed also shows a non-author account.
INSERT INTO users (name, email, birthdate, gender, password_hash, role) VALUES
('Diego Fontes', 'diego.fontes@stanzai.demo', '1996-11-11', 'male',
 '$2y$10$xm0C7Lo4YsCwXnP3FbSfuOnECFlR3ffsNkUFtKeRNoA.zJmMExMTK', 'reader');
SET @diego = LAST_INSERT_ID();

-- ============================================================
-- Texts
-- cover_image is left NULL on purpose: no real files exist in
-- frontend/img/uploads/, and the catalog is expected to show a
-- placeholder for NULL covers.
-- ============================================================

INSERT INTO texts (author_id, title, body, description, category, cover_image, visibility, language, read_count) VALUES
(@autor, 'O Silêncio das Estrelas',
'Há um silêncio entre as estrelas que ninguém ousa nomear.
Ele mora no intervalo entre um verso e o próximo,
na pausa antes do grito, no fôlego antes do choro.

Eu aprendi a escutar esse silêncio
quando a cidade dormia e eu ainda escrevia,
tentando encontrar, entre a tinta e o vazio,
um lugar onde o tempo não doesse tanto.',
'Uma coleção de poemas sobre solidão e o cosmos.',
'poetry', NULL, 'public', 'ptbr', 340);
SET @t1 = LAST_INSERT_ID();

INSERT INTO texts (author_id, title, body, description, category, cover_image, visibility, language, read_count) VALUES
(@autor, 'Cartas que Nunca Enviei',
'Eu guardava as cartas numa caixa de sapato, debaixo da cama, como se escondê-las do mundo as tornasse menos verdadeiras. Cada uma começava com o nome dele e terminava sem assinatura, porque eu nunca tive certeza de quem estava escrevendo: se era eu ou a versão de mim que ainda esperava por uma resposta.

Anos depois, ao reencontrá-lo por acaso numa livraria, entendi que as cartas nunca foram para ele. Eram para a pessoa que eu precisava me tornar antes de conseguir deixá-lo ir.',
'Um romance epistolar sobre reencontros e cartas que nunca chegaram ao destino.',
'book', NULL, 'public', 'ptbr', 128);
SET @t2 = LAST_INSERT_ID();

INSERT INTO texts (author_id, title, body, description, category, cover_image, visibility, language, read_count) VALUES
(@rafael, 'A Última Colheita',
'O céu estava seco havia três meses quando Seu Ananias decidiu colher o milho mesmo assim, fileira por fileira, como se a terra ainda lhe devesse alguma coisa. Os vizinhos diziam que era teimosia; ele dizia que era memória — a mesma terra que alimentara seu pai, e o pai do seu pai, não podia simplesmente parar de dar.

Na última noite antes da colheita, choveu. Não o bastante para salvar a plantação inteira, mas o suficiente para que Ananias voltasse a acreditar, por mais uma estação, que valia a pena continuar plantando.',
'Um conto sobre a vida no interior antes da seca, e a teimosia de quem planta mesmo assim.',
'story', NULL, 'public', 'ptbr', 512);
SET @t3 = LAST_INSERT_ID();

INSERT INTO texts (author_id, title, body, description, category, cover_image, visibility, language, read_count) VALUES
(@rafael, 'Sonata em Ré Menor',
'A música entra pela janela antes do sol,
um violino que ninguém vê tocar,
e eu me pergunto se é o vizinho
ou apenas a lembrança de um vizinho
que um dia foi embora e deixou a nota presa no ar.

Ré menor é a tonalidade da saudade,
dizem os que entendem de escalas.
Eu só sei que toda manhã em que ela toca,
eu escrevo um verso a menos
e escuto um pouco mais.',
'Poemas inspirados em música clássica e nas manhãs em que ela some.',
'poetry', NULL, 'public', 'ptbr', 76);
SET @t4 = LAST_INSERT_ID();

INSERT INTO texts (author_id, title, body, description, category, cover_image, visibility, language, read_count) VALUES
(@rafael, 'The Clockmaker''s Daughter',
'Every clock in her father''s shop ran three minutes fast, and for years she thought it was carelessness. It was only after his funeral, sorting through the workbench drawers, that she found the note: "So you will always have three minutes more than you think. Use them well."

She kept one clock — the smallest, the one he made for her tenth birthday — and let the rest run down, one by one, until the shop finally fell silent. It felt less like an ending than like time, for once, deciding to rest.',
'A short story about time, loss, and forgiveness, told through the clocks a father left behind.',
'story', NULL, 'public', 'enus', 203);
SET @t5 = LAST_INSERT_ID();

INSERT INTO texts (author_id, title, body, description, category, cover_image, visibility, language, read_count) VALUES
(@camila, 'Retratos de um Bairro Esquecido',
'Ninguém fotografa a padaria da esquina, nem a fila do ponto de ônibus às seis da manhã, nem a senhora que rega as plantas na janela do segundo andar todos os dias, chova ou faça sol. E no entanto é disso que um bairro é feito: da repetição silenciosa de gente que continua aparecendo.

Passei um ano anotando esses retratos que ninguém tira. No fim, entendi que não estava escrevendo sobre o bairro — estava escrevendo sobre o que significa pertencer a um lugar que o resto da cidade decidiu não ver.',
'Crônicas urbanas sobre memória, rotina e pertencimento.',
'book', NULL, 'public', 'ptbr', 891);
SET @t6 = LAST_INSERT_ID();

INSERT INTO texts (author_id, title, body, description, category, cover_image, visibility, language, read_count) VALUES
(@camila, 'Jardim de Cinzas',
'Depois do incêndio, todos disseram que o jardim não voltaria.
Eu voltei todo domingo mesmo assim,
com um regador e nenhuma certeza,
até que uma manhã de agosto
encontrei uma folha verde nascendo do cinza.

Não escrevo isso como metáfora.
Escrevo porque aconteceu,
e porque às vezes a gente precisa
que uma coisa aconteça de verdade
para acreditar que pode acontecer de novo.',
'Poemas sobre reconstrução e recomeço depois da perda.',
'poetry', NULL, 'public', 'ptbr', 45);
SET @t7 = LAST_INSERT_ID();

INSERT INTO texts (author_id, title, body, description, category, cover_image, visibility, language, read_count) VALUES
(@camila, 'El Eco de la Montaña',
'El pueblo quedó vacío después de que el río cambió de curso, pero los ancianos juraban que, en las noches sin viento, todavía se podía escuchar el eco de las campanas de la iglesia que nadie había tocado en cuarenta años.

Cuando la joven geóloga subió a instalar sus sensores, no buscaba fantasmas: buscaba fallas geológicas. Pero la noche en que los sensores registraron una vibración sin origen aparente, ella entendió que algunas preguntas de la montaña no tienen respuesta científica, solo memoria.',
'Un cuento sobre un pueblo olvidado en los Andes y los ecos que deja el abandono.',
'story', NULL, 'public', 'es', 167);
SET @t8 = LAST_INSERT_ID();

INSERT INTO texts (author_id, title, body, description, category, cover_image, visibility, language, read_count) VALUES
(@autor, 'Diário de um Inverno',
'Fechei a porta do apartamento em março, prometendo a mim mesma que seria só até as coisas fazerem sentido de novo. Não sabia, então, que "até fazer sentido" podia durar um inverno inteiro, feito de dias tão parecidos que eu perdi a conta de quantos já haviam passado.

Este diário não é sobre o que aconteceu lá fora — é sobre o que sobrou depois de eu parar de fugir de mim mesma por tempo suficiente para escutar. Ainda não sei se terminou bem. Sei que terminou verdadeiro.',
'Um relato ficcional sobre isolamento, inverno e autodescoberta.',
'book', NULL, 'private', 'ptbr', 12);
SET @t9 = LAST_INSERT_ID();

INSERT INTO texts (author_id, title, body, description, category, cover_image, visibility, language, read_count) VALUES
(@rafael, 'Fábula do Rio Seco',
'Era uma vez um rio que, cansado de ser atravessado sem ser notado, decidiu secar por uma estação inteira só para ver quem sentiria falta. Os peixes reclamaram primeiro, depois os pescadores, depois a cidade inteira, que descobriu tarde demais o quanto dependia daquilo que nunca tinha agradecido.

Quando as chuvas finalmente voltaram, o rio escutou, pela primeira vez, um "obrigado" gritado da margem. E seguiu seu curso, um pouco mais devagar, como quem aprendeu que ser lembrado vale mais do que ser aproveitado.',
'Uma fábula moderna sobre escassez, gratidão e comunidade.',
'story', NULL, 'public', 'ptbr', 634);
SET @t10 = LAST_INSERT_ID();

-- ============================================================
-- Genres per text (uses the genres already seeded by schema.sql)
-- ============================================================

INSERT INTO text_genres (text_id, genre_id) VALUES
(@t1,  (SELECT id FROM genres WHERE name = 'Poesia Lírica')),
(@t2,  (SELECT id FROM genres WHERE name = 'Romance')),
(@t3,  (SELECT id FROM genres WHERE name = 'Drama')),
(@t4,  (SELECT id FROM genres WHERE name = 'Poesia Lírica')),
(@t5,  (SELECT id FROM genres WHERE name = 'Drama')),
(@t5,  (SELECT id FROM genres WHERE name = 'Mistério')),
(@t6,  (SELECT id FROM genres WHERE name = 'Drama')),
(@t7,  (SELECT id FROM genres WHERE name = 'Poesia Lírica')),
(@t8,  (SELECT id FROM genres WHERE name = 'Mistério')),
(@t8,  (SELECT id FROM genres WHERE name = 'Aventura')),
(@t9,  (SELECT id FROM genres WHERE name = 'Drama')),
(@t10, (SELECT id FROM genres WHERE name = 'Aventura'));

-- ============================================================
-- A handful of reading logs, so reading_logs isn't empty either
-- (useful later for the Author Portal analytics).
-- ============================================================

INSERT INTO reading_logs (reader_id, text_id, time_spent_seconds) VALUES
(@diego,  @t3,  245),
(@diego,  @t6,  512),
(@diego,  @t10, 180),
(@autor,  @t8,  310),
(@rafael, @t6,  95),
(@camila, @t5,  260);
