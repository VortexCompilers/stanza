# Presentation Plan — 2026-09-04

> Active plan. Supersedes `plano-apresentacao-28-08.md` and `plano-edit-delete.md`, which are kept
> only as history and are not to be followed where they disagree with this document.
>
> The 2026-08-28 presentation did not happen — the team ran out of time. It was rescheduled to
> **Friday, 2026-09-04**, keeping the same four requirements and adding two:
>
> 1. Working CRUD · 2. Authentication · 3. Landing page · 4. Something API-related
> **5. Compliance with the instructor's AI usage policy** · **6. Full English unification**
>
> Architecture decisions from the previous plans still stand: procedural PHP, PDO with prepared
> statements, native sessions, traditional POST + `header('Location: ...')`, no framework, no
> Composer. Reference level is `exemplo-professor/` (local, gitignored).

---

## 0. Real deadline

Today is **Monday, 2026-08-31**. The presentation is **Friday, 2026-09-04**.

| Day | Date | Focus |
|---|---|---|
| Mon (evening) | 31/08 | Seed + dynamic catalog — unblocks the DELETE demo |
| Tue | 01/09 | Dynamic home, session-aware header, root entry point |
| Wed | 02/09 | The API + catalog consuming it |
| Thu | 03/09 | English sweep, AI declaration, cleanup |
| Fri | 04/09 | Load seed, full run-through, rehearsal |

**Four working days.** That is one more day than the previous attempt had, but the scope grew by
two requirements. The two new ones are cheap in code and expensive in attention — do not leave them
for Friday.

### 0.1 Progress log

Running notes on decisions and state as the week moves — newest first. Keep this updated instead of
rewriting the day-by-day sections every time something changes.

- **31/08, evening — seed loaded; catalog work started; home confirmed next.**
  `db/seed.sql` is committed (`5551cd2`) and has been loaded into the real database. Catalog
  dynamic work is underway, and it took the `backend/<page>.php` + `frontend/<page>.php` split
  already used by `read.php`/`edit.php` rather than the inline query §4.2 originally sketched —
  `backend/catalog.php` now exists. Two things to know before finishing it:
  - **The catalog's frontend markup is confirmed unfinished** — a separate problem from "not wired
    to the database" in §1.2. The dynamic query has nowhere correct to render into yet. Finish the
    markup before wiring the `foreach` to it.
  - `backend/catalog.php` as it stands has two bugs worth catching now rather than at demo time:
    `SELECT * FROM texts TOP 5` uses SQL Server syntax — MySQL has no `TOP`, this needs `LIMIT 5`
    (and check whether 5 is even the right cap for a full catalog listing, vs. `home.php`'s
    top-N). It also calls `->fetch()` instead of `->fetchAll()`, which returns one row where a
    catalog needs the whole list — see §4.2 for the corrected shape.
  - **Decision confirmed: `home.php` will also be fed with real data**, right after the catalog,
    following the same split pattern.

---

## 1. Honest audit — what actually exists

Nothing was committed on 28/08. The last commit is `8b2f3c1` (27/08). So the whole final day of the
old plan is still open.

### 1.1 Done and working

| Item | Files | Notes |
|---|---|---|
| PDO connection | `backend/config/database.php` | `try/catch`, `ERRMODE_EXCEPTION` |
| Register / login / logout | `backend/register.php`, `login.php`, `logout.php` | `password_hash` / `password_verify`, session written |
| CREATE | `backend/create.php` + `frontend/create.php` | INSERT + cover upload with real MIME validation and random filename |
| READ | `backend/read.php` + `frontend/read.php` | JOIN on author, `read_count` increment, `htmlspecialchars` |
| UPDATE | `backend/update.php` + `frontend/edit.php` | Owner lock in SQL, cover preserved when no new file |
| DELETE | `backend/delete.php` | `WHERE id AND author_id`, `rowCount()` treated as error, `confirm()` in the UI |
| Landing page | `frontend/landing.php` | Hero + login/register modals |
| Schema | `db/schema.sql` | 6 tables, FKs with `ON DELETE CASCADE`, category ENUM already `book/poetry/story` |

**Requirements 1, 2 and 3 are essentially built.** What is missing is making them *visible*.

### 1.2 Missing

