# Guia de Contribuição — Stanza

## Padrão de Commits

Utilizamos commits semânticos baseados no padrão do
[iuricode/padroes-de-commits](https://github.com/iuricode/padroes-de-commits).

| Prefixo | Quando usar |
|---|---|
| `feat` | Novo recurso |
| `fix` | Correção de bug |
| `docs` | Mudanças na documentação |
| `raw` | Arquivos de dados, configuração, schema SQL |
| `style` | Formatação de código (sem alterar lógica) |
| `refactor` | Refatoração sem mudança de funcionalidade |
| `test` | Criação ou alteração de testes |
| `chore` | Configurações gerais, .gitignore, etc |
| `remove` | Exclusão de arquivos ou funcionalidades |

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

### Configurando o backend localmente (PHP / Slim)

O back-end principal do StanzAI (`backend-php/`) é PHP com o Slim Framework. O motor de recomendação (`ml-engine/`) continua em Python, como um serviço HTTP separado.

1. Instale as dependências:
   \`\`\`
   cd backend-php
   composer install
   \`\`\`
2. Copie `.env.example` para `.env` e preencha com as credenciais do seu MySQL local:
   \`\`\`
   DB_HOST=127.0.0.1
   DB_NAME=stanza
   DB_USER=root
   DB_PASSWORD=
   ML_ENGINE_URL=http://localhost:8000
   \`\`\`
3. Rode `db/schema.sql` no seu MySQL — é a fonte de verdade do banco, não há mais ORM/migrations gerando as tabelas:
   \`\`\`
   mysql -u root -p < ../db/schema.sql
   \`\`\`
4. Suba o servidor de desenvolvimento:
   \`\`\`
   composer start
   \`\`\`
   (ou sirva `backend-php/public/` via Apache do XAMPP, já que o repo vive em `htdocs/`)

O `.env` nunca deve ser commitado (já está no `.gitignore`) — cada membro do time usa suas próprias credenciais locais.

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