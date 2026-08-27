# Plano de implementação — UPDATE e DELETE

> Continuação de [`plano-apresentacao-28-08.md`](plano-apresentacao-28-08.md), seção 5.9–5.12 (a etapa marcada para quarta 26/08).
> As decisões daquele plano continuam valendo: PHP procedural, PDO com prepared statements, POST tradicional + `header('Location: ...')`, sem framework.
>
> **Escopo desta etapa:** o "U" e o "D" do CRUD, os dois na tela `frontend/edit.php`. O UPDATE é o botão **Salvar**; o DELETE é o botão **Excluir**, dentro da mesma tela.

---

## 0. Onde estamos de verdade

Hoje é **quinta, 27/08**. A apresentação é **amanhã**.

O último commit (`22527f3`, "backend: add READ logic") entregou o READ. Comparado ao cronograma original:

| Etapa | Previsto | Estado |
|---|---|---|
| CREATE | seg 24/08 | ✅ feito |
| `read.php` dinâmico | ter 25/08 | ✅ feito |
| `catalog.php` dinâmico | ter 25/08 | ❌ **não feito** — ainda é HTML estático |
| UPDATE + DELETE | qua 26/08 | ❌ é este documento |
| API JSON | qui 27/08 | ❌ pendente |

Duas consequências práticas:

1. **UPDATE + DELETE precisam sair hoje de manhã**, porque a API (que vale um bloco inteiro do roteiro) ainda não começou.
2. **O `catalog.php` estático quebra a demonstração do DELETE.** O roteiro (item 6) é "apagar → confirmar → o card some do catálogo". Com o catálogo chumbado, o card não some — os cards são falsos. Ver seção 6 deste documento: ou o catálogo vira dinâmico (~15 linhas, tarefa pendente de terça), ou o DELETE redireciona para outro lugar.

---

## 1. Convenção de arquitetura que vamos seguir

O commit do READ fixou um padrão que o plano original não previa, e que é melhor do que o previsto. **Vamos seguir ele:**

| Papel | Arquivo | O que faz |
|---|---|---|
| **Lógica de leitura** (SELECT + guardas) | `backend/edit.php` | Consulta o texto, valida sessão e dono, define `$text`. Não imprime nada. |
| **Tela** (HTML) | `frontend/edit.php` | `require_once` do de cima na primeira linha e usa `$text` no markup. |
| **Ação** (recebe POST, grava, redireciona) | `backend/update.php` e `backend/delete.php` | Igual ao `backend/create.php` que já existe. |

É exatamente o par `backend/read.php` + `frontend/read.php`. E é a mesma equivalência 1:1 com o exemplo do professor que o plano original já anotou (seção 1.3): o `edit.php` dele = nosso `backend/edit.php` + `frontend/edit.php`; o `update.php` dele = nosso `backend/update.php`; o `delete.php` dele = nosso `backend/delete.php`.

> **Detalhe de caminho:** `backend/read.php` usa `require_once __DIR__ . '/../backend/config/database.php'` — sobe um nível e volta pra `backend/`. Funciona, mas dá volta. Nos arquivos novos use `__DIR__ . '/config/database.php'`, como o `backend/create.php` faz. Se sobrar tempo, padronize o `read.php` junto.

---

## 2. Auditoria do `frontend/edit.php` atual

O arquivo é um mockup do João, sem uma linha de PHP. São **13 problemas** entre aqui e um editor funcional. Vale ler a lista inteira antes de mexer, porque três deles são armadilhas que só aparecem em runtime.

### 2.1 Estruturais (mudam o layout do arquivo)

**P1 — O `<form>` não envolve os campos.** Este é o problema principal. Hoje ([frontend/edit.php:108](../frontend/edit.php:108)) o form começa depois da `.bar` e envolve só o `<textarea>` e a `.mbbt2`. Ou seja: capa, categoria, idioma e visibilidade — **tudo o que está dentro da `.bar` — ficaria de fora do POST**. O form precisa passar a envolver a página inteira: abre logo depois do `<body>`, fecha antes do `<script>`.