| Missing | Impact |
|---|---|
| `backend/api/` | **Requirement 4 has zero lines written.** |
| Dynamic `catalog.php` | **In progress** as of 31/08 evening — see §0.1. The 273 lines of static HTML with fake cards are still there; `backend/catalog.php` exists but the query has bugs, and **the frontend markup itself is unfinished**, not just undynamic. `delete.php` redirects here with `?msg=texto_apagado` and **the card never disappears** until this is done. Breaks step 6 of the script until it lands. |
| Dynamic `home.php` | 421 lines, ~15 fake cards, all linking to `href="LINNNNK"`. **Confirmed decided** (§0.1) to follow right after the catalog. |
| Session-aware `header.php` | 4 lines — just the logo. Nothing on screen ever proves a session persists across pages. |
| `db/seed.sql` | No data. The catalog looks like a dead site. |
| Root `index.php` | The demo has to start at a URL with `/frontend/landing.php` in it. |
| AI declaration | `README.md` is one line: `# stanza`. |
| English interface | ~276 Portuguese label sites across 12 files. |
| `backend/admin/index.php` | Two `require` lines that print nothing. Out of scope — see §8. |

### 1.3 Known loose ends

- `frontend/auth.php` — dead mockup (`<form action=" ddd ">`). Delete it.
- `frontend/edit.php:126` — the mobile Save is still `<a href="DPS vc muda">`. A link does not
  submit a form. P5 of the edit/delete plan was only fixed in one of the two bars.
- Placeholder hrefs still in the tree: `LINNNNK` (home), `searchh` (home), `forgottt`
  (modal-login), `ALGUMA ACAO` (read.php:92), `action="/search"` (catalog).
- `read.php` does not filter `visibility` — marking a text private does not actually hide it.
  **Do not demonstrate private visibility.**
- `users.name` is not `UNIQUE`, but `login.php` queries `WHERE name = ?`. Two users with the same
  name break login-by-name.
- Cover files are orphaned in `frontend/img/uploads/` after DELETE and after a cover swap.
- Portuguese identifiers inside `backend/` (`$tiposPermitidos`, `$tipoReal`, `$nomeArquivo`,
  `$destino`) violate the English rule that already existed before this week.

---

## 2. Requirement 5 — the AI usage policy

Source: `exemplo-professor/politica-de-uso-de-ia.md` (Ronildo A. Ferreira, CC BY-NC-SA 4.0).

### 2.1 What it obliges

- A section titled **`DECLARAÇÃO DE USO DE INTELIGÊNCIA ARTIFICIAL`**. The policy states in bold
  that **the title must not be altered** — so it stays in Portuguese even under the English
  unification. It is required **even if no AI was used**.
- **Location.** The policy's own table maps activity type to location: for a project documented on
  GitHub → `README.md`; for source code → a comment header in the main file; for a web application
  → an "About" page. We will do the first two. (An About page is optional — see §8.)
- **Four columns:** `Ferramenta | Etapa | Finalidade | Validação`.
- **Specific, not generic.** The policy explicitly rejects "AI was used during development" and
  asks for the actual tool, stage, purpose, and how the result was validated.
- **Only what really happened.** Fabricating evidence is called "especially serious". Do not copy
  the policy's example table.

### 2.2 What to write in `README.md`

The README is currently one line. Give it a real project header, then the declaration at the end.

> **The table below is a skeleton. Every row must be replaced with what each team member actually
> did.** Sit down together and fill it in honestly — which tool, at which stage, for what, and how
> you checked the output. If someone used no AI at all, that is a fine answer and worth saying.

```markdown
## DECLARAÇÃO DE USO DE INTELIGÊNCIA ARTIFICIAL

| Ferramenta | Etapa | Finalidade | Validação |
|---|---|---|---|
| <tool> | Planejamento | <what it helped plan> | <who reviewed it and how> |
| <tool> | Desenvolvimento | <which code, which problem> | <how it was read, changed and tested> |
| <tool> | Revisão | <what was reviewed> | <who accepted or rejected the suggestions> |
```

### 2.3 Code header

The policy shows a PHP comment block. Put one at the top of the files the panel is most likely to
open — `backend/api/texts.php`, `backend/create.php`, `backend/update.php`, `backend/delete.php` —
describing what was actually used on *that* file. Keep it short and true; a copy-pasted identical
block in every file is the generic declaration the policy rejects.

