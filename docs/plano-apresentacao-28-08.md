# Plano — Apresentação de 28/08/2026

> Documento de acompanhamento para as 4 exigências do professor: **CRUD funcional**, **autenticação (registro e login)**, **landing page** e **algo relacionado a APIs**.
>
> **Continuação do `plano-apresentacao-14-08.md`** (removido do repo). As decisões de arquitetura daquele plano continuam valendo: PHP procedural puro, PDO, sessão nativa, sem Composer/framework, formulários POST tradicionais. O que muda aqui é o escopo — o dia 14 pedia landing + auth + admin, o dia 28 pede CRUD completo + API.
>
> **Base de referência:** `exemplo-professor/` (pasta local, ignorada pelo git) com quatro documentos — `fundamentos-do-PHP-parte-1.md`, `php-crud-pdo-basico.md`, `php-crud-pdo-refinado.md`, `desenvolvimento-de-apis-em-php.md` — e o site completo `pinanoteca-exemplo/`, que é o nível-alvo de código que o professor reconhece.

---

## 0. Prazo real

Hoje é **segunda, 24/08**. A apresentação é **sexta, 28/08**.

| Dia | Data | Foco |
|---|---|---|
| Seg | 24/08 | Destravar o CREATE (está quebrado) |
| Ter | 25/08 | READ — leitura e catálogo dinâmicos |
| Qua | 26/08 | UPDATE + DELETE |
| Qui | 27/08 | API JSON + catálogo consumindo via `fetch` |
| Sex | 28/08 | Landing, polimento, seed, ensaio |

São **4 dias úteis de trabalho**, com a manhã de sexta reservada para ensaio. O escopo abaixo cabe nisso, mas só se o CREATE for destravado hoje — tudo depende dele.

---

## 1. O que o material do professor determina

### 1.1 Sobre CRUD (`php-crud-pdo-basico.md` + `php-crud-pdo-refinado.md`)

O que ele quer ver, literalmente:

- **PDO com prepared statements** — `prepare()` + `execute([':nome' => $valor])`, nunca concatenação de string em SQL. Ele cita SQL Injection como a razão principal de existir do PDO.
- **`try/catch (PDOException)`** na conexão.
- **`fetchAll(PDO::FETCH_ASSOC)`** para listas, **`fetch(PDO::FETCH_ASSOC)`** para um registro único.
- **`lastInsertId()`** após o INSERT, **`rowCount()`** após UPDATE/DELETE, para dar feedback ao usuário.
- **"Nunca esqueça o WHERE no DELETE"** — ele escreve isso em maiúsculas no material.
- **`require_once` para conexão e para blocos de HTML** (cabeçalho/rodapé) — o "refinado" é inteiro sobre isso. Já fazemos: `config/database.php` e `frontend/header.php`.

O nosso `backend/create.php` já está acima desse nível (validação de MIME real no upload, nome de arquivo aleatório, `error_log` em vez de vazar o erro do banco). Isso é bom — mas só se ele **funcionar**, e hoje não funciona. Ver seção 2.

### 1.2 Sobre APIs (`desenvolvimento-de-apis-em-php.md`)

A aula é conceitual e termina com um exercício explícito: *"Implemente o código que existe no final do texto."* O exercício é um `products.php` que devolve um array fixo em JSON com `http_response_code(200)`.

Fazer só isso seria entregar o mínimo. O próprio texto aponta o caminho seguinte (seção 19: *"Depois podemos substituir Array PHP por MariaDB"*), com o diagrama `Cliente REST → API PHP → PDO → MariaDB → JSON`. **É esse diagrama que vamos entregar** — e ele encaixa perfeitamente no CRUD que já vamos construir.

Conceitos que o texto cobre e que a nossa API precisa exibir para "bater" com a aula:

