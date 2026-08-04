# CLAUDE.md

Este arquivo fornece orientações ao Claude Code (claude.ai/code) ao trabalhar com o código neste repositório.

## Visão Geral do Projeto

**StanzAI** é uma plataforma de comunidade literária para escritores independentes e leitores (projeto de TCC). A plataforma conecta autores amadores a leitores por meio de um motor de recomendação de ML desenvolvido do zero. É um projeto em equipe (Jonas, Viola, Tadala) com meta de demonstração na feira de tecnologia no Mês 6 e defesa do TCC no Mês 18.

Este repositório está na fase inicial de planejamento. Os documentos de planejamento (`planejamento.md`, `plano-de-acao.md`) definem o escopo completo, papéis da equipe e o roadmap de 18 meses.

## Arquitetura Planejada

Três subsistemas separados que se integram via APIs internas:

**Front-end (João):** HTML, CSS, JavaScript, Bootstrap — Mobile First. Telas principais: feed inteligente, editor/publicador de textos, Arena StanzAI (quizzes literários) e Portal do Autor (analytics).

**Back-end & Banco de Dados (Igor Daniel):** PHP (Slim Framework) — camada de API REST conectando o frontend web ao motor de ML, banco de dados relacional SQL (usuários, textos, logs de tráfego) e queries de analytics do Portal do Autor. Responsável pela prevenção de SQL Injection e validação de dados nas fronteiras do sistema.

**Motor de ML (Viola):** Python, scikit-learn. Serviço HTTP independente, consumido pelo back-end PHP. Pipeline: vetorização TF-IDF dos textos → KNN (K-Nearest Neighbors) para recomendações por similaridade. O modelo recebe o texto recém-publicado do backend e retorna os IDs dos textos recomendados mais similares.

> Mudança de plano (04/08/2026): o back-end principal migrou de Python/FastAPI para PHP/Slim — exigência da disciplina de usar PHP. O Python permanece exclusivamente no motor de ML. Detalhes da migração em `docs/migracao-php-backend.md`.

## Papéis da Equipe

- **João** — Design UI/UX, código frontend, monografia do TCC (redação acadêmica, formatação ABNT)
- **Igor Matheus** — Modelo de ML (TF-IDF + KNN), Python/Pandas, calibração do modelo com dados reais
- **Igor Daniel** — Schema SQL, API backend em PHP (Slim), integração com o motor de ML, analytics do Portal do Autor, gamificação da Arena StanzAI, hardening de segurança

## Stack Técnica

| Camada | Tecnologia |
|---|---|
| Banco de dados | MySQL |
| Backend | PHP, Slim Framework, Eloquent (illuminate/database), Guzzle (cliente HTTP p/ motor de ML), Firebase JWT |
| Backend tooling | Composer (dependências), PHPUnit (testes) |
| Frontend | HTML, CSS, JavaScript, Bootstrap |
| ML Engine | Python, FastAPI (serviço HTTP), scikit-learn/pandas/numpy/nltk (TF-IDF + KNN), Poetry + Ruff + Taskipy + Pytest |

## Decisões de Design Importantes

- O motor de recomendação é construído do zero (sem ML-as-a-service de terceiros) — este é um requisito acadêmico central.
- Os resultados dos quizzes da Arena StanzAI realimentam o modelo KNN como pesos dinâmicos para aumentar a precisão das recomendações ao longo do tempo.
- O Portal do Autor (analytics B2B) usa Chart.js para visualizar retenção de leitura e perfil demográfico.
- O escopo do MVP é intencionalmente restrito: CRUD de publicação de textos + motor de recomendação funcional. Funcionalidades como chat entre usuários ou avatares estão explicitamente adiadas.

## Language

All project work is in English: code, comments, commit messages, branch names, issue titles and bodies, and PR descriptions. This file and planning documents remain in Portuguese (team communication language).

## Comandos de Build / Execução

Nenhum código existe ainda. Os comandos serão adicionados aqui quando a implementação começar (Meses 3–4 conforme o roadmap).

## Apresentação de 14/08/2026 — Orientações do Professor

O professor pediu uma apresentação do andamento do site em 14/08/2026, com os seguintes requisitos visíveis:

- Landing page
- Autenticação (login/cadastro)
- Parte administrativa
- PHP em ação (conteúdo recém-ensinado em aula)

**Sobre o requisito de PHP:** superado pela decisão de arquitetura acima — o PHP não é mais um artefato isolado de demonstração, é o backend real e produtivo do StanzAI (`backend-php/`, Slim Framework). O requisito do professor ("PHP em ação") é atendido pelo próprio fluxo de dados da aplicação.

Priorizar nas próximas duas semanas: landing page, fluxo de autenticação e uma tela administrativa mínima, tudo já no stack principal em PHP (`backend-php/`).

## Paleta de Cores

| Nome | Hex | Uso |
|---|---|---|
| Deep Knowledge | `#1E293B` | Textos corridos, rodapés |
| AI Precision | `#3B82F6` | Botões CTA, links, elementos impulsionados pelo algoritmo |
| Paper Warmth | `#F1F5F9` | Cor de fundo das páginas |
| Organic Growth | `#64748B` | Títulos secundários, ícones de gráficos |