**P2 — ⚠️ Botão sem `type` dentro de form é `submit`.** Consequência direta do P1: assim que a `.bar` entrar no form, o `<button class="fecha" id="fecharBar">X</button>` ([edit.php:21](../frontend/edit.php:21)) e o `<button id="abrirBar">⋮</button>` ([edit.php:103](../frontend/edit.php:103)) **passam a enviar o formulário quando clicados**, porque `<button>` sem `type` tem `type="submit"` por padrão. No mobile, abrir a barrinha de opções salvaria o texto e recarregaria a página. Os dois precisam de `type="button"` explícito. O `create.php` já faz isso no botão "Cancelar" — é a mesma correção.

**P3 — Não existe campo de título.** O `<h2>Título</h2>` ([edit.php:23](../frontend/edit.php:23)) é só um rótulo de seção; não há `<input>` nenhum embaixo dele. Como o UPDATE altera `title` (e mudar o título é o passo 5 do roteiro da apresentação), precisa existir um `<input type="text" name="title">`.

**P4 — Não existe campo de descrição.** Mesma coisa: o `read.php` exibe `description` no bloco `.rdesc`, o `create.php` coleta, mas o editor não deixa mudar. Precisa de um `<textarea name="description">` na barra.

**P5 — Botão "Salvar" do mobile é um link.** [edit.php:101](../frontend/edit.php:101) é `<a href="DPS vc muda">Salvar</a>`. Link não envia formulário. Vira `<button type="submit">`.

**P6 — Não existe botão de excluir.** Precisa ser criado (é metade do trabalho deste documento).

**P7 — Não existe `<input type="hidden" name="id">`.** Sem ele o `update.php` não sabe qual texto gravar.

### 2.2 De nomenclatura (quebram o `$_POST` silenciosamente)

**P8 — `name="langugage"`.** Typo em [edit.php:52](../frontend/edit.php:52) (o `id` está certo, o `name` não). `$_POST['language']` chegaria vazio e o idioma seria apagado a cada save.

**P9 — Radios de visibilidade sem `value`.** [edit.php:65](../frontend/edit.php:65) tem `<input type="radio" name="visibility" id="public">` sem `value`. Radio sem `value` envia a string `"on"` — que não existe no ENUM `('public','private')`. Com `ERRMODE_EXCEPTION` ligado, isso é `PDOException` na cara. O `create.php` já tem os `value` certos; copie de lá.

**P10 — `<textarea name="content">`.** [edit.php:110](../frontend/edit.php:110). A coluna do banco é `body`. Renomear para `name="body"`.

**P11 — Falta `es` no select de idioma.** O ENUM aceita `('enus','ptbr','es')` e o `create.php` oferece as três; o editor só oferece duas. Quem criar um texto em espanhol perde o idioma ao editar.

### 2.3 Menores

**P12 — `id="fontsize"` duplicado.** Aparece em [edit.php:77](../frontend/edit.php:77) (barra web) e [edit.php:125](../frontend/edit.php:125) (barra mobile). HTML inválido.

> **Correção do plano original:** a tabela de riscos (seção 7) diz que o id duplicado é dos *dois `<textarea>`*. Não é — existe **um** `<textarea>` só no arquivo. O duplicado é o `fontsize`. E `fontsize` **não é coluna do banco**: é preferência visual, não deve entrar no UPDATE. A correção é tirar o `name` dos dois (deixando só como controle de JS) e trocar um dos `id` por `fontsize-mobile`, ou simplesmente mirar por classe.

**P13 — A `.bar` no desktop fica escondida.** O CSS ([edit.css](../frontend/css/edit.css)) posiciona a barra em `left: -232px` e só traz ela pra tela no `:hover`. Isso significa que **o botão Excluir fica invisível até passar o mouse na borda esquerda**. Não é bug, é o design do João — mas é coisa pra ensaiar, senão na hora da apresentação o botão "some". Ver seção 6.

---

## 3. Implementação

### 3.1 `backend/edit.php` — NOVO

A guarda de dono mora aqui. É o item de segurança inegociável do plano original (seção 3): sem o `AND author_id`, qualquer usuário logado abre o editor do texto alheio trocando o `?id=` na URL.