| Conceito da aula | Como aparece na nossa API |
|---|---|
| `GET` = consultar | `GET /backend/api/texts.php` (lista) e `?id=N` (um texto) |
| `POST` = criar | `POST /backend/api/texts.php` com JSON no corpo |
| `PUT` = atualizar | `PUT /backend/api/texts.php?id=N` |
| `DELETE` = excluir | `DELETE /backend/api/texts.php?id=N` |
| `json_encode()` / `json_decode()` | resposta e leitura do corpo |
| `file_get_contents("php://input")` | como o PHP lê JSON (≠ `$_POST`) |
| `header("Content-Type: application/json")` | em toda resposta |
| `http_response_code()` | 200, 201, 400, 401, 404, 405, 422, 500 |
| Route / Query String / Body / Header | id e filtros na query string, dados no body |
| Cliente REST (Postman/Insomnia) | a demonstração |
| Página Web ≠ API (seção 2 da aula) | temos as duas coisas sobre o mesmo banco |

> **Esse último ponto é o trunfo da apresentação.** A aula inteira gira em torno de "uma página web responde HTML, uma API responde JSON, e o objetivo é diferente". Nós vamos ter, sobre a **mesma tabela `texts`**, o `frontend/read.php` devolvendo HTML para o navegador e o `api/texts.php` devolvendo JSON para um cliente REST. É a tabela da seção 2 da aula dele, demonstrada ao vivo. Vale abrir a apresentação por aí.

### 1.3 O que o exemplo `pinanoteca-exemplo/` mostra sobre estrutura

Nomenclatura de arquivos do CRUD dele (`admin/products/`):

```
index.php   → lista (SELECT + foreach)
create.php  → formulário
store.php   → recebe o POST, insere, header('Location: index.php')
edit.php    → formulário preenchido (SELECT por id)
update.php  → recebe o POST, atualiza, redireciona
delete.php  → apaga por id, redireciona
```

Nós **não vamos copiar essa divisão**, porque a nossa arquitetura já separa `frontend/` (tela) de `backend/` (ação) — o que dá no mesmo: `frontend/edit.php` é o `edit.php` dele, `backend/update.php` é o `update.php` dele. A equivalência é 1:1 e vale explicar isso na apresentação, para ele reconhecer o padrão.

Uma coisa dele que **vale copiar**: o `onclick="return confirm(...)"` no link de delete. É a única linha de JavaScript no projeto inteiro dele — ou seja, ele considera confirmação de exclusão obrigatória.

---

## 2. Estado atual — auditoria honesta

### 2.1 O que já existe e funciona

| Item | Arquivo | Estado |
|---|---|---|
| Conexão PDO | `backend/config/database.php` | ✅ pronto, com `try/catch` e `ERRMODE_EXCEPTION` |
| Registro | `backend/register.php` + `frontend/register.php` + `partials/modal-register.php` | ✅ funciona: valida vazio, checa e-mail duplicado, `password_hash`, cria sessão |
| Login | `backend/login.php` + `frontend/login.php` + `partials/modal-login.php` | ✅ funciona: aceita e-mail ou nome, `password_verify`, grava `$_SESSION['user_id']` e `role` |
| Logout | `backend/logout.php` | ✅ funciona |
| Guarda de admin | `backend/includes/auth.php` | ✅ pronta |
| Landing page | `frontend/landing.php` | ✅ hero + modais de login/registro, visual pronto |
| Schema | `db/schema.sql` | ✅ tabelas `users`, `texts`, `genres`, `reading_logs`, `embeddings` |

**A autenticação — uma das 4 exigências — já está essencialmente entregue.** Falta só o item 5.2 abaixo (tornar a sessão *visível*).

### 2.2 Os três bugs que travam o CREATE (CORRIGIDOS!!!!!!!!!)

O commit `a838d4a` ("backend: add CREATE logic") não foi testado ponta a ponta. Três defeitos impedem qualquer inserção:

**Bug 1 — `$body` nunca é lido.** Em [backend/create.php:60](backend/create.php:60), o `execute()` passa `$body`, mas essa variável não é definida em lugar nenhum do arquivo. Com `ERRMODE_EXCEPTION` ligado e `body TEXT NOT NULL`, isso lança `PDOException` e o usuário cai em `?erro=erro_interno` sem entender por quê.

