# 🔄 Plano de Migração — Back-End Python → PHP (Slim)

> Documento de referência para a migração arquitetural do StanzAI.
> Contexto: exigência da disciplina de usar PHP no back-end.
> Decisão da equipe: **PHP (Slim Framework)** assume o back-end principal;
> **Python permanece exclusivamente no motor de recomendação (ML)** da Viola.

---

## 1️⃣ Estado Atual do Repositório (antes da migração)

Levantamento do que existe hoje em `stanza_api/`:

```
stanza/
├── stanza_api/                  ← projeto Poetry (Python)
│   ├── stanza_api/
│   │   ├── app.py               ← instância FastAPI, ainda sem rotas de negócio
│   │   ├── database.py          ← engine/sessão do SQLAlchemy
│   │   ├── settings.py          ← configurações (Pydantic Settings)
│   │   ├── models/
│   │   │   ├── base.py          ← table_registry (SQLAlchemy declarative)
│   │   │   ├── users.py         ← modelo Users (dataclass mapping)
│   │   ├── routers/              ← vazio (só __init__.py)
│   │   ├── schemas/              ← vazio (só __init__.py)
│   │   ├── services/             ← vazio (só __init__.py)
│   ├── tests/                    ← vazio (só __init__.py)
│   └── pyproject.toml            ← FastAPI, SQLAlchemy, Alembic, Pydantic, Ruff, Taskipy, Pytest
├── db/                           ← scripts SQL avulsos
├── docs/                         ← planejamento (planos dos membros, planejamento.md, etc.)
├── CONTRIBUTING.md
└── LICENSE
```

**Diagnóstico:** o projeto está na fase de **configuração de ambiente e primeiro modelo** (equivalente às aulas 01–03 do curso do dunossauro). Não há rotas de negócio implementadas (`routers/`, `schemas/`, `services/` estão vazios) e apenas o modelo `Users` foi criado. **Isso é uma boa notícia** — o custo da migração é baixo porque pouco código de CRUD foi escrito ainda. O trabalho perdido é essencialmente configuração de ambiente, não lógica de negócio.

---

## 2️⃣ Decisão Arquitetural

```
┌──────────────┐      ┌────────────────────┐      ┌──────────────┐
│   FRONTEND   │ ───→ │   BACK-END (PHP)    │ ───→ │    MySQL     │
│  (Jonas)     │ ←─── │  Slim Framework      │ ←─── │              │
└──────────────┘      └─────────┬───────────┘      └──────────────┘
                                 │ ↕ HTTP (contrato de API)
                       ┌─────────┴───────────┐
                       │  MOTOR DE ML (Python) │
                       │  FastAPI, só recomendação │
                       └──────────────────────┘
```

O papel do Igor Daniel muda de "back-end em Python" para **"back-end em PHP + integrador do serviço de ML"**. A arquitetura de três camadas (frontend / back-end / ML) continua idêntica — só a linguagem do meio muda.

---

## 3️⃣ Nova Estrutura de Pastas Proposta

```
stanza/
├── backend-php/                  ← NOVO — projeto Slim (back-end principal)
│   ├── public/
│   │   └── index.php             ← ponto de entrada único (front controller)
│   ├── src/
│   │   ├── Controllers/
│   │   │   ├── UserController.php
│   │   │   └── TextController.php
│   │   ├── Models/
│   │   │   ├── User.php
│   │   │   └── Text.php
│   │   ├── Middleware/
│   │   │   └── AuthMiddleware.php
│   │   ├── Routes/
│   │   │   └── api.php
│   │   └── Services/
│   │       └── MlClient.php      ← chama a API Python da Viola
│   ├── tests/
│   ├── composer.json
│   ├── .env.example
│   └── .htaccess
│
├── ml-engine/                    ← RENOMEADO de stanza_api/ (Python, só ML)
│   ├── ml_engine/
│   │   ├── app.py                ← FastAPI enxuto, só endpoint de recomendação
│   │   ├── vectorizer.py         ← TF-IDF
│   │   ├── recommender.py        ← KNN + similaridade de cosseno
│   │   └── preprocessing.py      ← limpeza de texto, stopwords PT-BR
│   ├── tests/
│   └── pyproject.toml            ← dependências reduzidas (ver §5)
│
├── db/
│   └── schema.sql                ← agora é a FONTE DE VERDADE do banco (ver §4)
├── docs/
└── CONTRIBUTING.md
```

> **Nota sobre o nome `ml-engine`:** sugestão opcional para deixar explícito que o Python agora serve só ao motor de recomendação. Se a equipe preferir manter `stanza_api`, tudo bem — é só uma questão de clareza, não é obrigatório.

---

## 4️⃣ O Que é Reaproveitável vs. O Que Precisa Ser Refeito

### ✅ Reaproveitável (sem mudança ou com adaptação leve)