```php
<?php
require_once __DIR__ . '/config/database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['user_id'])) {
    header('Location: ../frontend/login.php');
    exit;
}

$id = (int) ($_GET['id'] ?? 0);

// a trava de dono está no próprio SQL: ou o texto é seu, ou não volta nada
$stmt = $pdo->prepare(
    'SELECT * FROM texts WHERE id = :id AND author_id = :author_id'
);
$stmt->execute([
    ':id'        => $id,
    ':author_id' => $_SESSION['user_id'],
]);
$text = $stmt->fetch(PDO::FETCH_ASSOC);

// não voltou nada = o texto não existe OU não é seu. Os dois casos dão na mesma resposta,
// de propósito: não confirmamos pra ninguém que o texto de id N existe.
if (!$text) {
    header('Location: ../frontend/home.php?erro=sem_permissao');
    exit;
}
```

Três coisas a comentar na apresentação, porque batem com o material do professor:

- `prepare()` + `execute([':id' => ...])` — nunca concatenação (o motivo declarado do PDO existir).
- `fetch(PDO::FETCH_ASSOC)` para registro único (`fetchAll` é pra lista).
- O `(int)` no `$_GET['id']` — id que não é número vira `0`, e `0` não existe.

> **Não faça `http_response_code(403)` junto com `header('Location:')`.** O `Location` força um 302 e o 403 é descartado. Ou redireciona (que é o padrão do `read.php` e é o que estamos fazendo), ou responde 403 e imprime uma página de erro. Status code de verdade é assunto da API, amanhã.

### 3.2 `frontend/edit.php` — REESCREVER o markup

Primeira linha do arquivo, antes de qualquer HTML:

```php
<?php require_once __DIR__ . '/../backend/edit.php'; ?>
```

Depois, a estrutura. O ponto é: **um form só, envolvendo tudo**.

```php
<body>
<form id="edit-form" action="../backend/update.php" method="POST" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?= (int) $text['id'] ?>">

<!-- ... a .bar inteira e a área de escrita entram aqui dentro ... -->

</form>
<script> /* ... */ </script>
</body>
```

Campo a campo, dentro da `.bar`:

```php
<a href="read.php?id=<?= (int) $text['id'] ?>">&lt;</a>
<button type="button" class="fecha" id="fecharBar">X</button>

<h2>Título</h2>
<input type="text" id="title" name="title" value="<?= htmlspecialchars($text['title']) ?>">

<div class="img">
    <?php if ($text['cover_image']): ?>
        <img src="img/uploads/<?= htmlspecialchars($text['cover_image']) ?>" alt="Capa atual">
    <?php endif; ?>
</div>

<input type="file" id="image-picker" name="cover_image"
       accept="image/png, image/jpeg, image/webp">

<h2>Descrição</h2>
<textarea id="description" name="description"><?= htmlspecialchars($text['description']) ?></textarea>

<h2>Categoria</h2>
<select id="category" name="category">
    <option value="book"   <?= $text['category'] === 'book'   ? 'selected' : '' ?>>Livro</option>
    <option value="poetry" <?= $text['category'] === 'poetry' ? 'selected' : '' ?>>Poesia</option>
    <option value="story"  <?= $text['category'] === 'story'  ? 'selected' : '' ?>>Conto</option>
</select>

<h2>Idioma</h2>
<select id="language" name="language">
    <option value="">Idioma</option>
    <option value="enus" <?= $text['language'] === 'enus' ? 'selected' : '' ?>>English</option>
    <option value="ptbr" <?= $text['language'] === 'ptbr' ? 'selected' : '' ?>>Português</option>
    <option value="es"   <?= $text['language'] === 'es'   ? 'selected' : '' ?>>Español</option>
</select>

<h2>Visibilidade</h2>
<div class="visibt">
    <input type="radio" name="visibility" id="public" value="public"
           <?= $text['visibility'] === 'public' ? 'checked' : '' ?>>
    <label for="public">Público</label>

    <input type="radio" name="visibility" id="private" value="private"
           <?= $text['visibility'] === 'private' ? 'checked' : '' ?>>
    <label for="private">Privado</label>
</div>
```