**Bug 2 — o formulário envia GET, não POST.** [frontend/create.php:23](frontend/create.php:23) é `<form action="../backend/create.php">`, sem `method` e sem `enctype`. Sem `method="POST"` todo `$_POST` chega vazio; sem `enctype="multipart/form-data"` o `$_FILES` da capa nunca é populado.

**Bug 3 — os valores de categoria não existem no banco.** O `<select>` manda `book` / `poetry` / `story`, e o ENUM da coluna é `('livro','poesia','conto')`. Valor fora do ENUM em modo estrito = erro de inserção.

> **Sobre o Bug 1, a correção certa não é adicionar um campo "corpo do texto" no formulário de criação.** Olhando o fluxo desenhado pelo João, a intenção é clara: `create.php` cadastra os *metadados* (título, descrição, capa, categoria, idioma, visibilidade) e a escrita acontece depois, na tela de edição. Então o INSERT deve gravar `body = ''` e redirecionar para **`edit.php?id=N`**, não para `read.php?id=N`. Isso também torna o CRUD muito melhor de demonstrar: criar → cair direto no editor → salvar → ler.

### 2.3 O que ainda não existe

| Faltando | Impacto |
|---|---|
| Qualquer `SELECT` no `frontend/` | `home.php`, `catalog.php` e `read.php` são **HTML estático com cards falsos** ("Title Example Like This One", "232 views"). Nada vem do banco. |
| `backend/update.php` | Sem UPDATE. `frontend/edit.php` é um mockup com `<form action="  ALGUMA ACAO  ">`. |
| `backend/delete.php` | Sem DELETE. |
| `backend/api/` | Sem API. |
| `db/seed.sql` | Sem dados, o catálogo aparece vazio na apresentação. |
| Corpo do `backend/admin/index.php` | São 2 linhas de `require` e nada mais — não imprime nada. |

### 2.4 Pontas soltas menores (anotar, não priorizar)

- `frontend/auth.php` é um mockup morto (`<form action=" ddd ">`, "Reenviar código"). **Não deve aparecer na apresentação.** Apagar ou deixar fora de qualquer link.
- `backend/login.php` busca por `WHERE name = ?`, mas `name` não é `UNIQUE` no schema — dois usuários com o mesmo nome quebram o login por nome. Sem tempo agora; se sobrar, adicionar `UNIQUE` em `users.name`.
- `backend/register.php` redireciona com caminho absoluto (`/stanza/frontend/home.php`) enquanto `login.php` usa relativo (`../frontend/home.php`). Funciona, mas padronize no absoluto — é mais previsível.
- `frontend/header.php` não sabe se existe sessão: não mostra o nome do usuário nem link de sair.

---

## 3. Decisões fechadas para o dia 28

| Decisão | Escolha | Por quê |
|---|---|---|
| **Forma do CRUD** | C = `frontend/create.php` · R = `frontend/read.php?id=N` (+ `catalog.php` como listagem) · U = `frontend/edit.php?id=N` · D = botão dentro da tela de edição | Definido pelo Igor. Encaixa nas telas que o João já desenhou — nenhuma tela nova precisa ser criada. |
| **Onde o CRUD vive** | Na área do usuário logado, sobre os **próprios textos** | É o produto real. O painel admin não é exigência do dia 28. |
| **Permissão de edição** | Só o autor edita/apaga o próprio texto (`WHERE id = ? AND author_id = ?`) | Sem isso, qualquer usuário logado apaga texto alheio trocando o `?id=` na URL. Item de segurança inegociável. |
| **Estilo de formulário** | POST tradicional + `header('Location: ...')` | Mantido do plano de 14/08 e do exemplo do professor. |
| **Demonstração da API** | `api/texts.php` (JSON, 5 endpoints) demonstrada no **Insomnia/Postman** + **catálogo consumindo via `fetch`** | Escolha do Igor. O cliente REST mostra o conceito da aula; o `fetch` mostra efeito visível na tela. |
| **Roteamento da API** | Query string: `api/texts.php?id=2` | PHP puro sem `.htaccess`/mod_rewrite. A própria aula (seção 17) apresenta a query string como lugar legítimo de dados. URL bonita (`/api/texts/2`) fica como opcional da seção 8. |
| **Autenticação na API** | Sessão PHP (o `fetch` de mesma origem já manda o cookie); escritas sem sessão respondem **401** | Reaproveita o que já existe. A aula cita `Authorization: Bearer` como assunto futuro — mencione isso na fala, não implemente. |
| **Painel admin** | Fora do escopo obrigatório | Não está na lista de exigências do dia 28. Ver seção 8 (opcionais). |

