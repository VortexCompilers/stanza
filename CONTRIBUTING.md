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

### Backend tooling
\`\`\`
lint: faz a checagem de boas práticas do código python
format: executa a formatação do código em relação às convenções de estilo de código
run: executa o servidor de desenvolvimento do FastAPI
test: executa os testes com pytest de forma verbosa (-vv) e adiciona nosso código como base de cobertura
\`\`\`  