Isso resolve o comentário que o João deixou no arquivo (*"faça a categoria original vir marcada padrão"*) — é o `selected`/`checked` condicional. **A opção vazia `<option value="">Categoria</option>` sai do select de categoria:** categoria é `NOT NULL`, o texto já tem uma, e deixar a opção vazia só permite o usuário zerar um campo obrigatório. Já em idioma a coluna aceita `NULL`, então a opção vazia fica.

Área de escrita e botões:

```php
<div class="mbbt1">
    <a href="read.php?id=<?= (int) $text['id'] ?>" style="margin:0;">&lt;</a>
    <button type="submit" class="salvar">Salvar</button>
    <button type="button" id="abrirBar" style="margin-left:auto;">⋮</button>
</div>

<label style="display:none;" for="body">Escrever</label>
<textarea id="body" name="body"><?= htmlspecialchars($text['body']) ?></textarea>
```

E o botão de salvar da barra web:

```html
<button type="submit" class="svv">Salvar</button>
```

> **`htmlspecialchars()` em tudo, inclusive dentro do `<textarea>`.** É conteúdo escrito por usuário; sem escapar, um texto contendo `</textarea><script>` fecha a caixa e executa script. Aqui é `htmlspecialchars()` puro — **sem `nl2br()`**, que é só pra exibição em HTML; dentro de um `<textarea>` a quebra de linha já é literal, e o `<br>` apareceria escrito na tela do editor.

### 3.3 O botão Excluir

Vai no fim da `.bar`, embaixo do Salvar, com a confirmação que o exemplo do professor usa (a única linha de JS do projeto inteiro dele — ou seja, ele considera confirmação obrigatória):

```php
<a class="excluir"
   href="../backend/delete.php?id=<?= (int) $text['id'] ?>"
   onclick="return confirm('Apagar este texto? Esta ação não pode ser desfeita.');">Excluir</a>
```

Um `<a>` dentro do form não causa problema — é navegação, não submit.

> **Por que link e não formulário.** Um DELETE por GET é tecnicamente questionável (um crawler ou um prefetch do navegador pode disparar). O jeito correto seria um `<form method="POST">` — mas **form dentro de form é HTML inválido**, e o nosso form agora envolve a página inteira. A saída correta existe (`<button type="submit" form="delete-form">` com o `<form id="delete-form">` fora do form principal, usando o atributo `form` do HTML5), mas é sofisticação demais pra véspera de apresentação, e o link com `confirm()` é literalmente o padrão do material do professor. **Fica o link.** Se ele perguntar, a resposta honesta é essa: sabemos que o certo é POST, seguimos o exemplo da aula pelo prazo.

**CSS necessário** em [frontend/css/edit.css](../frontend/css/edit.css) — a regra `.bar .fecha, .bar a` hoje pinta *todo* `<a>` da barra como um quadradinho azul de 30×30 (é o botão de voltar). O link de excluir precisa escapar disso:

```css
.bar a.excluir {
    display: block;
    width: auto;
    height: auto;
    margin: 0 2px;
    padding: 4px 50px;
    background-color: rgb(155, 30, 40);
    color: aliceblue;
    font-size: 18px;
    border-radius: 10px;
    border: none;
}
```

E o Salvar do mobile, que deixou de ser `<a>` (P5), precisa herdar o estilo que era do `<a>`:

```css
.mbbt1 .salvar {
    margin-left: auto;
    padding: 2px 10px;
    border: 3px solid rgb(7, 12, 36);
    border-radius: 10px;
    background-color: rgb(49, 47, 63, 10%);
    font-size: 20px;
    color: aliceblue;
}
```

### 3.4 `backend/update.php` — NOVO