```php
/*
DECLARAÇÃO DE USO DE INTELIGÊNCIA ARTIFICIAL

Ferramenta: <tool>
Etapa: Desenvolvimento
Finalidade: <what it was actually asked for in this file>
Validação: <how the team read, changed and tested the result>
*/
```

### 2.4 The part that is not a document

The policy says the panel **may pick any excerpt of code and ask about it** — what it does, what it
receives, what it returns, how it was integrated, how it was tested, and what the team changed. It
also says commit history is evidence of the development process.

Practical consequence: **before Friday, each member should be able to walk through the files they
own.** The highest-risk excerpts, because they are the ones a panel naturally reaches for:

| Excerpt | Be ready to explain |
|---|---|
| `WHERE id = :id AND author_id = :author_id` | Why the ownership check is in SQL and not in an `if` |
| `prepare()` + `execute([...])` | What SQL injection is and why concatenation is the alternative |
| `mime_content_type()` in the upload block | Why the file extension is not trusted |
| `rowCount()` in `update.php` vs `delete.php` | Why zero means "saved unchanged" in one and "not yours" in the other |
| `htmlspecialchars()` in `read.php` | What happens without it, given users write the content |
| `password_hash` / `password_verify` | Why the password is never stored or compared as text |
| `http_response_code()` in the API | Why 404, 401 and 405 are different answers |

Rehearse these as questions, not as a speech. Section 10 of the policy lists the exact question
forms the panel uses.

---

## 3. Requirement 6 — English unification

**Decision: everything goes to English, including the site's visible interface.** Carve-outs: the
`DECLARAÇÃO DE USO DE INTELIGÊNCIA ARTIFICIAL` title (the policy forbids changing it) and the TCC
monograph (ABNT).

### 3.1 The rule that saves the most time

**Translate as you rewrite.** `catalog.php` and `home.php` are being rebuilt from scratch this week
anyway — write their markup in English the first time. That is 117 of the ~276 label sites handled
at zero extra cost.

### 3.2 Inventory

| File | Label sites | When |
|---|---|---|
| `home.php` | 78 | Tue — free, file is being rewritten |
| `catalog.php` | 39 | Mon — free, file is being rewritten |
| `profile.php` | 33 | Thu |
| `edit.php` | 25 | Thu |
| `create.php` | 22 | Thu |
| `settings.php` | 20 | Thu |
| `landing.php` | 17 | Thu |
| `modal-register.php` | 16 | Thu |
| `modal-login.php` | 8 | Thu |
| `nav.php` | 5 | Thu |
| `read.php` | 5 | Thu |
| `auth.php` | 6 | Thu — **deleted, not translated** |

### 3.3 Error parameters — a coordinated rename

`backend/` writes these into the query string and **`frontend/login.php` and
`frontend/register.php` read them back through a `$mensagensDeErro` map**. Rename both sides in the
same commit or login stops showing errors.

| Current | New |
|---|---|
| `?erro=` | `?error=` |
| `campo_vazio` | `empty_field` |
| `credenciais_invalidas` | `invalid_credentials` |
| `email_duplicado` | `duplicate_email` |
| `upload_falhou` | `upload_failed` |
| `formato_invalido` | `invalid_format` |
| `erro_interno` | `internal_error` |
| `sem_permissao` | `forbidden` |
| `texto_nao_encontrado` | `text_not_found` |
| `?msg=texto_apagado` | `?msg=text_deleted` |

Variables to rename alongside: `$mensagensDeErro` → `$errorMessages`, `$erroLogin` → `$loginError`,
`$erroRegister` → `$registerError`, `$loginAberto` → `$loginOpen`, `$registerAberto` →
`$registerOpen`, and in `backend/`: `$tiposPermitidos` → `$allowedTypes`, `$tipoReal` →
`$actualType`, `$nomeArquivo` → `$fileName`, `$destino` → `$destination`.

The *displayed* messages become English too: "Fill in all fields.", "Incorrect e-mail/name or
password.", "This e-mail is already registered."

### 3.4 What does not change

The `texts.category` ENUM is already `('book','poetry','story')` — **no database work**. The
`<option>` values were already English; only the labels between the tags change (`Livro` → `Book`).

---

## 4. Day by day

### Monday 31/08 (evening) — seed + dynamic catalog

The catalog is first because DELETE is not demonstrable without it, and because the `fetch` version
on Wednesday needs a working card layout to replace.

**4.1 — `db/seed.sql`.** One demo user and ~10 texts across categories and authors, some with high
`read_count`. Generate the password hash first:

```bash
php -r "echo password_hash('123456', PASSWORD_DEFAULT), PHP_EOL;"
```

Paste the result into the seed. Writing this now is much faster than typing ten texts into the form
on Friday, and the catalog needs to look like a live site.

**4.2 — Finish `backend/catalog.php`, then wire `frontend/catalog.php` to it, markup in English.**
As of §0.1, this is already split the way `read.php`/`edit.php` are — a `backend/catalog.php` doing
the query, `require_once`'d from the top of `frontend/catalog.php` before any HTML. The existing
`backend/catalog.php` needs two fixes: `TOP 5` is not MySQL syntax, and `->fetch()` returns one row
where the catalog needs all of them.

```php
<?php
require_once __DIR__ . '/config/database.php';

$stmt = $pdo->prepare(
    "SELECT id, title, category, cover_image, read_count
     FROM texts
     WHERE visibility = 'public'
     ORDER BY created_at DESC"
);
$stmt->execute();
$texts = $stmt->fetchAll(PDO::FETCH_ASSOC);
```

**Then, separately, finish the frontend markup itself** — this is the part §0.1 flags as
unfinished, and it is not the same task as adding the `foreach`. The ~15 repeated `.post` blocks in
`frontend/catalog.php` need to become one real card template before a loop can render into it. Only
once that template exists does the `foreach` over `$texts` make sense:

Each card becomes `<a href="read.php?id=<?= (int) $text['id'] ?>">`, the cover comes from
`img/uploads/<?= htmlspecialchars($text['cover_image']) ?>` with a placeholder in the `else` branch
when it is `NULL` — the instructor's own `admin/products/index.php` does exactly that `if/else`.

**Keep this server-side version.** Wednesday it gets replaced by `fetch`; if the API misbehaves on
Friday, reverting this one file restores a working "R" in 30 seconds. Commit it separately.

**4.3 — Start XAMPP and load the seed.** MySQL is not running by default:

```bash
sudo /opt/lampp/lampp start
```

```bash
/opt/lampp/bin/mysql -u root stanza < db/seed.sql
```

**4.4 — Verify DELETE end to end.** Create a text, delete it, watch the card disappear from the
catalog. This is the loop the old plan promised and never got to prove.

---

### Tuesday 01/09 — make the rest visible

**4.5 — `backend/home.php` + `frontend/home.php` dynamic, markup in English.** Confirmed in §0.1:
this follows right after the catalog and uses the same split. Same query shape as
`backend/catalog.php`, with `ORDER BY read_count DESC LIMIT 8` instead of the full public list.
This is the 421-line file with 78 Portuguese labels and 15 `href="LINNNNK"` cards — rewriting it
settles both problems at once, the same way the catalog's rewrite is settling its own.

**4.6 — `frontend/header.php` with session.** Four lines today. This is the single change that makes
**Requirement 2 visible**: without it, nothing on screen proves the session persists across pages.

```php
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <a href="home.php"><img src="img/logo.png" alt="StanzAI"></a>

    <?php if (!empty($_SESSION['user_id'])): ?>
        <span>Hi, <?= htmlspecialchars($_SESSION['user_name'] ?? '') ?></span>
        <a href="../backend/logout.php">Log out</a>
    <?php else: ?>
        <a href="login.php">Sign in</a>
    <?php endif; ?>
</header>
```

> **Prerequisite — verified, and it is missing.** `backend/login.php:31` and
> `backend/register.php:43` write only `user_id` and `role`. `$_SESSION['user_name']` is **never
> set anywhere**, so the header above would greet an empty string. Add it in both files before
> touching the header:
>
> ```php
> $_SESSION['user_name'] = $user['name'];   // backend/login.php, next to user_id and role
> ```
>
> ```php
> $_SESSION['user_name'] = $name;           // backend/register.php, next to user_id and role
> ```
>
> In `register.php`, use whatever variable already holds the submitted name. Log out and back in
> after the change — an existing session predates the new key and will still render empty.

**4.7 — Root `index.php`,** so the demo starts at `http://localhost/stanza/`:

```php
<?php
header('Location: frontend/landing.php');
exit;
```

**4.8 — If time remains,** start the Thursday English sweep early. Thursday is the fullest day.

---

### Wednesday 02/09 — the API