### 3.1 Sobre duplicar lógica entre `backend/create.php` e `api/texts.php`

Sim, vai existir código parecido nos dois: os dois inserem em `texts`. **Isso é proposital e é exatamente o ponto pedagógico da seção 2 da aula** ("Uma página Web e uma API não são a mesma coisa"). Um recebe `$_POST` de um formulário e responde com redirecionamento; o outro recebe JSON em `php://input` e responde com JSON + status code. Mesmo banco, clientes diferentes, objetivos diferentes.

Não tente unificar os dois em uma camada compartilhada esta semana — isso é refatoração para OOP, que é justamente o que o `backend-php/` congelado vai fazer mais tarde. Duplicar aqui é a escolha certa pelo prazo e pelo nível esperado.

---

## 4. Definição de "pronto" por exigência

- **CRUD funcional:** usuário logado cria um texto pelo formulário → é levado ao editor → escreve o corpo e salva → abre a tela de leitura e vê o que escreveu → o texto aparece no catálogo → volta na edição, altera o título, salva, e a mudança aparece na leitura → aperta apagar, confirma, e o texto some do catálogo. **Tudo isso sem tocar no phpMyAdmin.**
- **Autenticação:** criar conta → sair → entrar de novo → o cabeçalho mostra o nome do usuário → tentar abrir `edit.php?id=N` deslogado redireciona para o login → tentar editar o texto de outra pessoa é bloqueado.
- **Landing page:** visitante deslogado abre `http://localhost/stanza/` e cai na landing, com CTA que abre os modais de entrar/cadastrar.
- **API:** no Insomnia, os 5 endpoints respondem JSON com o status code correto, incluindo os casos de erro (404 em id inexistente, 401 sem sessão, 405 em método não suportado). E o catálogo do site carrega os cards a partir dessa mesma API.

---

## 5. Cronograma dia a dia

### Segunda 24/08 — Destravar o CREATE

Sem isso, nada mais anda. Deve caber em uma tarde.

**5.1 — Alinhar as categorias.** O código do projeto é em inglês (convenção do `CLAUDE.md`) e o ENUM está em português. Alinhe o banco ao código, mantendo os rótulos da interface em português:

```bash
/opt/lampp/bin/mysql -u root stanza -e "ALTER TABLE texts MODIFY category ENUM('book','poetry','story') NOT NULL;"
```

Confira antes se já existem linhas com valores antigos (`SELECT DISTINCT category FROM texts;`) — se a tabela estiver vazia, o `ALTER` é indolor. Atualize `db/schema.sql` junto, senão quem reimportar o schema recria o problema.

*(Alternativa, se preferir não mexer no banco: trocar os `value` dos `<select>` em `create.php` e `edit.php` para `livro`/`poesia`/`conto`. Funciona igual, mas vai contra a convenção de inglês.)*

**5.2 — Corrigir o formulário** em `frontend/create.php`:

```php
<form action="../backend/create.php" method="POST" enctype="multipart/form-data">
```

**5.3 — Corrigir `backend/create.php`:**
- definir `$body = '';` antes do INSERT (o corpo será escrito na tela de edição);
- trocar o redirect final de `read.php?id=` para `edit.php?id=`;
- trocar os acessos diretos `$_POST['title']` etc. por `$_POST['title'] ?? ''` — hoje um POST incompleto gera warning antes da validação rodar.

**5.4 — Testar ponta a ponta pelo navegador**, e depois pelo terminal (o `-i` mostra o header `Location`, que é onde a resposta aparece nesse padrão de redirect):

