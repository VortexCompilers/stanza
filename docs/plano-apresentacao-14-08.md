# Plano — Apresentação de 14/08/2026

> Documento de acompanhamento para as 3 exigências do professor até a apresentação de 14/08/2026: landing page, autenticação e parte administrativa. "PHP em ação" já está coberto pela migração feita em `docs/migracao-php-backend.md` — o back-end é PHP agora, então qualquer uma dessas três entregas já demonstra isso.
>
> Escrito por Claude como orientador; a implementação é toda do Igor Daniel. Hoje é terça, 04/08 — restam **10 dias corridos**, apresentação na sexta 14/08.

---

## 1. Decisões de arquitetura (já fechadas)

| Decisão | Escolha | Por quê |
|---|---|---|
| Autenticação | **Sessão PHP nativa** (`session_start()` + `$_SESSION['user_id']`) | Formulários são server-rendered, não uma SPA. JWT (já no `composer.json`) fica reservado pro dia em que existir um cliente desacoplado (app mobile, front em JS puro consumindo a API). |
| Papéis do usuário | **Trocar `role ENUM('author','reader')` por duas flags booleanas: `is_author` e `is_admin`** em `users` | "Reader" vira o estado base implícito de todo usuário (não precisa de coluna). `is_author` é uma extensão de capacidade em cima disso — literalmente "author herda de reader" — e resolve o "Sou os dois" da Tela 2 (`docs/descricao-telas.md`), que o ENUM não conseguia representar. `is_admin` fica num eixo próprio, independente: um admin continua podendo ser reader e/ou author ao mesmo tempo, o que fazia menos sentido com ENUM de valor único. Custo: quem já tem banco local precisa recriar a tabela `users` (ver Dia 1). |
| Landing page | **HTML/CSS estático primeiro**, com espaço para evoluir para view PHP se sobrar tempo | Prioriza ter algo pronto cedo. Se os Dias 1–3 (auth) forem tranquilos, migrar pra uma rota `GET /` no Slim é o primeiro item de polimento — mantém tudo servido pelo mesmo front controller.
| Servidor e admin de banco | **XAMPP (Apache) + phpMyAdmin do próprio XAMPP** | Já é o ambiente instalado (`/opt/lampp`) e o repo já vive em `htdocs/`. phpMyAdmin evita depender do cliente `mysql` via linha de comando, que nem está no `PATH` neste ambiente (só o binário empacotado do XAMPP). |
| Banco de dados | **Local (XAMPP), não online/hospedado** — cada máquina tem seu próprio MySQL, sincronizadas via `db/schema.sql` + um novo `db/seed.sql` versionado (dados de exemplo como `INSERT`s) | Banco online evitaria "cada um ter um diferente", mas troca isso por um risco pior: depender de internet estável no dia da apresentação, e configurar hosting/segurança sob prazo de 10 dias. Como a apresentação **pode ser em outra máquina** (confirmado), o que resolve isso não é centralizar o banco — é o `schema.sql` + `seed.sql` reproduzirem o mesmo estado em qualquer lugar com 2 imports no phpMyAdmin, sem rede. |
| Estilo de integração front↔back | **`fetch()` + JSON, mesma origem (Apache/XAMPP dos dois lados)**, sem reload de página nos formulários | Confirmado: já que tudo roda sob `localhost/stanza/...` via Apache, é a mesma origem — cookie de sessão vai junto no `fetch` automaticamente, sem CORS e sem precisar de `credentials: 'include'`. Isso muda a forma dos Controllers (JSON, não redirect) e o trabalho do Dia 3 (ver abaixo). |