**4.9 — `backend/api/texts.php`.** Single file, a `switch` on the HTTP method. This is the only
requirement with nothing written, so it gets a whole day.

```php
<?php
require_once __DIR__ . '/../config/database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json; charset=utf-8');

$method = $_SERVER['REQUEST_METHOD'];
$id     = isset($_GET['id']) ? (int) $_GET['id'] : null;

// POST/PUT bodies arrive as raw JSON, not as $_POST
$input = json_decode(file_get_contents('php://input'), true) ?? [];

function respond(int $status, array $data): void
{
    http_response_code($status);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}
```

> `JSON_UNESCAPED_UNICODE` is not cosmetic: without it "Coração" is returned as `"Coração"`.
> It works, but it looks wrong on screen in Insomnia.

Five endpoints:

| Method | URL | Behaviour |
|---|---|---|
| `GET` | `api/texts.php` | Lists public texts. Accepts `?category=book` and `?q=search` — filter values **always** through placeholders. `200` |
| `GET` | `api/texts.php?id=2` | One text. `200`, or `404` with `{"error": "Text not found"}` |
| `POST` | `api/texts.php` | Creates from the JSON body. `201` with the created resource; `422` on missing fields; `401` without a session |
| `PUT` | `api/texts.php?id=2` | Updates. `200`; `404`; `401`; `403` if not the author |
| `DELETE` | `api/texts.php?id=2` | Deletes. `204` with no body; `404`/`401`/`403` as applicable |

Any other method returns `405` with `{"error": "Method not allowed"}`. Wrap database work in
`try/catch (PDOException)`, respond `500` with a generic message and `error_log()` the real error —
never return `getMessage()` in the response.

**Why this duplicates `backend/create.php` on purpose.** Both insert into `texts`. That is the
pedagogical point of the API class: a web page and an API are not the same thing. One takes `$_POST`
from a form and answers with a redirect; the other takes JSON from `php://input` and answers with
JSON plus a status code. Same database, different clients, different goals. Do not unify them into a
shared layer this week — that refactor is what the frozen `backend-php/` is for.

**4.10 — Test from the terminal first:**

```bash
curl -i http://localhost/stanza/backend/api/texts.php
```

```bash
curl -i "http://localhost/stanza/backend/api/texts.php?id=99999"
```

```bash
curl -i -X POST -H "Content-Type: application/json" -d '{"title":"Via API","description":"Created from Insomnia","category":"poetry"}' http://localhost/stanza/backend/api/texts.php
```

The second must answer `404`. The error case matters as much as the success case in the
demonstration.

**4.11 — Build the Insomnia collection** in the order of the script, with the example JSON already
filled in, and save it. Do not improvise typing on Friday.

**4.12 — Catalog via `fetch`.** Replace Monday's `foreach` with a client-side render in
`frontend/js/catalog.js`, wiring the existing category and search controls to `?category=` and `?q=`.
Show a loading state and handle failure with a message, so a broken request is not a blank screen.
**Keep the server-side version reachable** (a separate commit, or `catalog-server.php`).

**4.13 — Test `PUT` and `DELETE` through Apache today, not Friday.** XAMPP allows both by default,
but if the server returns `405` before reaching our code, the workaround is `POST` with
`?_method=PUT` — and that is a change you do not want to discover on the morning of the
presentation.

---

### Thursday 03/09 — English sweep, AI declaration, cleanup

**4.14 — Error parameter rename** (§3.3), backend and frontend in the same commit.

**4.15 — English sweep** on the files not already rewritten: `profile.php`, `edit.php`,
`create.php`, `settings.php`, `landing.php`, `modal-register.php`, `modal-login.php`, `nav.php`,
`read.php`. Labels only — `id`, `name` and `value` attributes already match the database and must
not be touched.

**4.16 — Rename the Portuguese identifiers** in `backend/create.php` and `backend/update.php`
(§3.3). Small, mechanical, and it removes an obvious inconsistency from files the panel may open.

**4.17 — AI declaration** (§2): `README.md` plus comment headers in the four main backend files.
Fill the table in together — the policy asks for what actually happened, and the panel may ask
follow-up questions about the entries.

**4.18 — Cleanup:**
- delete `frontend/auth.php`;
- fix `frontend/edit.php:126` — the mobile Save is still an `<a>`, make it `<button type="submit">`;
- replace the leftover placeholder hrefs (`LINNNNK`, `searchh`, `forgottt`, `ALGUMA ACAO`,
  `action="/search"`) with real links or `#`;
