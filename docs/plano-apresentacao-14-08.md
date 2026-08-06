# Plano — Apresentação de 14/08/2026

> Documento de acompanhamento para as 3 exigências do professor até a apresentação de 14/08/2026: landing page, autenticação e parte administrativa. "PHP em ação" significa especificamente **conteúdo recém-ensinado em aula** — ver decisão abaixo.
>
> Escrito por Claude como orientador; a implementação é toda do Igor Daniel.
>
> **Pivô de 04/08/2026:** o dia 14/08 é um checkpoint de evolução, não a defesa oficial do TCC (essa é só daqui ~15 meses, Mês 18). Não faz sentido mostrar agora uma arquitetura (Slim + Eloquent, OOP, Composer) que ninguém do grupo aprendeu em aula ainda. Decisão: **congelar `backend-php/` como fase futura** e construir `backend-basico/`, só com PHP procedural, para as 3 entregas do dia 14.
>
> **Revisão de 05/08/2026:** o professor passou `professor-exemplos-conteudo/`, com o material teórico (igual ao que já tínhamos em `docs/php-conteudo/`) **e um site de referência completo** (`tre-fratelli-paninoteca/`) que ele considera o nível-alvo. Isso é uma fonte muito mais precisa do que "básico" significa na prática do que eu tinha antes — várias decisões deste plano mudam por causa disso. O que mudou está marcado abaixo com **[REVISADO 05/08]**.

---

## 0. O que o exemplo do professor revela

Li o código de `tre-fratelli-paninoteca/` (não só a documentação dele) — o que interessa não é o domínio (uma paninoteca), é o *padrão de código*:

- **Nenhum JavaScript em formulário nenhum.** Todo formulário é `<form method="post" action="algo.php">` tradicional, com reload de página. O `.php` que recebe processa e responde com `header('Location: ...'); exit;`. Não existe `fetch`, não existe `assets/js/` com conteúdo.
- **Sem registro de usuário real.** O login do admin usa credenciais fixas no código (`$validUsername = 'admin'; $validPassword = '123456';`, comentado como "temporary fixed credentials for the first didactic version"). Isso é mais simples que o nosso caso — nós *precisamos* de cadastro real, é uma das 3 exigências — mas confirma que não tem problema o cadastro ser bem direto, sem nada além do que já planejamos.
- **Guarda de sessão como include reutilizável.** `includes/auth.php`:
  ```php
  <?php
  if (session_status() === PHP_SESSION_NONE) { session_start(); }
  if (!isset($_SESSION['user'])) { header('Location: ../index.php'); exit; }
  ```
  Incluído com `require_once '../includes/auth.php';` no topo de toda página administrativa. Exatamente o padrão de reuso via `include`/`require` do material de aula — só que aplicado a controle de acesso, não a HTML repetido.
- **Estrutura de pastas:** `config/` (conexão + constantes), `includes/` (header, navbar, footer, auth), `admin/` (páginas internas, com subpastas por recurso — `admin/products/index.php` listar, `create.php` formulário, `store.php` processa e redireciona, `edit.php`, `update.php`, `delete.php`), `database/` (um `.sql` por tabela, formato de export do phpMyAdmin).
- **Schema:** toda tabela declara `ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci` explicitamente — o `db/schema.sql` atual do StanzAI não declara nenhum dos dois.
- **Sem Composer, sem `.env`, sem dotenv.** Credenciais direto em `config/database.php` (`$host`, `$dbname`, `$username`, `$password`).
- **Bootstrap 5 via CDN** (`<link>`/`<script>` direto, sem build step), mesmo em `includes/header.php`/`footer.php`.
- **Fora de escopo pra nós:** internacionalização (`lang/`, seletor de idioma), versionamento Beta/RC/Stable (`docs/releases/`) e a estrutura `docs/didactic/`+`docs/website/` — são convenções específicas daquele projeto/professor pro *repositório de exemplo*, não uma exigência de arquitetura de backend. Não vale replicar isso no StanzAI, focar no que é padrão de código PHP/CRUD/organização.

---

## 1. Decisões de arquitetura (já fechadas)