```php
<?php
require_once __DIR__ . '/config/database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['user_id'])) {
    header('Location: ../frontend/login.php');
    exit;
}

$author_id   = $_SESSION['user_id'];
$id          = (int) ($_POST['id'] ?? 0);
$title       = $_POST['title'] ?? '';
$body        = $_POST['body'] ?? '';
$description = $_POST['description'] ?? '';
$category    = $_POST['category'] ?? '';
$visibility  = $_POST['visibility'] ?? '';

$language = $_POST['language'] ?? '';
if ($language === '') {
    $language = null;
}

if (empty($title) || empty($description) || empty($category) || empty($visibility)) {
    header('Location: ../frontend/edit.php?id=' . $id . '&erro=campo_vazio');
    exit;
}

// busca a capa atual: serve pra checar que o texto é seu ANTES de mexer em arquivo,
// e pra manter a capa quando o usuário salva sem enviar imagem nova
$stmt = $pdo->prepare('SELECT cover_image FROM texts WHERE id = :id AND author_id = :author_id');
$stmt->execute([':id' => $id, ':author_id' => $author_id]);
$atual = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$atual) {
    header('Location: ../frontend/home.php?erro=sem_permissao');
    exit;
}

$cover_image = $atual['cover_image'];

// bloco de upload idêntico ao do create.php — só roda se veio arquivo novo
if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] !== UPLOAD_ERR_NO_FILE) {

    if ($_FILES['cover_image']['error'] !== UPLOAD_ERR_OK) {
        header('Location: ../frontend/edit.php?id=' . $id . '&erro=upload_falhou');
        exit;
    }

    $tiposPermitidos = ['image/png' => 'png', 'image/jpeg' => 'jpg', 'image/webp' => 'webp'];
    $tipoReal = mime_content_type($_FILES['cover_image']['tmp_name']);

    if (!isset($tiposPermitidos[$tipoReal])) {
        header('Location: ../frontend/edit.php?id=' . $id . '&erro=formato_invalido');
        exit;
    }

    $nomeArquivo = bin2hex(random_bytes(8)) . '.' . $tiposPermitidos[$tipoReal];
    $destino = __DIR__ . '/../frontend/img/uploads/' . $nomeArquivo;

    if (!move_uploaded_file($_FILES['cover_image']['tmp_name'], $destino)) {
        header('Location: ../frontend/edit.php?id=' . $id . '&erro=upload_falhou');
        exit;
    }

    $cover_image = $nomeArquivo;
}

try {
    $sql = 'UPDATE texts
            SET title = :title, body = :body, description = :description,
                category = :category, language = :language,
                visibility = :visibility, cover_image = :cover_image
            WHERE id = :id AND author_id = :author_id';

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':title'       => $title,
        ':body'        => $body,
        ':description' => $description,
        ':category'    => $category,
        ':language'    => $language,
        ':visibility'  => $visibility,
        ':cover_image' => $cover_image,
        ':id'          => $id,
        ':author_id'   => $author_id,
    ]);
} catch (PDOException $e) {
    error_log($e->getMessage());
    header('Location: ../frontend/edit.php?id=' . $id . '&erro=erro_interno');
    exit;
}

header('Location: ../frontend/read.php?id=' . $id);
exit;
```

Pontos de fala, todos vindos do material do professor:

- **O `AND author_id = :author_id` no `WHERE` é a trava de dono feita no próprio SQL.** Mesmo se alguém forjar o `id` no campo escondido, o UPDATE não acha linha nenhuma.
- **`$body` pode ser string vazia, e tudo bem** — a validação de campo vazio de propósito não inclui `body`. O usuário salva metadados antes de escrever. Note que isso é o inverso do bug 1 do `create.php`, onde `$body` sequer existia como variável.
- **`rowCount()`:** o material manda usar pra dar feedback. Aqui a interpretação exige cuidado — `rowCount() === 0` no MySQL significa **"nenhuma linha mudou"**, e isso acontece tanto quando o texto não é seu quanto quando você salvou sem alterar nada. Como o dono já foi verificado no SELECT acima, os zeros que sobram são todos do tipo "salvou igual". Por isso o redirect final é o mesmo nos dois casos: **sucesso silencioso, não erro**. Se quiser exibir feedback, passe `?salvo=1` e imprima uma mensagem — mas não trate zero como falha.