```bash
curl -i -X POST -d "title=Teste&desc=Descricao&category=book&language=ptbr&visibility=public" http://localhost/stanza/backend/create.php
```

Sem sessão isso vai redirecionar para o login — o que já prova que a guarda funciona. Para testar a inserção de verdade, use o navegador logado.

**5.5 — Criar `db/seed.sql`** com 1 usuário de demonstração e ~10 textos variados (categorias e autores diferentes, alguns com `read_count` alto). O catálogo precisa parecer um site vivo na sexta, e é muito mais rápido escrever isso hoje do que cadastrar dez textos na mão. Deixe a senha do usuário de demo como um hash gerado por `password_hash` (rode `php -r "echo password_hash('123456', PASSWORD_DEFAULT);"` e cole o resultado).

---

### Terça 25/08 — READ

**5.6 — `frontend/read.php` dinâmico.** Hoje é HTML estático. Passe a:

```php
<?php
require_once __DIR__ . '/../backend/config/database.php';

$id = (int) ($_GET['id'] ?? 0);

$stmt = $pdo->prepare(
    'SELECT t.*, u.name AS author_name
     FROM texts t
     JOIN users u ON u.id = t.author_id
     WHERE t.id = :id'
);
$stmt->execute([':id' => $id]);
$text = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$text) {
    http_response_code(404);
    // exibir "Texto não encontrado" e parar
}

$pdo->prepare('UPDATE texts SET read_count = read_count + 1 WHERE id = :id')
    ->execute([':id' => $id]);
?>
```

Depois substitua os textos chumbados pelo conteúdo real. **Todo dado vindo do banco sai por `htmlspecialchars()`** — a partir de hoje o site exibe conteúdo escrito por usuários, e isso é XSS na veia se sair cru. O exemplo do professor faz isso em todo `<?= ?>` (`htmlspecialchars($product['product_name'])`); no corpo do texto, `nl2br(htmlspecialchars($text['body']))` preserva as quebras de linha.

O `read_count` aqui não é enfeite: ele vira o "232 views" do card e é a primeira métrica real do Portal do Autor.

**5.7 — `frontend/catalog.php` dinâmico (server-side).** Um `SELECT` com `fetchAll` e um `foreach` gerando os cards, no lugar dos ~15 blocos `.post` repetidos:

```php
$stmt = $pdo->prepare(
    "SELECT id, title, category, cover_image, read_count
     FROM texts
     WHERE visibility = 'public'
     ORDER BY created_at DESC"
);
$stmt->execute();
$texts = $stmt->fetchAll(PDO::FETCH_ASSOC);
```

Cada card vira `<a href="read.php?id=<?= $text['id'] ?>">`, e a capa sai de `img/uploads/<?= htmlspecialchars($text['cover_image']) ?>` com um placeholder no `else` quando for `NULL` (o professor faz exatamente esse `if/else` de imagem em `admin/products/index.php`).

> **Essa versão server-side é o seguro da apresentação.** Na quinta o catálogo passa a carregar via `fetch`; se a API der problema no dia, é só reverter esse arquivo e o "R" do CRUD continua funcionando. São ~15 linhas — vale o retrabalho.

**5.8 — Se sobrar tempo:** `home.php` usando a mesma query com `LIMIT 8` e `ORDER BY read_count DESC`.

---

### Quarta 26/08 — UPDATE e DELETE

**5.9 — `frontend/edit.php` dinâmico.** Hoje é mockup. Precisa:
- exigir sessão no topo (redirecionar para o login se não houver);
- `SELECT ... WHERE id = :id AND author_id = :author_id` — se não voltar nada, é 403: ou o texto não existe, ou não é seu;
- preencher `value` / `selected` / `checked` com os dados atuais (a categoria e o idioma originais precisam vir marcados — tem até um comentário do João pedindo isso no arquivo);
- `<form action="../backend/update.php" method="POST" enctype="multipart/form-data">` com um `<input type="hidden" name="id" value="...">`;
- o `<textarea>` do corpo precisa se chamar `body` (hoje é `content`), para casar com a coluna.