| Decisão | Escolha | Por quê |
|---|---|---|
| **Backend para o dia 14/08** | **`backend-basico/` — PHP procedural puro**, sem Composer, sem framework, sem ORM | Bate 1:1 com `docs/php-conteudo/` e com o exemplo do professor. |
| `backend-php/` (Slim + Eloquent) | **Congelado, não usado no dia 14/08** | Direção de longo prazo, retomada quando o grupo aprender OOP/Composer em aula. |
| **Estilo de formulário** **[REVISADO 05/08]** | **POST tradicional com reload de página**, sem `fetch()`/JSON | O exemplo do professor não usa JS em formulário nenhum — só `<form method="post">` → PHP processa → `header('Location: ...')`. Reverte a decisão anterior (fetch+FormData), que era um meio-termo baseado num exemplo seu de outro projeto, sem ainda ter visto a referência real do professor. Menos código, e bate exatamente com o que ele vai reconhecer como "nível certo". |
| **Guarda de acesso administrativo** **[REVISADO 05/08]** | **`includes/auth.php`**, um `require_once` no topo de páginas protegidas, no padrão exato do exemplo do professor | Antes eu tinha nomeado esse arquivo `verificar_admin.php` solto na raiz do `backend-basico/`; agora sigo a mesma pasta (`includes/`) e o mesmo padrão de guarda do professor, checando `$_SESSION['role'] === 'admin'` (o dele checa só "logado", porque o admin dele não tem outros tipos de usuário). |
| **Estrutura de pastas do `backend-basico/`** **[REVISADO 05/08]** | `config/database.php`, `includes/auth.php`, arquivos de ação na raiz (`cadastro.php`, `login.php`, `logout.php`), painel em `admin/index.php` | Mirror direto da estrutura do exemplo (`config/`, `includes/`, `admin/`), em vez de um `config.php` solto como eu tinha proposto antes. |
| Autenticação | **Sessão PHP nativa** (`session_start()` + `$_SESSION['user_id']`) | Confirmado pelo próprio exemplo do professor, que também usa sessão nativa (`$_SESSION['user']`). |
| Papéis do usuário **[REVISADO 05/08, de novo]** | **`role ENUM('reader', 'author', 'admin')`, tratado como hierarquia no código** — não duas colunas booleanas | Chegamos a trocar pra `is_author`/`is_admin` booleanos (pra resolver "author herda de reader" e "admin também pode ser author"), mas quem editou o schema por último voltou pro ENUM. Reavaliando: dá pra resolver o mesmo problema **sem mexer no schema**, só decidindo que a hierarquia é uma convenção do código — `admin` inclui as permissões de `author`, que inclui as de `reader`. Ver detalhe na seção 1.1 abaixo. Mantém o schema mais simples (uma coluna, igual ao `gender`) sem perder a capacidade de "quem é admin também pode publicar". |
| Campos `gender`/`birthdate` | **Entram no schema como `NOT NULL`**, adicionados por outra pessoa do time | Sem mudança — são obrigatórios no formulário de cadastro. |
| **Convenções do `db/schema.sql`** **[REVISADO 05/08]** | Toda tabela ganha `ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci` | O schema atual não declara engine nem charset/collation — o exemplo do professor declara os dois em toda tabela. Já aplicado. |
| Landing page | **HTML/CSS estático** | Sem mudança. |
| Servidor e admin de banco | **XAMPP (Apache) + phpMyAdmin do próprio XAMPP** | Sem mudança. |
| Banco de dados | **Local (XAMPP), não online/hospedado**, com `db/schema.sql` + `db/seed.sql` versionados | Sem mudança. |

### 1.1 Hierarquia de `role` no código **[novo, 05/08]**

`role` continua sendo uma coluna só, com um valor só por usuário (`'reader'`, `'author'` ou `'admin'`). A "herança" não é um recurso do banco — é uma convenção de como o PHP verifica permissão, sempre com checagens explícitas (`===`, `in_array`), nada de matemática de índice/ordinal:

```php
// Pode acessar o painel administrativo — só admin.
if ($_SESSION['role'] === 'admin') { /* ... */ }

// Pode publicar texto — author OU admin (admin "herda" a permissão de author
// só porque a lista inclui os dois; não é automático, é decisão explícita
// de incluir 'admin' nessa checagem).
if (in_array($_SESSION['role'], ['author', 'admin'])) { /* ... */ }

// Pode ler/navegar — todo mundo que está logado, não precisa checar role.
```

Pra apresentação de 14/08, só a primeira checagem (admin) é usada de verdade (no `includes/auth.php` do painel). A segunda (`author`/`admin` podem publicar) só importa quando a Arena/publicação de textos existir — guarde o padrão pra lá.

