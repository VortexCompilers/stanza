# Guia de Contribuição — Stanza

## Padrão de Commits

Utilizamos commits semânticos baseados no padrão do
[iuricode/padroes-de-commits](https://github.com/iuricode/padroes-de-commits).

| Prefixo | Quando usar |
|---|---|
| `feat` | Novo recurso externo |
| `fix` | Correção de bug |
| `docs` | Mudanças na documentação |
| `raw` | Arquivos de dados, configuração, schema SQL |
| `refactor` | Refatoração sem mudança de funcionalidade |
| `test` | Criação ou alteração de testes |
| `chore` | Configurações gerais, .gitignore, etc |
| `remove` | Exclusão de arquivos ou funcionalidades |
| `frontend` | Mudanças no Front-end |
| `backend` | Mudanças no Back-end |

### Formato
\`\`\`
tipo: descrição curta em inglês - closes #N
\`\`\`

### Exemplos
\`\`\`
raw: create users and texts tables - closes #5
feat: add TF-IDF vectorizer for text recommendations - closes #12
fix: correct foreign key constraint on texts table - closes #8
\`\`\`

### ml-engine tooling (Python)
\`\`\`
lint: faz a checagem de boas práticas do código python
format: executa a formatação do código em relação às convenções de estilo de código
run: executa o servidor de desenvolvimento do FastAPI (só o endpoint de recomendação)
test: executa os testes com pytest de forma verbosa (-vv) e adiciona nosso código como base de cobertura
\`\`\`

### Configurando o motor de ML localmente (Python)

1. Instale as dependências:
   \`\`\`
   cd ml-engine
   poetry install
   \`\`\`
2. Suba o servidor de desenvolvimento:
   \`\`\`
   poetry run task run
   \`\`\`

O motor de ML não acessa o banco diretamente — ele só recebe um `text_id` do back-end PHP e devolve recomendações (ver contrato em `ml-engine/README.md`).

# XAMPP

sudo /opt/lampp/lampp start

sudo /opt/lampp/lampp stop

# ngrok

abrir o link uma vez na máquina da apresentação antes de começar
https://jovial-both-amuck.ngrok-free.dev/stanza/frontend/landing.php

---

## Rodando o projeto completo (site + chat bubble + motor de recomendação)

Os comandos estão separados por sistema: **Linux Mint** (meu PC) e **Windows 11**
(máquina da escola). Escolha a coluna do sistema em que você está.

São três processos no ar ao mesmo tempo:

| Processo | O que serve | Onde |
|---|---|---|
| XAMPP (Apache + MySQL) | `frontend/` + `backend/` + o banco `stanza` | `http://localhost/stanza/` |
| Motor de ML (FastAPI) | `POST /add`, `POST /search` — embeddings + FAISS | `http://127.0.0.1:8000` |
| ngrok | túnel HTTPS público pro agente do Chatvolt alcançar `backend/api/catalog_chatvolt.php` | `https://jovial-both-amuck.ngrok-free.dev/stanza/...` |

O **balão de chat** do Chatvolt em si é carregado de uma CDN (`@chatvolt/embeds`)
e não precisa de nenhum processo local. Só as *respostas sobre o catálogo* do
agente dependem do ngrok + do endpoint com token; sem eles o balão abre do mesmo
jeito, só não enxerga o catálogo.

O repositório precisa ficar dentro do `htdocs` do XAMPP:

- **Linux Mint:** `/opt/lampp/htdocs/stanza`
- **Windows 11:** `C:\xampp\htdocs\stanza`

Os comandos abaixo são rodados a partir dessa pasta (a raiz do repositório).
No Windows, use o **Prompt de Comando (cmd)**, não o PowerShell — o `<` de
redirecionamento de arquivo não funciona no PowerShell.

---

### Setup inicial (uma vez por máquina)

**1. Dependências do motor de ML**

Linux Mint:
```bash
cd ml-engine && poetry install && cd ..
```

Windows 11:
```bat
cd ml-engine
poetry install
cd ..
```

**2. Token da API de catálogo** (usado pelo agente do Chatvolt; está no
`.gitignore` — nunca commite).

Linux Mint:
```bash
cp backend/config/api_token.example.php backend/config/api_token.php
/opt/lampp/bin/php -r "echo bin2hex(random_bytes(24)) . PHP_EOL;"
```

Windows 11:
```bat
copy backend\config\api_token.example.php backend\config\api_token.php
C:\xampp\php\php.exe -r "echo bin2hex(random_bytes(24)) . PHP_EOL;"
```

Cole o valor gerado dentro de `backend/config/api_token.php` (no lugar de
`replace-me-with-a-real-token`) e coloque **o mesmo valor** na HTTP Tool do
agente no Chatvolt, no header `X-API-Key`.

**3. ngrok** — instalar e configurar o authtoken uma vez (igual nos dois
sistemas):
```bash
ngrok config add-authtoken <SEU_AUTHTOKEN>
```

---

### Toda sessão

#### 1. Subir o XAMPP (Apache + MySQL)

O MySQL não sobe sozinho — precisa iniciar os dois.

Linux Mint:
```bash
sudo /opt/lampp/lampp start
```

Windows 11: abrir o **XAMPP Control Panel** e clicar em **Start** no Apache e no
MySQL (ou rodar `C:\xampp\xampp_start.exe`).

#### 2. Carregar o banco (na primeira vez, ou pra zerar pro demo)

Linux Mint:
```bash
/opt/lampp/bin/mysql -u root < db/schema.sql
/opt/lampp/bin/mysql --default-character-set=utf8mb4 -u root stanza < db/seed.sql
```

Windows 11:
```bat
C:\xampp\mysql\bin\mysql.exe -u root < db\schema.sql
C:\xampp\mysql\bin\mysql.exe --default-character-set=utf8mb4 -u root stanza < db\seed.sql
```

#### 3. Subir o motor de recomendação (deixar rodando)

Linux Mint:
```bash
cd ml-engine
poetry run task run
```

Windows 11:
```bat
cd ml-engine
poetry run task run
```

- `poetry run task run` = `fastapi dev app/main.py`, escuta em `127.0.0.1:8000`.
- Docs interativas: `http://127.0.0.1:8000/docs` (dá pra testar o `/search` por
  ali, no botão "Try it out" — mais simples que `curl` no Windows).
- A **primeira** execução baixa o modelo `baai/bge-m3` (~2 GB). Fazer isso com
  antecedência, na máquina da apresentação.
- O índice FAISS é lido/gravado em `ml-engine/index_cache.faiss`.
- Teste rápido no Linux (terminal separado):

  ```bash
  curl -s -X POST http://127.0.0.1:8000/search \
    -H 'Content-Type: application/json' \
    -d '{"query":"clock shop","k":5}'
  ```

#### 4. Subir o ngrok (só pro chat responder sobre o catálogo)

Igual nos dois sistemas, usando o domínio reservado do time:
```bash
ngrok http --url=https://jovial-both-amuck.ngrok-free.dev 80
```
Sem domínio reservado: `ngrok http 80` e copie a URL `https://...` que o ngrok
mostrar.

Na HTTP Tool do agente no Chatvolt, a URL fica
`https://jovial-both-amuck.ngrok-free.dev/stanza/backend/api/catalog_chatvolt.php`
e o header `X-API-Key` é o token do passo 2 do setup. Teste rápido (troque
`SEU_TOKEN` pelo valor real):

```bash
curl -s -H "X-API-Key: SEU_TOKEN" http://localhost/stanza/backend/api/catalog_chatvolt.php
```

#### 5. Abrir o site

`http://localhost/stanza/` (redireciona pra landing page).

---

### Parar

Linux Mint:
```bash
sudo /opt/lampp/lampp stop
```

Windows 11: **Stop** no Apache e no MySQL pelo XAMPP Control Panel (ou
`C:\xampp\xampp_stop.exe`).

Nos dois: fechar com `Ctrl+C` os terminais do `poetry run task run` e do `ngrok`.