**Divisão de pastas que você vai usar:**
- `frontend/` — as páginas estáticas do João (`login.php`, `register.php`, landing) continuam aqui, com JS puro (`fetch`) fazendo a ponte com o back-end — sem framework, no estilo `addEventListener` + `async/await` que você já usa em outros projetos.
- `backend-php/` — é quem processa: `Controllers/AuthController.php`, `Controllers/AdminController.php`, `Models/User.php`, `Middleware/AuthMiddleware.php`. Cada endpoint devolve **JSON** (`$response->getBody()->write(json_encode(...))`, ver `src/Routes/api.php` do `/health` como modelo) com o status HTTP certo (`200`/`201` sucesso, `401` credencial inválida, `422` validação, `409` e-mail duplicado) — quem decide o que fazer com a resposta (redirecionar, mostrar erro) é o JS no `frontend/`, não o PHP.
- Como tudo roda sob o mesmo host (`localhost/stanza/...` via XAMPP), sessão PHP funciona sem CORS entre `frontend/` e `backend-php/public/`.
- **Atenção a um detalhe do seu exemplo:** não hardcode `http://127.0.0.1:8000` (ou qualquer porta fixa) nas chamadas `fetch` — isso reintroduz cross-origin sem necessidade. Use caminho relativo ou monte a URL a partir de `window.location.origin`, ex.: `` `${window.location.origin}/stanza/backend-php/public/login` ``.

---

## 2. Definição de "pronto" para cada exigência

- **Landing page:** visitante não-logado abre `frontend/index.html` e vê hero + "como funciona" + CTA pra cadastro/login, seguindo a Tela 1 de `docs/descricao-telas.md`. Não precisa de banco.
- **Autenticação:** usuário cria conta (`POST /register`), loga (`POST /login`), sessão persiste entre páginas, e há um jeito de sair (`POST /logout`). Senha nunca em texto puro (`password_hash`/`password_verify`).
- **Parte administrativa:** usuário com `is_admin = true` acessa `GET /admin` e vê uma listagem simples de usuários e textos cadastrados. Quem não é admin (ou não está logado) toma 403/redirect.

Tudo isso já satisfaz "PHP em ação" — não precisa de artefato separado.

---

## 3. Cronograma dia a dia

### Dia 1 — Qua 05/08: Schema + Model User + Cadastro
- Editar `db/schema.sql`: trocar `role ENUM('author', 'reader')` por `is_author BOOLEAN NOT NULL DEFAULT FALSE` e `is_admin BOOLEAN NOT NULL DEFAULT FALSE`.
- Subir o XAMPP (Apache + MySQL) e abrir o phpMyAdmin (`http://localhost/phpmyadmin`). Apagar a base `stanza` se já existir (aba "Databases" → excluir) e recriar importando o `db/schema.sql` atualizado (aba "Import" ou colar o conteúdo na aba "SQL") — combine com o time antes, já que é schema compartilhado.
- Criar `backend-php/src/Models/User.php` (Eloquent, `extends Model`, `$table = 'users'`, `$timestamps = false` já que a tabela usa `created_at` sem `updated_at`).
- Criar `backend-php/src/Controllers/AuthController.php` com `register()`: valida `name`/`email`/`password` (mínimo: campos não vazios, e-mail com formato válido, e-mail único), grava com `password_hash($password, PASSWORD_DEFAULT)`. Não precisa setar `is_author`/`is_admin` no insert — os dois já nascem `FALSE` pelo `DEFAULT` da coluna. Responde JSON: `201` + `{"user": {...}}` no sucesso, `422` + `{"errors": {...}}` em validação, `409` + `{"error": "e-mail já cadastrado"}` em duplicidade.
- Adicionar `POST /register` em `Routes/api.php`.
- Testar com `curl -X POST -H "Content-Type: application/json" -d '{"name":"...","email":"...","password":"..."}'` antes de mexer no formulário HTML — mais fácil de depurar a resposta JSON isoladamente.

### Dia 2 — Qui 06/08: Login + Sessão + Middleware
- `AuthController::login()`: busca por e-mail, `password_verify()`, se ok grava `$_SESSION['user_id']` e `$_SESSION['is_admin']` e responde `200` + `{"user": {...}}`; se falhar, `401` + `{"error": "credenciais inválidas"}`.
- `AuthController::logout()`: `session_destroy()`, responde `200` + `{"ok": true}`.
- `backend-php/src/Middleware/AuthMiddleware.php`: checa `$_SESSION['user_id']`, senão redireciona/403. Aplicar em rotas protegidas futuras (ex: `/admin`).
- Adicionar `session_start()` no bootstrap (`src/bootstrap.php`, início de `createApp()` ou no `public/index.php`).
- Rotas `POST /login`, `POST /logout`.