| Item | Situação |
|---|---|
| Estrutura conceitual das tabelas (`users`, `texts`, FKs) | O modelo de dados que você já pensou continua válido — só muda a ferramenta que o materializa |
| `db/` como pasta de schema SQL | Vira a **fonte de verdade** do banco (ver §4.1) |
| Padrão de commits (`CONTRIBUTING.md`) | Os prefixos (`feat`, `raw`, `fix`...) continuam idênticos, funcionam em qualquer linguagem |
| Fluxo de branches (`main`/`dev`) | Inalterado |
| Planos de desenvolvimento (`docs/plano-*.md`) | Só a seção de stack tecnológica do seu plano precisa de atualização |
| O contrato conceitual da API com a Viola | A ideia (`POST /recomendar` → `{ recomendacoes: [...] }`) continua a mesma, só quem consome muda de Python para PHP |

### ❌ Precisa ser refeito em PHP

| Item Python (descartado) | Equivalente em PHP |
|---|---|
| `stanza_api/models/users.py` (SQLAlchemy) | `backend-php/src/Models/User.php` |
| `stanza_api/database.py` (engine SQLAlchemy) | Conexão PDO ou Eloquent standalone (ver §5.2) |
| `stanza_api/routers/` (vazio, mas seria FastAPI routes) | `backend-php/src/Controllers/` + `src/Routes/api.php` |
| Alembic (migrations) | Migrations do Slim/Eloquent, ou scripts SQL versionados manualmente em `db/` |
| Pydantic (validação de schemas) | Validação manual ou biblioteca PHP (ex: `respect/validation`) |

### 🔻 Removido do Python (não é mais necessário)

Como o Python agora só expõe o motor de ML, essas dependências saem do `pyproject.toml`:
- `sqlalchemy` — o motor de ML não precisa de ORM (ele lê o dataset, não gerencia usuários/textos)
- `alembic` — sem migrations, pois não há mais schema de CRUD em Python

---

### 4.1 — Sobre a "fonte de verdade" do banco

Como o SQLAlchemy não vai mais definir o schema, a pasta `db/schema.sql` passa a ser onde as tabelas são declaradas oficialmente, em SQL puro:

```sql
-- db/schema.sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE texts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    body TEXT NOT NULL,
    genre VARCHAR(50),
    author_id INT NOT NULL,
    published_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (author_id) REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
```

Tanto o PHP quanto o Python (se precisar ler algo do banco) rodam contra esse mesmo schema. Esse arquivo entra com commit `raw:`.

---

## 5️⃣ Configuração do Novo Ambiente PHP (Slim)

### 5.1 — Instalar dependências de sistema

```bash
sudo apt install php php-cli php-mysql composer -y
php --version
composer --version
```

### 5.2 — Criar o projeto Slim

```bash
cd stanza
composer create-project slim/slim-skeleton backend-php
cd backend-php
```

Isso já vem com uma estrutura de pastas parecida com a proposta no §3 (pode variar um pouco — ajustaremos).

### 5.3 — Dependências recomendadas

```bash
# Conexão com MySQL (escolha uma abordagem — ver comparação abaixo)
composer require vlucas/phpdotenv       # variáveis de ambiente (.env)
composer require illuminate/database    # Eloquent ORM "standalone" (opcional)
composer require firebase/php-jwt       # autenticação via token JWT
composer require guzzlehttp/guzzle      # cliente HTTP p/ chamar a API do Python (Viola)

# Testes
composer require --dev phpunit/phpunit
```

**PDO puro vs. Eloquent standalone — qual escolher?**

| | PDO puro | Eloquent (Illuminate/Database) |
|---|---|---|
| Curva de aprendizado | Menor, mais explícito | Um pouco maior, mas muito documentado |
| Prepared statements (proteção SQL Injection) | Manual, mas simples | Automático |
| Familiaridade no ecossistema PHP | Universal | Popular (usado no Laravel) |
| Recomendação para o StanzAI | Bom se quiser controle total | **Recomendado** — reduz código boilerplate e já entrega proteção contra SQL Injection por padrão |

### 5.4 — Estrutura de configuração (`.env`)

```env
DB_HOST=127.0.0.1
DB_NAME=stanzai
DB_USER=root
DB_PASSWORD=
ML_ENGINE_URL=http://localhost:8000
JWT_SECRET=defina_uma_chave_segura_aqui
```

> Igual ao `python-dotenv`, o `vlucas/phpdotenv` mantém credenciais fora do Git — `.env` continua no `.gitignore`.

---

## 6️⃣ Reduzindo o Projeto Python ao Motor de ML

### 6.1 — Novo `pyproject.toml` (enxuto)

```toml
[tool.poetry.dependencies]
python = ">=3.13,<4.0"
fastapi = {extras = ["standard"], version = "*"}
uvicorn = "*"
pandas = "*"
numpy = "*"
nltk = "*"
pydantic = "*"   # mantido só para validar o contrato de entrada/saída da API

[tool.poetry.group.dev.dependencies]
pytest = "*"
pytest-cov = "*"
ruff = "*"
taskipy = "*"
```