**Divisão de pastas do `backend-basico/` [REVISADO 05/08]:**
```
backend-basico/
├── config/
│   └── database.php      → conexão PDO (host/dbname/usuário/senha direto no arquivo, sem .env)
├── includes/
│   └── auth.php          → guarda de sessão: exige login + role = 'admin', senão redireciona
├── cadastro.php           → recebe POST do form de registro, valida, insere, redireciona
├── login.php               → recebe POST do form de login, valida, seta sessão, redireciona
├── logout.php              → destrói a sessão, redireciona
└── admin/
    └── index.php            → require de config/database.php + includes/auth.php, lista usuários/textos
```
- `frontend/` continua com as páginas do João (`login.php`, `register.php`, landing) — os `<form>` agora apontam `action` direto pros scripts do `backend-basico/`, sem JS de submissão (só validação HTML5 nativa via `required`, `type="email"`, etc., que é HTML puro, não framework).
- Erros de validação voltam por query string (`header('Location: ../frontend/register.php?erro=email_duplicado'); exit;`), e a página de formulário lê `$_GET['erro']` pra mostrar a mensagem — mesmo padrão que `store.php`/`create.php` usam no exemplo do professor.
- Como o repo já vive em `htdocs/stanza`, cada arquivo fica acessível direto pelo Apache: `http://localhost/stanza/backend-basico/cadastro.php`, sem `.htaccess` nem roteador.

---

## 2. Definição de "pronto" para cada exigência

- **Landing page:** visitante não-logado abre `frontend/index.html` e vê hero + "como funciona" + CTA pra cadastro/login, seguindo a Tela 1 de `docs/descricao-telas.md`. Não precisa de banco.
- **Autenticação:** usuário cria conta (`backend-basico/cadastro.php`), loga (`backend-basico/login.php`), sessão persiste entre páginas (reload normal de navegador, sem JS), e há um jeito de sair (`backend-basico/logout.php`). Senha nunca em texto puro (`password_hash`/`password_verify`).
- **Parte administrativa:** usuário com `role = 'admin'` acessa `backend-basico/admin/index.php` e vê uma listagem simples de usuários e textos cadastrados. Quem não é admin (ou não está logado) é redirecionado pelo `includes/auth.php`.

---

## 3. Cronograma dia a dia

### Dia 1 — Qua 05/08: Schema + conexão + Cadastro
- `db/schema.sql` já está com `role ENUM('reader', 'author', 'admin') NOT NULL DEFAULT 'reader'` + `gender`/`birthdate` (`NOT NULL`) + `ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci` em toda tabela — confirme com quem editou por último que essa é a versão final antes de importar.
- Subir o XAMPP e abrir o phpMyAdmin. Apagar a base `stanza` se já existir e recriar importando o `db/schema.sql` atualizado.
- Criar `backend-basico/config/database.php`: `new PDO("mysql:host=localhost;dbname=stanza;charset=utf8mb4", "root", "")` dentro de `try/catch(PDOException)` com `die()` na falha — igual ao `config/database.php` do exemplo do professor.
- Criar `backend-basico/cadastro.php`: `require '../backend-basico/config/database.php'` (ou caminho relativo equivalente a partir de onde o form aponta); ler `$_POST['name']`, `email`, `password`, `gender`, `birthdate`; validar campos vazios; checar e-mail duplicado com `SELECT` preparado; `INSERT` preparado com `password_hash($password, PASSWORD_DEFAULT)`; em sucesso `header('Location: ...frontend/login.php')`, em erro `header('Location: ...frontend/register.php?erro=...')`.
- Testar com `curl -X POST -d "name=...&email=...&password=...&gender=...&birthdate=YYYY-MM-DD" http://localhost/stanza/backend-basico/cadastro.php -i` (o `-i` mostra o header `Location` do redirect) antes de mexer no formulário HTML.

### Dia 2 — Qui 06/08: Login + Sessão + guarda de acesso
- `backend-basico/login.php`: busca por e-mail com `SELECT` preparado, `password_verify()`; se ok grava `$_SESSION['user_id']` e `$_SESSION['role']` e redireciona pra próxima tela; se falhar, redireciona de volta pro form com erro.
- `backend-basico/includes/auth.php`, no padrão do professor:
  ```php
  <?php
  if (session_status() === PHP_SESSION_NONE) { session_start(); }
  if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
      header('Location: /stanza/frontend/login.php');
      exit;
  }
  ```
- `backend-basico/logout.php`: `session_start(); $_SESSION = []; session_destroy(); header('Location: ...'); exit;` — mesmo padrão do `admin/logout.php` do exemplo.

### Dia 3 — Sex 07/08: Ligar os formulários existentes
- Em `frontend/register.php` e `frontend/login.php`: ajustar `action` do `<form>` pra apontar pro script certo em `backend-basico/`, `method="post"`. **Sem JS de submissão** — o navegador já faz o reload sozinho, como no exemplo do professor.
- Se quiser mostrar mensagem de erro (e-mail duplicado, campo faltando): bloco `<?php if (isset($_GET['erro'])): ?>` no topo do form, mesmo padrão de exibição condicional do `admin/index.php` do professor (o dele nem precisa de `$_GET` porque forms se auto-submetem, mas o nosso caso — form e handler em arquivos separados — se resolve com redirect + query string, como o `store.php`/`create.php` do professor faz pra imagem inválida).
- Testar o fluxo fim a fim no navegador: cadastro → redireciona pro login → loga → sessão ativa (confira no DevTools → Application → Cookies que o `PHPSESSID` foi setado).
- **Fim de semana (08–09/08) é buffer, não obrigação.**