**5.10 — `backend/update.php`:**

```php
$sql = 'UPDATE texts
        SET title = :title, body = :body, description = :description,
            category = :category, language = :language, visibility = :visibility
        WHERE id = :id AND author_id = :author_id';
```

O `AND author_id` no `WHERE` é a trava de dono, feita no próprio SQL. Use `rowCount()` para o feedback, exatamente como o material do professor ensina — e lembre que `rowCount() === 0` pode significar "não é seu" **ou** "você salvou sem mudar nada"; trate isso como sucesso silencioso, não como erro. A troca de capa reaproveita o bloco de upload que já está em `create.php` (se nenhum arquivo novo vier, mantenha a capa atual).

**5.11 — `backend/delete.php`:**

```php
$stmt = $pdo->prepare('DELETE FROM texts WHERE id = :id AND author_id = :author_id');
$stmt->execute([':id' => $id, ':author_id' => $_SESSION['user_id']]);
```

Nunca sem o `WHERE` (o material grita isso). O botão fica na tela de edição, com a confirmação do exemplo do professor:

```html
<a href="../backend/delete.php?id=<?= (int) $text['id'] ?>"
   onclick="return confirm('Apagar este texto? Esta ação não pode ser desfeita.');">Apagar</a>
```

Depois de apagar, redirecione para `catalog.php` — assim a exclusão fica visível na hora, o card sumiu.

**5.12 — Rodar o ciclo inteiro** uma vez, do zero: cadastrar usuário novo → criar texto → escrever → ler → editar → apagar. Anote o que quebrar.

---

### Quinta 27/08 — A API

**5.13 — Criar `backend/api/texts.php`.** Arquivo único, um `switch` no método HTTP. Esqueleto:

```php
<?php
require_once __DIR__ . '/../config/database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json; charset=utf-8');

$method = $_SERVER['REQUEST_METHOD'];
$id     = isset($_GET['id']) ? (int) $_GET['id'] : null;

// Corpo JSON das requisições POST/PUT (a aula, seção 12).
$input = json_decode(file_get_contents('php://input'), true) ?? [];

function responder(int $status, array $dados): void
{
    http_response_code($status);
    echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    exit;
}
```

> `JSON_UNESCAPED_UNICODE` não é detalhe: sem essa flag, "Coração" vira `"Coração"` na resposta. Funciona, mas fica feio na hora de mostrar o JSON no Insomnia.

Os cinco endpoints:

| Método | URL | Comportamento |
|---|---|---|
| `GET` | `api/texts.php` | lista os textos públicos. Aceita `?category=book` e `?q=busca` (o `LIKE` monta o filtro; os valores **sempre** por placeholder). `200` |
| `GET` | `api/texts.php?id=2` | um texto. `200`, ou `404` com `{"error": "Text not found"}` |
| `POST` | `api/texts.php` | cria a partir do JSON do corpo. `201` com o recurso criado; `422` se faltar campo; `401` sem sessão |
| `PUT` | `api/texts.php?id=2` | atualiza. `200`; `404` se não existe; `401` sem sessão; `403` se não for o autor |
| `DELETE` | `api/texts.php?id=2` | apaga. `204` sem corpo; `404`/`401`/`403` conforme o caso |

Qualquer outro método cai em `405` com `{"error": "Method not allowed"}`. Envolva as operações de banco em `try/catch (PDOException)` respondendo `500` com uma mensagem genérica e `error_log()` do erro real — nunca devolva `getMessage()` na resposta.

**5.14 — Testar tudo no Insomnia** (ou Postman — a aula cita os dois). Monte uma coleção com as 5 requisições **na ordem da demonstração**, já com o JSON de exemplo preenchido, e deixe salva. Não improvise digitação na sexta.

Para conferir rápido pelo terminal antes:

```bash
curl -i http://localhost/stanza/backend/api/texts.php
```

```bash
curl -i -X POST -H "Content-Type: application/json" -d '{"title":"Via API","description":"Criado pelo Insomnia","category":"poetry"}' http://localhost/stanza/backend/api/texts.php
```