- standardize the `register.php` redirect to the absolute form used by `login.php`.

---

### Friday 04/09 — load, verify, rehearse

**4.19 — Reload the seed** into a clean database and walk the whole site with real data.

**4.20 — Mobile check.** The project is Mobile First — open it at phone width in DevTools. Cheap
points with this instructor. It also matters for one specific reason: on desktop the edit sidebar
sits at `left: -232px` and only slides in on `:hover`, so **the Delete button is invisible until the
mouse touches the left edge**. Either rehearse that movement or demonstrate DELETE at phone width.

**4.21 — Full cycle once, from zero:** register → create → write → read → edit → delete.

**4.22 — Rehearse §6 twice, timed.**

---

## 5. Definition of done

- **CRUD:** a logged-in user creates a text → lands in the editor → writes the body and saves →
  opens the reading screen and sees it → the text appears in the catalog → returns to the editor,
  changes the title, saves, and the change shows in the reading screen → deletes it, confirms, and
  **the card disappears from the catalog**. All without touching phpMyAdmin.
- **Authentication:** create an account → log out → log back in → **the header shows the user's
  name** → opening `edit.php?id=N` while logged out redirects to login → editing someone else's
  text is blocked.
- **Landing page:** a logged-out visitor opens `http://localhost/stanza/` and lands there, with CTAs
  opening the sign-in and sign-up modals.
- **API:** in Insomnia, the five endpoints answer JSON with the right status codes, **including the
  error cases** (404 on a missing id, 401 without a session, 405 on an unsupported method). The
  site's catalog loads from that same API.
- **AI policy:** the declaration is in `README.md` and in the backend file headers, filled with what
  actually happened, and every member can explain the excerpts in §2.4.
- **English:** no Portuguese visible anywhere in the interface, and none in code or identifiers.
  The `DECLARAÇÃO DE USO DE INTELIGÊNCIA ARTIFICIAL` title is the one intentional exception — be
  ready to say why.

---

## 6. Presentation script (~10 minutes)

The four original requirements told as one story, with the two new ones woven in rather than
bolted on.

1. **Landing (40s)** — open `http://localhost/stanza/`. "This is the front door for someone
   without an account."
2. **Register (1min)** — create an account live, in the modal. Show in phpMyAdmin that the password
   was stored as a hash, not as text. *Say:* `password_hash()` and prepared statements — the two
   reasons the PDO material gives for not doing it the old way.
3. **CREATE (1min)** — create a text, land in the editor, write, save.
4. **READ (1min)** — open the reading screen. Reload and show the view counter going up — that is
   an `UPDATE` happening live.
5. **UPDATE (40s)** — change the title, save, see it change in the reading screen.
6. **DELETE (30s)** — delete, confirm in the `confirm()` dialog, **the card disappears from the
   catalog**. *Say:* "DELETE always with WHERE" — and that the WHERE has a second condition that is
   security, not filtering.
7. **The turn to API (2min)** — "Everything so far was a browser receiving HTML. Now the same
   information, for a different kind of client." Open Insomnia. `GET` the list → the same text, now
   as JSON. `GET ?id=99999` → `404`. `POST` creating a text → `201`. **Go back to the browser,
   reload the catalog, and the text created from Insomnia is there.** This is the moment of the
   presentation.
8. **AI declaration (1min)** — open the `README.md`. Walk the table: which tool, at which stage, for
   what, and how it was checked. Say plainly what AI did and did not do. Invite the excerpt
   question rather than waiting for it: offer to explain one piece of the code — the ownership lock
   in the SQL is the strongest one to offer.
9. **Close (40s)** — the catalog consumes that same API through `fetch`. Next step is
   `Authorization: Bearer` for clients outside the browser, and the same API becomes the bridge to
   the Python recommendation engine.

**Have a plan B for every step.** If the cover upload fails, continue without a cover. If the
`fetch` catalog fails, revert to the server-side version. Never debug live — move on and comment
afterwards.

---

## 7. Risks