**Por que redirecionar para `read.php` e não voltar pro editor:** é o passo 5 do roteiro ("mudar o título, salvar, ver a mudança na leitura"). Salvar e cair direto na tela de leitura mostra o efeito do UPDATE sem clique nenhum a mais. Alternativa, se atrapalhar a escrita: `edit.php?id=N&salvo=1`.

### 3.5 `backend/delete.php` — NOVO

```php
<?php
require_once __DIR__ . '/config/database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['user_id'])) {
    header('Location: ../frontend/login.php');
    exit;
}

$id = (int) ($_GET['id'] ?? 0);

try {
    // NUNCA sem WHERE. E o author_id garante que só o dono apaga.
    $stmt = $pdo->prepare('DELETE FROM texts WHERE id = :id AND author_id = :author_id');
    $stmt->execute([
        ':id'        => $id,
        ':author_id' => $_SESSION['user_id'],
    ]);
} catch (PDOException $e) {
    error_log($e->getMessage());
    header('Location: ../frontend/edit.php?id=' . $id . '&erro=erro_interno');
    exit;
}

// aqui rowCount() === 0 é erro de verdade: ou o texto não existe, ou não é seu
if ($stmt->rowCount() === 0) {
    header('Location: ../frontend/home.php?erro=sem_permissao');
    exit;
}

header('Location: ../frontend/catalog.php?msg=texto_apagado');
exit;
```

Três coisas que valem apontar na apresentação:

1. **"Nunca esqueça o WHERE no DELETE"** — está em maiúsculas no material dele. Aqui o WHERE tem duas condições, e a segunda é de segurança, não de filtro.
2. **`rowCount()` aqui tem significado oposto ao do UPDATE.** No UPDATE, zero é ambíguo; no DELETE, zero é inequívoco: a linha não foi apagada porque não existia ou não era sua. Mesma função, leitura diferente conforme a operação — bom detalhe pra mostrar que a gente entendeu, e não só copiou.
3. **`ON DELETE CASCADE` faz o resto.** O `db/schema.sql` declara cascade em `embeddings`, `reading_logs` e `text_genres`. Apagar o texto limpa os registros dependentes sozinho — não precisa de três DELETEs. É a integridade referencial trabalhando.

> **Ponta solta conhecida:** o arquivo de capa continua em `frontend/img/uploads/` depois do DELETE (e a capa antiga também fica, quando o UPDATE troca a imagem). São arquivos órfãos ocupando disco. Fora do escopo de hoje; anotar como issue.

---

## 4. Arquivos tocados

| Arquivo | Ação | Tamanho |
|---|---|---|
| `backend/edit.php` | criar | ~30 linhas |
| `backend/update.php` | criar | ~95 linhas (metade é o bloco de upload, copiado do `create.php`) |
| `backend/delete.php` | criar | ~35 linhas |
| `frontend/edit.php` | reescrever o markup | mexe no arquivo quase todo |
| `frontend/css/edit.css` | acrescentar 2 regras | ~20 linhas |

Sugestão de commits, no padrão do [CONTRIBUTING.md](../CONTRIBUTING.md):

```
backend: add UPDATE logic - closes #N
backend: add DELETE logic - closes #N
frontend: wire edit screen to update and delete
```

---

## 5. Testes antes de fechar

### 5.1 O ciclo feliz (navegador, logado)

1. `create.php` → criar texto → cai em `edit.php?id=N` com os campos **já preenchidos** com o que foi cadastrado.
2. Escrever o corpo → Salvar → cai em `read.php?id=N` mostrando o texto escrito.
3. Voltar em `edit.php?id=N` → mudar o título → Salvar → o título novo aparece na leitura.
4. Salvar **sem mudar nada** → não pode dar erro (é o caso `rowCount() === 0` do UPDATE).
5. Trocar a capa → a capa nova aparece; salvar de novo sem enviar arquivo → **a capa não some**.
6. Excluir → o `confirm()` aparece → cancelar não apaga nada → confirmar apaga e redireciona.

### 5.2 As guardas (é o que o professor pode testar na frente de todos)