### Dia 3 — Sex 07/08: Ligar os formulários existentes (JS + fetch)
- Escopo maior do que só trocar `action`/`method`: os `<form>` de `frontend/register.php` e `frontend/login.php` passam a ter `id`, o JS escuta `submit`, faz `e.preventDefault()`, monta o `fetch(..., { method: "POST", headers: {"Content-Type": "application/json"}, body: JSON.stringify({...}) })` e trata a resposta — no estilo do seu exemplo (`addEventListener`, `async/await`, `try/catch`, `input.setCustomValidity(...)` pra validação client-side).
- No sucesso: `window.location.href` pra próxima tela (login → feed/placeholder, register → login). No erro: mostrar a mensagem que veio no JSON (adapte o `alert()` do seu exemplo pra algo no próprio formulário, se der tempo — não é bloqueante).
- Em `frontend/register.php`: renomear `id="username" name="username"` para `id="name" name="name"`, pra bater com o campo `name` que o `AuthController::register()` espera no JSON.
- Campos que o wireframe/design pede mas ficam de fora do MVP de 14/08 (cortados, não implementar agora):
  - `gender`, `birthdate` no cadastro — não existem no schema, não vale mudar o schema de novo essa semana por isso.
  - O seletor "Sou leitor / Sou escritor / Sou os dois" da Tela 2 (`docs/descricao-telas.md`) — o cadastro deixa `is_author = false` (padrão da coluna), sem perguntar nada. Diferente da versão anterior deste plano, o schema com `is_author`/`is_admin` já suporta "os dois" nativamente (basta marcar `is_author = true` num usuário que também é reader por padrão) — é só uma questão de tempo pra adicionar o checkbox no formulário, não uma limitação do modelo. Fica pra depois do dia 14 se sobrar tempo.
- Testar o fluxo fim a fim no navegador: cadastro → redirecionamento → login → sessão ativa (confira no DevTools → Application → Cookies que o `PHPSESSID` foi setado).
- **Fim de semana (08–09/08) é buffer, não obrigação.** Se estiver em dia, adiante o Dia 4; se atrasou, é aqui que você recupera.

### Dia 4 — Seg 10/08: Landing page
- Criar `frontend/index.html` com a landing estática (Tela 1): header fixo, hero, "Como Funciona", prova social, rodapé — seguindo a paleta oficial do `CLAUDE.md`.
- Botões "Entrar" / "Começar agora" apontando para `frontend/login.php` / `frontend/register.php`.
- Se sobrar tempo no dia: mover para uma rota `GET /` no Slim renderizando um template PHP simples (upgrade opcional combinado na decisão da seção 1).

### Dia 5 — Ter 11/08: Painel administrativo
- `backend-php/src/Controllers/AdminController.php`: `index()` busca todos os `User::all()` e textos (`Text::all()`, crie o model se ainda não existir) via Eloquent.
- Reaproveitar `AuthMiddleware` + checagem extra `$_SESSION['is_admin'] === true` (pode virar um `AdminMiddleware.php` que empilha em cima do `AuthMiddleware`).
- Recomendo manter essa tela **server-rendered** (o próprio `AdminController` devolve HTML com a tabela, sem passar por `fetch`) — é mais rápido de fazer que replicar o padrão JS do Dia 3 aqui, e não há necessidade de interatividade nessa tela por enquanto. Se sobrar tempo, dá pra converter pro mesmo estilo depois (sem exigir Chart.js ou nada do Portal do Autor — isso é escopo de meses futuros, não desta entrega).
- Rota `GET /admin`.
- Promover seu próprio usuário de teste: no phpMyAdmin, aba "Browse" da tabela `users`, editar a linha e marcar `is_admin = 1`.