```bash
curl -i http://localhost/stanza/backend/api/texts.php?id=99999
```

O terceiro tem que responder `HTTP/1.1 404` — o caso de erro é tão importante de mostrar quanto o de sucesso, a aula dedica a seção 16 inteira a isso.

**5.15 — Catálogo consumindo a API.** Troque o `foreach` PHP de terça por `fetch` em `frontend/js/catalog.js`:

```js
fetch('../backend/api/texts.php')
  .then(resposta => resposta.json())
  .then(textos => {
      // montar os cards no DOM
  });
```

Ligue os filtros que já existem na tela (categoria, busca) aos parâmetros `?category=` e `?q=` — é a query string da seção 17 da aula servindo para algo visível. Mostre um estado de "carregando" e trate a falha com uma mensagem, para não ficar tela branca se der erro.

**Guarde a versão server-side do catálogo** (`catalog-server.php` ou um commit separado) para poder voltar atrás em 30 segundos se algo der errado na sexta.

---

### Sexta 28/08 — Landing, polimento e ensaio

**5.16 — Ponto de entrada.** Crie `index.php` na raiz do projeto:

```php
<?php
header('Location: frontend/landing.php');
exit;
```

Assim a demonstração começa em `http://localhost/stanza/` e não numa URL com `/frontend/landing.php` no meio.

**5.17 — Cabeçalho com sessão.** `frontend/header.php` hoje não sabe se alguém está logado. Adicione: se `$_SESSION['user_id']` existe, mostrar "Olá, {nome}" e o link `../backend/logout.php`; se não, mostrar "Entrar". **É isso que torna a autenticação visível na apresentação** — sem isso, o professor não tem como ver que a sessão persiste entre as páginas.

**5.18 — Limpeza:**
- apagar `frontend/auth.php` (mockup morto com `action=" ddd "`);
- trocar os `href` de placeholder que sobraram (`"LINNNNK"`, `"forgottt"`, `"reeeeenviar"`, `"searchh"`, `action="/search"`) por links reais ou `#`;
- padronizar os redirects de `register.php` no formato absoluto.

**5.19 — Carregar o seed** e conferir o site inteiro com dados de verdade, no navegador e no celular (o projeto é Mobile First — abra pelo DevTools em largura de celular; é ponto fácil de ganhar com esse professor, que tem um `docs/didactic/02-mobile-first.md` no exemplo dele).

**5.20 — Ensaiar o roteiro da seção 6, cronometrado, pelo menos duas vezes.**

---

## 6. Roteiro da apresentação (~8 minutos)

Uma ordem que faz as 4 exigências aparecerem como uma história só, em vez de quatro demonstrações soltas:

1. **Landing (40s)** — abrir `http://localhost/stanza/`. "Esta é a porta de entrada para quem não tem conta."
2. **Registro (1min)** — criar uma conta ao vivo, no modal. Mostrar no phpMyAdmin que a senha foi gravada como hash, não como texto puro. *Fala:* `password_hash()` + prepared statement, os dois motivos que o material do PDO dá para não fazer do jeito antigo.
3. **CREATE (1min)** — criar um texto, cair no editor, escrever, salvar.
4. **READ (1min)** — abrir a tela de leitura. Recarregar e mostrar o contador de visualizações subindo — é um `UPDATE` acontecendo ao vivo.
5. **UPDATE (40s)** — mudar o título, salvar, ver a mudança na leitura.
6. **DELETE (30s)** — apagar, confirmar no `confirm()`, o card some do catálogo. *Fala:* "`DELETE` sempre com `WHERE`."
7. **A virada para API (2min)** — "Tudo o que vocês viram até agora foi o navegador recebendo HTML. Agora a mesma informação, para outro tipo de cliente." Abrir o Insomnia. `GET` da lista → o mesmo texto de antes, agora em JSON. `GET ?id=99999` → `404`. `POST` criando um texto → `201`. **Voltar ao navegador, recarregar o catálogo, e o texto criado pelo Insomnia está lá.** Esse é o momento da apresentação.
8. **Fechamento (30s)** — o catálogo do site consome essa mesma API por `fetch`. Mencionar que o próximo passo é autenticação por `Authorization: Bearer` para clientes fora do navegador (a aula cita isso na seção 17) e que a mesma API vai ser a ponte para o motor de recomendação em Python.