| Teste | Resultado esperado |
|---|---|
| Abrir `edit.php?id=1` **deslogado** | vai pro `login.php` |
| Logado como A, abrir `edit.php?id=<texto do B>` | vai pro `home.php?erro=sem_permissao`, **não abre o editor** |
| Logado como A, chamar `delete.php?id=<texto do B>` direto na URL | redireciona, e o texto do B **continua no banco** — confira no phpMyAdmin |
| `edit.php?id=abc` e `edit.php?id=99999` | mesma resposta de "sem permissão" |

O terceiro é o teste que mais vale mostrar: prova que a trava está no SQL, não escondida no JavaScript.

### 5.3 Pelo terminal

```bash
curl -i "http://localhost/stanza/backend/delete.php?id=1"
```

Sem sessão isso tem que responder `Location: ../frontend/login.php` — o `-i` é o que mostra o header do redirect, que é onde a resposta mora nesse padrão.

---

## 6. Riscos e decisões pendentes

| Risco | Impacto | O que fazer |
|---|---|---|
| **`catalog.php` ainda é estático** | O roteiro item 6 promete "o card some do catálogo" e isso não vai acontecer | **Decisão necessária.** Ou faz o catálogo dinâmico agora (seção 5.7 do plano original, ~15 linhas), ou muda o redirect do DELETE pra `profile.php`. Recomendação: fazer o catálogo — ele também é pré-requisito do `fetch` da API de hoje à tarde. |
| **A `.bar` do desktop só aparece no `:hover`** | O botão Excluir "some" na apresentação | Ensaiar o movimento (encostar o mouse na borda esquerda), **ou** demonstrar o DELETE na largura de celular pelo DevTools — o que ainda rende o ponto de Mobile First |
| Botão sem `type` enviando o form (P2) | Barrinha mobile salva sozinha ao abrir | Já coberto: `type="button"` nos dois. **Testar clicando no ⋮ e no X depois de pronto** |
| `read.php` não filtra `visibility` | Marcar um texto como privado no editor não esconde ele de fato | Fora do escopo de hoje. **Não demonstre a visibilidade privada** — o campo salva, mas a leitura ainda não respeita |
| Upload de capa falhar no dia | — | A coluna é `DEFAULT NULL`; siga sem capa, como o plano original já prevê |

---

## 7. Checklist

**`backend/edit.php`**
- [ ] Guarda de sessão redirecionando pro login
- [ ] `SELECT ... WHERE id = :id AND author_id = :author_id`
- [ ] `$text` vazio → redirect com `?erro=sem_permissao`

**`frontend/edit.php`**
- [ ] `require_once` do `backend/edit.php` na primeira linha
- [ ] Form único envolvendo a página, com `method="POST"` e `enctype="multipart/form-data"`
- [ ] `<input type="hidden" name="id">`
- [ ] `type="button"` no `#fecharBar` e no `#abrirBar` (P2)
- [ ] Campo de título criado (P3) e de descrição (P4)
- [ ] `name="language"` corrigido (P8), `value` nos radios (P9), `name="body"` no textarea (P10), `es` no idioma (P11)
- [ ] `selected` / `checked` refletindo os dados atuais
- [ ] `htmlspecialchars()` em todo valor vindo do banco
- [ ] Salvar do mobile virou `<button type="submit">` (P5)
- [ ] Botão Excluir com `confirm()` (P6)
- [ ] `id="fontsize"` desduplicado e sem `name` (P12)

**`backend/update.php`**
- [ ] `WHERE id = :id AND author_id = :author_id`
- [ ] Capa preservada quando não vem arquivo novo
- [ ] `try/catch (PDOException)` com `error_log`, sem vazar `getMessage()` na tela
- [ ] `rowCount() === 0` tratado como sucesso silencioso

**`backend/delete.php`**
- [ ] `DELETE` **com** `WHERE`, com as duas condições
- [ ] `rowCount() === 0` tratado como erro
- [ ] Redirect pós-exclusão apontando pra uma tela onde dá pra ver que sumiu

**Fechamento**
- [ ] Ciclo completo rodado uma vez: criar → escrever → ler → editar → apagar
- [ ] Os 4 testes de guarda da seção 5.2 passando
- [ ] Commitado no padrão do CONTRIBUTING