### Dia 6 — Qua 12/08: Integração Apache/XAMPP fim a fim
- Confirmar que o Apache do XAMPP está servindo `backend-php/public/` corretamente (o repo já vive em `htdocs/`, então é ajustar `.htaccess`/URL, não reinstalar nada).
- Confirmar que o MySQL do XAMPP está de pé e que dá pra abrir o phpMyAdmin e ver as tabelas populadas.
- Rodar o fluxo completo num navegador, do zero: landing → cadastro → login → admin (pra quem é admin) → logout.
- Corrigir os bugs de integração que só aparecem fora do `curl` (cookies de sessão, paths relativos de CSS, etc).

### Dia 7 — Qui 13/08: Polimento + segurança básica + dados de demo
- Conferir paleta de cores e tipografia (`CLAUDE.md`) nas 3 telas; checar mobile-first pelo menos visualmente.
- Escapar output de dados vindos do banco ao renderizar (`htmlspecialchars()`) — evita XSS na tabela de admin e nas páginas logadas.
- Confirmar que toda query passa pelo Eloquent (prepared statements automáticos) — não escrever SQL cru concatenando `$_POST` em lugar nenhum.
- Criar `db/seed.sql`: `INSERT`s com 3–5 usuários (pelo menos 1 com `is_admin = 1`, pelo menos 1 com `is_author = 1`) e alguns textos de exemplo. Versionado (commit `raw:`), não é só rodar `INSERT` direto no phpMyAdmin e esquecer — precisa sobreviver a "importar num computador novo".
- **Crítico, já que a apresentação pode ser em outra máquina:** identificar HOJE qual máquina vai apresentar. Se não for a sua, instalar lá (com folga, não no dia): XAMPP, Composer (`~/.local/bin/composer` como você fez aqui), Poetry — e importar `schema.sql` + `seed.sql` pra validar que sobe sem depender de nada desta máquina.

### Dia 8 — Sex 14/08: Apresentação
- Checklist antes da aula (seção 4 abaixo), rodado **na máquina que vai efetivamente apresentar**.
- Sem código novo no dia — só validação.

---

## 4. Checklist pré-apresentação

- [ ] Confirmado **qual máquina** vai apresentar, com XAMPP/Composer/Poetry já instalados lá (não no dia 14)
- [ ] `/opt/lampp/lampp startapache` e `startmysql` rodando **nessa máquina**
- [ ] `http://localhost/phpmyadmin` abre e mostra o banco `stanza`
- [ ] `backend-php/.env` preenchido e presente (não commitado, mas existente na máquina que vai apresentar) — `DB_USER=root`, `DB_PASSWORD=` vazio, que é o padrão do MySQL do XAMPP
- [ ] Banco `stanza` criado a partir do `db/schema.sql` atualizado (com `is_author`/`is_admin` em vez do `role` antigo) **+ `db/seed.sql` importado**
- [ ] Pelo menos 1 usuário com `is_admin = 1` existe no banco (via seed ou promovido depois no phpMyAdmin)
- [ ] Fluxo testado do zero em uma aba anônima do navegador: landing → cadastro → login → admin → logout
- [ ] `composer install` e `poetry install` já rodados nessa máquina com antecedência (não deixar pro dia)

---

## 5. O que cortar primeiro se faltar tempo

Na ordem em que eu cortaria, do menos custoso ao mais crítico:

1. Upgrade da landing page de estática para view PHP (fica estática mesmo, sem problema)
2. Validação client-side chique (máscaras, `setCustomValidity` bonito) — a validação que importa de verdade é a do back-end (Dia 1/2); no front, um `alert()` simples já resolve pro dia 14
3. Polimento visual fino (paleta exata, mobile-first perfeito) — funcional já é suficiente pro professor
4. Campos extras do cadastro (`gender`, `birthdate`, seletor de perfil leitor/escritor/os dois) — já cortados do MVP por decisão acima
5. **Nunca corte:** autenticação funcionando, a tela administrativa (2 das 3 exigências explícitas), e a preparação da máquina de apresentação (Dia 7) — sem isso, o resto do trabalho não roda no dia 14

Se o Dia 3 (integração dos formulários) atrasar, use o buffer do fim de semana antes de cortar qualquer coisa da lista acima.