### Dia 4 — Seg 10/08: Landing page
- Criar `frontend/index.html` com a landing estática (Tela 1), seguindo a paleta do `CLAUDE.md`.
- Botões "Entrar"/"Começar agora" apontando para `frontend/login.php`/`frontend/register.php`.

### Dia 5 — Ter 11/08: Painel administrativo
- Criar `backend-basico/admin/index.php`: `require_once '../config/database.php'; require_once '../includes/auth.php';` no topo (guarda entra antes de qualquer output, igual ao exemplo); depois `SELECT * FROM users` e `SELECT * FROM texts` com PDO, `foreach` imprimindo linhas de tabela HTML, `htmlspecialchars()` em todo dado do banco.
- Promover seu próprio usuário de teste: phpMyAdmin, tabela `users`, marcar `role = 'admin'`.

### Dia 6 — Qua 12/08: Integração Apache/XAMPP fim a fim
- Confirmar que `http://localhost/stanza/backend-basico/...` responde (arquivo PHP normal, sem roteador envolvido).
- Confirmar MySQL de pé, phpMyAdmin mostrando as tabelas populadas.
- Rodar o fluxo completo num navegador, do zero: landing → cadastro → login → admin (pra quem é admin) → logout.
- Corrigir bugs de integração (cookies de sessão, paths relativos de CSS/links entre `frontend/` e `backend-basico/`).

### Dia 7 — Qui 13/08: Polimento + segurança básica + dados de demo
- Conferir paleta de cores e tipografia (`CLAUDE.md`) nas 3 telas; checar mobile-first pelo menos visualmente.
- Confirmar que toda query usa `prepare()`/`execute()` com parâmetros.
- Confirmar `htmlspecialchars()` em qualquer dado do banco impresso em HTML (principalmente `admin/index.php`).
- Criar `db/seed.sql`: `INSERT`s com 3–5 usuários (pelo menos 1 com `role = 'admin'`, 1 com `role = 'author'`) e alguns textos de exemplo. Versionado (commit `raw:`).
- **Crítico, já que a apresentação pode ser em outra máquina:** identificar HOJE qual máquina vai apresentar. Se não for a sua, instalar XAMPP lá com folga e importar `schema.sql` + `seed.sql`. Sem Composer, sem Poetry necessários pro `backend-basico/`.

### Dia 8 — Sex 14/08: Apresentação
- Checklist antes da aula (seção 4), rodado **na máquina que vai efetivamente apresentar**.
- Sem código novo no dia — só validação.

---

## 4. Checklist pré-apresentação

- [ ] Confirmado **qual máquina** vai apresentar, com XAMPP já instalado lá (não no dia 14)
- [ ] `/opt/lampp/lampp startapache` e `startmysql` rodando **nessa máquina**
- [ ] `http://localhost/phpmyadmin` abre e mostra o banco `stanza`
- [ ] `backend-basico/config/database.php` presente na máquina, com credenciais locais do MySQL do XAMPP (`root` / senha vazia)
- [ ] Banco `stanza` criado a partir do `db/schema.sql` atualizado (`role` ENUM reader/author/admin + `gender`/`birthdate` + `ENGINE=InnoDB`/charset) **+ `db/seed.sql` importado**
- [ ] Pelo menos 1 usuário com `role = 'admin'` existe no banco
- [ ] Fluxo testado do zero em uma aba anônima do navegador: landing → cadastro → login → admin → logout, tudo com reload de página normal (sem depender de JS pra funcionar)
- [ ] Nenhum `composer install`/`poetry install` é necessário pro `backend-basico/`

---

## 5. O que cortar primeiro se faltar tempo

1. Validação client-side além do `required`/`type` nativo do HTML — não tem JS de validação chique nesse plano, então já está no mínimo
2. Polimento visual fino (paleta exata, mobile-first perfeito) — funcional já é suficiente pro professor
3. Seletor de perfil leitor/escritor/os dois — já cortado do MVP (`gender`/`birthdate` não entram nessa lista: são `NOT NULL`, obrigatórios)
4. **Nunca corte:** autenticação funcionando, a tela administrativa (2 das 3 exigências explícitas), e a preparação da máquina de apresentação (Dia 7)

Se o Dia 3 atrasar, use o buffer do fim de semana antes de cortar qualquer coisa da lista acima.