Removidos: `sqlalchemy`, `alembic` (não fazem mais sentido sem CRUD).

### 6.2 — O que o `app.py` do motor de ML faz agora

Um único endpoint focado, sem rotas de negócio de usuários/textos:

```python
from fastapi import FastAPI
from pydantic import BaseModel

app = FastAPI()

class RecommendRequest(BaseModel):
    text_id: int

class RecommendResponse(BaseModel):
    recommendations: list[int]

@app.post('/recomendar', response_model=RecommendResponse)
def recomendar(payload: RecommendRequest):
    # chama a lógica de recommender.py (TF-IDF + KNN)
    ...
```

Esse serviço roda de forma **independente** do PHP — como um segundo processo (`task run` no Python, `php -S` ou Apache/XAMPP no PHP).

---

## 7️⃣ O Contrato de API entre PHP e Python (atualizado)

A mecânica é a mesma que já estava planejada com a Viola — só quem chama muda de linguagem:

**PHP envia (via Guzzle):**
```json
POST http://localhost:8000/recomendar
{ "text_id": 5 }
```

**Python responde:**
```json
{ "recommendations": [12, 7, 23] }
```

Exemplo de chamada no PHP (`src/Services/MlClient.php`):
```php
$client = new \GuzzleHttp\Client();
$response = $client->post($_ENV['ML_ENGINE_URL'] . '/recomendar', [
    'json' => ['text_id' => $textId]
]);
$data = json_decode($response->getBody(), true);
```

---

## 8️⃣ Passo a Passo da Migração (ordem recomendada)

### Semana 1 — Preparação
- [ ] Comunicar a mudança para Viola e João (a arquitetura de 3 camadas continua, só a linguagem do meio muda)
- [ ] Atualizar `plano-igor-daniel-backend.md` — trocar seção de stack de FastAPI/SQLAlchemy para PHP/Slim
- [ ] Criar `db/schema.sql` com as tabelas `users` e `texts` (fonte de verdade)
- [ ] Abrir uma Issue "Migrar back-end de Python para PHP" e quebrar em sub-tarefas

### Semana 2 — Estrutura PHP
- [ ] Instalar PHP, Composer, criar o projeto Slim em `backend-php/`
- [ ] Configurar `.env` e conexão com MySQL
- [ ] Rodar `db/schema.sql` no banco local
- [ ] Criar rota de teste (`GET /health`) para validar que o Slim está rodando

### Semana 3 — Portar o que existia
- [ ] Recriar o modelo `User` em PHP (Eloquent ou PDO)
- [ ] Implementar cadastro/login (o que seria o próximo passo natural no FastAPI também)
- [ ] Criar o `MlClient.php` (ainda sem o motor do outro lado pronto, pode mockar a resposta)

### Semana 4 — Enxugar o Python
- [ ] Remover SQLAlchemy/Alembic do `pyproject.toml` do motor de ML
- [ ] Renomear (opcional) `stanza_api/` → `ml-engine/`
- [ ] Ajustar `app.py` para focar só no endpoint de recomendação
- [ ] Commitar as mudanças com `refactor: reduce python service to ML engine scope`

### Depois — retomar o cronograma normal
A partir daqui, o cronograma dos Meses 3–6 do `plano-de-acao.md` continua válido, só que os endpoints de CRUD (publicar texto, listar feed) agora são construídos em PHP em vez de Python.

---

## 9️⃣ Impacto nos Documentos Existentes

| Documento | Ação necessária |
|---|---|
| `plano-igor-daniel-backend.md` | Atualizar seção de stack (§2) e decisão estratégica (§3) — PHP/Slim no lugar de Python/Flask/FastAPI |
| `plano-viola-ml.md` | Pouco impacto — o contrato de API muda de "consumido por Python" para "consumido por PHP", mas a Viola continua construindo o motor em Python normalmente |
| `plano-joao-frontend.md` | Nenhum impacto direto — o frontend consome a mesma API HTTP, não importa a linguagem por trás |
| `CONTRIBUTING.md` | Nenhuma mudança — o padrão de commits é agnóstico de linguagem |
| Labels do GitHub | `backend-db` continua válida; pode-se adicionar uma label `php` se quiserem diferenciar Issues por linguagem, mas não é obrigatório |

---

## 🔟 Por Que Essa Migração é Barata Agora

Vale reforçar: como o projeto ainda está na fase de configuração de ambiente (nenhum endpoint de negócio foi implementado em Python), essa é a **hora mais barata possível** para trocar de linguagem. Se a exigência do PHP tivesse vindo depois do CRUD completo estar pronto em Python, a migração seria ordens de magnitude mais trabalhosa. O timing, embora inconveniente, é o melhor cenário possível dentro de um pivô de arquitetura.

---

*Documento alinhado ao planejamento geral do StanzAI — VortexCompilers.*