**Tenha um plano B para cada passo.** Se o upload de capa falhar, siga sem capa. Se o `fetch` do catálogo falhar, volte para a versão server-side. Nunca depure ao vivo — siga em frente e comente depois.

---

## 7. Riscos

| Risco | Probabilidade | Mitigação |
|---|---|---|
| O CREATE não destravar hoje | Média | É o item de maior prioridade absoluta. Se segunda acabar sem CREATE funcionando, corte o `fetch` do catálogo (5.15) do escopo. |
| `PUT`/`DELETE` bloqueados pelo Apache | Baixa | XAMPP aceita os dois por padrão. Se der `405` vindo do servidor (não do nosso código), o contorno é `POST` com `?_method=PUT` — mas teste **quinta**, não sexta. |
| Upload de capa quebrar no dia | Média | A coluna é `DEFAULT NULL` e o catálogo tem placeholder. Se der problema, demonstre sem capa. |
| Editor mobile/desktop divergindo | Média | `edit.php` tem dois `<textarea>` (barra web e mobile) com o mesmo `id="content"` — **id duplicado é HTML inválido e vai confundir o `$_POST`**. Resolva em 5.9: um `<textarea name="body">` só, mostrado por CSS nos dois layouts. |
| Banco vazio na hora H | Baixa | `db/seed.sql` pronto desde segunda. |

---

## 8. Fora do escopo (só se sobrar tempo)

Não comece nada disto antes de a seção 4 inteira estar cumprida:

- **Painel admin** (`backend/admin/index.php`, hoje um stub de 2 linhas): listagem de usuários e textos com a guarda que já existe em `includes/auth.php`. Foi prometido em 14/08 e é barato — mas não é exigência do dia 28.
- **URL bonita para a API** (`/api/texts/2`) via `.htaccess` + `mod_rewrite`, para bater com os exemplos literais da aula.
- **Token CSRF** nos formulários de POST.
- **`UNIQUE` em `users.name`** (ver 2.4).
- **`home.php` dinâmico** com "vistos recentemente" de verdade, usando `reading_logs`.
- **Paginação** no catálogo (`?page=` — mais um uso de query string).

---

## 9. Checklist

**Segunda 24/08**
- [ ] `ALTER TABLE` da categoria + `db/schema.sql` atualizado
- [ ] `method="POST"` + `enctype` no formulário de criação
- [ ] `$body = ''` e redirect para `edit.php` em `backend/create.php`
- [ ] Um texto criado com sucesso pelo navegador
- [ ] `db/seed.sql` com usuário de demo + ~10 textos

**Terça 25/08**
- [ ] `read.php` lendo do banco, com `htmlspecialchars` e 404
- [ ] `read_count` incrementando
- [ ] `catalog.php` listando do banco (server-side)

**Quarta 26/08**
- [ ] `edit.php` preenchido com os dados atuais, `<textarea name="body">` único
- [ ] `backend/update.php` com trava de autor no `WHERE`
- [ ] `backend/delete.php` com `WHERE` e `confirm()`
- [ ] Ciclo completo criar → ler → editar → apagar rodado uma vez

**Quinta 27/08**
- [ ] `backend/api/texts.php` com os 5 endpoints
- [ ] Status codes conferidos: 200, 201, 401, 404, 405
- [ ] Coleção do Insomnia salva, na ordem da demonstração
- [ ] Catálogo consumindo a API por `fetch` (com a versão server-side guardada)

**Sexta 28/08**
- [ ] `index.php` na raiz redirecionando para a landing
- [ ] Cabeçalho mostrando usuário logado + sair
- [ ] `frontend/auth.php` apagado e placeholders limpos
- [ ] Seed carregado e site conferido no mobile
- [ ] Roteiro ensaiado 2x, cronometrado