| Risk | Likelihood | Mitigation |
|---|---|---|
| The API does not get done | Medium | It owns all of Wednesday and nothing else does. If Tuesday slips, cut the `fetch` catalog (4.12) — the server-side version already satisfies "R". |
| English sweep leaves stray Portuguese on a screen shown live | Medium | Sweep by file, not by memory, and walk every screen on Friday. `home.php` and `catalog.php` are English from the rewrite, which removes the two biggest files from the risk. |
| Error rename breaks login messages | Medium | `login.php` and `register.php` read those keys. Rename both sides in one commit and test a wrong password immediately. |
| The declaration reads as generic and the panel pushes back | Medium | The policy rejects generic wording by name. Fill the table with real entries and rehearse §2.4 as questions. |
| A member cannot explain code they present | Medium | Section 9 of the policy treats this as inadequate use even when the code works. Divide §2.4 among the three of you on Thursday. |
| `PUT`/`DELETE` blocked by Apache | Low | XAMPP allows both by default. Test Wednesday (4.13); the fallback is `POST` with `?_method=PUT`. |
| Delete button invisible on desktop | Medium | The sidebar only appears on `:hover`. Rehearse the movement or demo at phone width (4.20). |
| MySQL not running | Low | It is stopped by default on this machine. `sudo /opt/lampp/lampp start` is step one of every session. |
| Empty database at showtime | Low | `db/seed.sql` exists from Monday. |

---

## 8. Out of scope

Do not start any of this until §5 is fully met:

- **Admin panel** (`backend/admin/index.php`, a 2-line stub) — not a requirement for 04/09.
- **An "About" page** carrying the AI declaration — the policy accepts `README.md` for a GitHub
  project, which is cheaper. Nice to have if Thursday finishes early.
- **Pretty API URLs** (`/api/texts/2`) via `.htaccess` + `mod_rewrite`.
- **CSRF tokens** on the POST forms.
- **`UNIQUE` on `users.name`** (§1.3).
- **`visibility` filtering in `read.php`** — until it exists, do not demonstrate private texts.
- **Orphaned cover cleanup** after DELETE and cover swaps.
- **Translating the legacy Portuguese docs** (`planejamento.md`, `plano-de-acao.md`,
  `descricao-telas.md`, `CONTRIBUTING.md`) — translate them when they are next revised.
- **Resolving the ML engine discrepancy** (documented TF-IDF + KNN vs. implemented
  sentence-transformers + FAISS). Not needed Friday, but it is a real problem for the TCC defense.
  Decide before the article is finalized.

---

## 9. Checklist

**Monday 31/08**
- [x] `db/seed.sql` with a demo user and ~10 texts — committed `5551cd2`
- [x] XAMPP started, seed loaded
- [ ] `backend/catalog.php` fixed (`TOP 5` → `LIMIT`, `fetch()` → `fetchAll()`)
- [ ] `frontend/catalog.php` markup finished — this is the current blocker, see §0.1
- [ ] `catalog.php` listing from the database, markup in English
- [ ] Server-side catalog committed separately as the fallback
- [ ] Delete a text and watch the card disappear

**Tuesday 01/09**
- [ ] `backend/home.php` + `frontend/home.php` dynamic, markup in English (confirmed §0.1)
- [ ] `header.php` showing the logged-in user and a log-out link
- [ ] `$_SESSION['user_name']` added to `backend/login.php` and `backend/register.php` (it does not exist today)
- [ ] Root `index.php` redirecting to the landing page

**Wednesday 02/09**
- [ ] `backend/api/texts.php` with the five endpoints
- [ ] Status codes verified: 200, 201, 204, 401, 403, 404, 405, 422
- [ ] `PUT` and `DELETE` confirmed to pass through Apache
- [ ] Insomnia collection saved, in script order
- [ ] Catalog loading through `fetch`, with loading and error states

**Thursday 03/09**
- [ ] Error parameters renamed, backend and frontend in one commit, login errors retested
- [ ] English sweep on the nine remaining files
- [ ] Portuguese identifiers renamed in `backend/`
- [ ] `DECLARAÇÃO DE USO DE INTELIGÊNCIA ARTIFICIAL` in `README.md`, filled with real entries
- [ ] Declaration headers in the four main backend files
- [ ] §2.4 excerpts divided among the three members
- [ ] `auth.php` deleted, mobile Save fixed, placeholder hrefs replaced

**Friday 04/09**
- [ ] Seed reloaded into a clean database
- [ ] Full cycle run once: register → create → write → read → edit → delete
- [ ] Every screen checked at phone width
- [ ] No Portuguese left in the interface
- [ ] Script rehearsed twice, timed
- [ ] Plan B rehearsed for the API step
