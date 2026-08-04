---
  Princípios Visuais Globais
  Antes das telas, alguns padrões que se repetem em tudo:

  Tipografia (sugestão alinhada à identidade):
  - Títulos e logo: fonte serifada elegante ou a cursiva do logo para elementos de destaque literário
  - Corpo de texto para leitura: serifada (ex: Lora, Merriweather) — remete ao livro impresso
  - Interface e UI (menus, botões, labels): sans-serif limpa (ex: Inter, DM Sans)

  Estrutura de cores por hierarquia:
  - Fundo geral: #F1F5F9 (bege avelã — a "página")
  - Superfícies elevadas (cards, modais): branco #FFFFFF
  - Navegação, rodapé, cabeçalhos de seção: #1E293B (azul profundo — autoridade)
  - Ações e destaques do algoritmo: #3B82F6 (azul cobalto — a IA falando)
  - Textos secundários, ícones, bordas suaves: #64748B (verde oliva)

  Mobile First — regra de ouro:
  - Menu: gaveta lateral (drawer) que desliza da esquerda
  - Cards: sempre empilhados em coluna única no mobile
  - Botões: altura mínima de 48px, fáceis de tocar
  - Tipografia de leitura: no mínimo 18px no corpo

  ---
  Tela 1 — Landing Page (Visitante não autenticado)

  Esta é a porta de entrada. O visitante ainda não tem conta. O objetivo é convencê-lo a se cadastrar.

  Header fixo:
  - Fundo #1E293B. Logo "stanzai" em cursiva branca, com a pena no lugar do ponto do "i", alinhado à esquerda.
  - À direita: botões "Entrar" (ghost button, borda branca) e "Começar agora" (botão sólido #3B82F6).
  - No mobile: apenas o logo e um ícone de menu hambúrguer que abre o drawer.

  Seção Hero (acima da dobra):
  - Fundo #1E293B ocupando 100vh.
  - Lado esquerdo (desktop) ou centralizado (mobile): tagline em fonte serifada grande e branca — algo como "Seus textos merecem os leitores certos." Subtítulo menor em
  #64748B: "Publique, descubra e seja recomendado pela IA que entende literatura."
  - Botão CTA principal: #3B82F6 — "Criar conta gratuita".
  - Lado direito (desktop): mockup animado do feed inteligente, mostrando 2–3 cards de texto flutuando, com o badge "Recomendado para você" em azul — demonstrando o
  produto antes de o usuário se cadastrar.

  Seção Como Funciona:
  - Fundo #F1F5F9. Três colunas (ou cards empilhados no mobile) com ícone + título + descrição curta:
    a. Publique — ícone de pena, texto sobre o editor
    b. A IA aprende — ícone de circuito/estrela, texto sobre o KNN
    c. Conecte-se — ícone de pessoas, texto sobre encontrar leitores

  Seção de Prova Social / Destaques:
  - Fundo branco. Carrossel de textos em destaque (poemas, contos) com foto de capa, nome do autor e trecho. Simula o feed para despertar curiosidade.

  Rodapé:
  - Fundo #1E293B. Endereço fictício (Av. 9 de Julho, 3575, Jundiaí/SP), links de navegação, logo menor. Tudo em tons de #64748B e branco.

  ---
  Tela 2 — Cadastro e Login

  Layout: Página dividida ao meio no desktop. Metade esquerda: fundo #1E293B com o logo grande e uma citação literária de boas-vindas em cursiva. Metade direita: fundo
  branco com o formulário.

  No mobile: apenas o formulário em fundo #F1F5F9, logo centralizado no topo.

  Cadastro: campos de nome, e-mail, senha, e uma seleção de perfil inicial:
  - "Sou leitor" / "Sou escritor" / "Sou os dois" — representados por cards clicáveis com ícone. Essa escolha alimenta o algoritmo desde o primeiro acesso.
  - Botão "Criar conta": #3B82F6, largura total.

  Login: e-mail + senha. Link "Esqueci minha senha" em #3B82F6. Botão "Entrar".

  ---
  Tela 3 — Home: Feed Inteligente (Usuário autenticado)

  Esta é a tela central do produto. Aqui o algoritmo fala.

  Header fixo (logado):
  - Fundo #1E293B. Logo à esquerda. Ao centro: barra de busca discreta (ícone de lupa que expande). À direita: ícone de notificações + avatar do usuário (abre menu
  dropdown com "Meu Perfil", "Portal do Autor", "Sair").
  - Mobile: logo + ícone de busca + avatar. Menu drawer com todos os links de navegação.

  Área Principal — Feed:
  - Fundo #F1F5F9.
  - Saudação personalizada no topo: "Boa tarde, [Nome]. Encontramos isso para você." — em texto médio, #1E293B.
  - Cards de texto empilhados (mobile) ou em grade de 2 colunas (desktop).

  Anatomia de um Card do Feed:
  - Superfície branca, sombra suave (elevation leve), borda-radius de 12px.
  - Topo: badge de categoria/gênero (ex: "Poesia", "Conto") em #64748B + badge "Recomendado pela IA" em #3B82F6 com ícone de estrela — só aparece em itens que o algoritmo  indicou ativamente.
  - Foto de capa opcional (imagem abstrata ou gerada), com proporção 16:9.
  - Título do texto em fonte serifada, bold, #1E293B.
  - Nome do autor clicável em #3B82F6, menor.
  - Trecho de 2–3 linhas em #64748B, fonte serifada, tamanho menor.
  - Rodapé do card: ícone de relógio + "3 min de leitura" | ícone de coração + contador | ícone de bookmark. Todos em #64748B.

  Sidebar (apenas desktop, coluna lateral direita ~280px):
  - Card "Autores em Alta" — lista de 4–5 autores com avatar, nome e gênero.
  - Card "Explorar por Gênero" — pills/tags clicáveis: Poesia, Conto, Crônica, Ficção Científica, etc.
  - Card "Arena StanzAI" — CTA para entrar no quiz do dia, com fundo #1E293B e texto branco.

  ---
  Tela 4 — Tela de Leitura Individual

  O design desta tela determina a retenção de leitura — um KPI direto do Portal do Autor. Deve ser absolutamente limpa.

  Layout:
  - Fundo #F1F5F9 (quente, como papel).
  - Coluna de conteúdo centralizada, largura máxima de 680px, com padding generoso nas laterais.
  - Header minimalista: apenas logo pequeno à esquerda + botão "Voltar" (seta) + ícone de bookmark à direita. Some ao rolar para baixo (hide on scroll).

  Estrutura do conteúdo:
  - Gênero/categoria em pill pequeno: #64748B.
  - Título em fonte serifada grande (32–40px mobile, 48px desktop), #1E293B.
  - Linha de autoria: avatar pequeno + "por [Nome do Autor]" clicável + data de publicação.
  - Tempo estimado de leitura: "4 min de leitura" — em #64748B itálico.
  - Separador sutil (linha #64748B com 20% opacidade).
  - Corpo do texto: fonte serifada, 18–20px, #1E293B, espaçamento de linha 1.8. Parágrafos bem espaçados. Nenhum elemento distrator.

  Barra de progresso de leitura:
  - Barra fina #3B82F6 no topo da tela que avança conforme o scroll. Alimenta as métricas de retenção do Portal do Autor.

  Rodapé do texto (após o fim):
  - Card do autor: avatar maior, bio curta, botão "Seguir".
  - Seção "Você também pode gostar" — 3 cards de recomendação do algoritmo, em formato horizontal (imagem + título + autor). Badge "Recomendado pela IA" em azul.
  - Área de reações: coração, comentário e compartilhar.

  ---
  Tela 5 — Comunidade & Catálogo

  Dividida em duas experiências acessíveis pela mesma rota:

  5A — Catálogo (Descoberta)

  Header da seção:
  - Título "Comunidade" em serifada, #1E293B. Subtítulo em #64748B.
  - Barra de busca proeminente.
  - Filtros em linha (pills): Todos | Poesia | Conto | Crônica | Ficção | Mais recentes | Mais lidos.

  Grade de conteúdo:
  - 3 colunas desktop, 2 colunas tablet, 1 coluna mobile.
  - Cards similares ao Feed, mas sem o badge de IA (aqui é descoberta manual, não recomendação).
  - Paginação ou infinite scroll.

  Banner de CTA para escritores:
  - Bloco #1E293B com texto "Você também escreve? Publique seu texto agora." + botão "Abrir editor" em #3B82F6.

  5B — Editor de Textos (Publicação)

  Acessado pelo botão "Novo texto" no header ou pelo CTA acima.

  Layout do editor — completamente limpo:
  - Fundo branco, sem sidebar.
  - Campo de título: fonte serifada grande, placeholder "Título da sua obra..." — sem borda, apenas uma linha inferior sutil.
  - Campo de corpo: área de texto expansível, mesma tipografia da tela de leitura. Sem distrações.
  - Toolbar minimalista flutuante (aparece ao selecionar texto): negrito, itálico, aspas de citação — apenas o essencial para literatura.
  - Painel lateral recolhível (desktop) ou modal (mobile) para metadados:
    - Gênero/categoria (dropdown)
    - Tags (campo de texto livre)
    - Imagem de capa (upload opcional)
  - Botão "Publicar": #3B82F6, canto superior direito, sempre visível. Ao clicar, abre modal de confirmação mostrando preview do card como ele aparecerá no feed.

  ---
  Tela 6 — Arena StanzAI

  O espaço de gamificação. A identidade visual aqui pode ser um pouco mais vibrante que o resto da plataforma — mantendo o azul cobalto como cor dominante sobre fundos
  escuros.

  Header da seção:
  - Fundo #1E293B com textura sutil (grão de papel ou linhas poéticas em baixo relevo). Título "Arena StanzAI" com a pena no "i". Subtítulo: "Teste seus conhecimentos
  literários e ajude a IA a te conhecer melhor."

  Painel de status do usuário:
  - Card com: pontuação total, nível atual (ex: "Leitor Bronze"), posição no ranking semanal e barra de progresso para o próximo nível. Cores: fundo #1E293B, textos
  brancos, barra de progresso em #3B82F6.

  Cards de Quiz disponíveis:
  - Grade de cards (2 colunas mobile, 3 desktop).
  - Cada card: título do quiz (ex: "Poetas Modernistas"), ícone de categoria, dificuldade (estrelas), pontos a ganhar, botão "Jogar" em #3B82F6.
  - Quizzes já completados: badge "Concluído" em verde + nota obtida.

  Tela do Quiz em andamento:
  - Fundo #1E293B em tela cheia para imersão.
  - Barra de progresso no topo (questão X de Y) em #3B82F6.
  - Pergunta centralizada em branco, fonte serifada grande.
  - 4 alternativas em cards brancos empilhados, clicáveis. Ao selecionar: feedback imediato — verde para certo, vermelho para errado, com explicação breve.
  - Timer opcional (contagem regressiva em círculo no canto).

  Ranking Semanal:
  - Tabela com posição, avatar, nome e pontos. Top 3 com ícones de troféu dourado/prata/bronze.

  ---
  Tela 7 — Portal do Autor (Dashboard Analytics)

  Área restrita, acessada apenas por quem publicou pelo menos um texto. É a proposta de valor B2B — os dados que nenhuma outra plataforma oferece ao escritor amador.

  Sidebar de navegação (desktop) / Tab bar (mobile):
  - Fundo #1E293B. Links: Visão Geral, Meus Textos, Público, Arena.
  - Avatar do autor + nome no topo da sidebar.

  Visão Geral — métricas globais:
  - 4 cards de KPI no topo (2x2 mobile, 4 em linha desktop):
    - Total de Leituras (número grande em #3B82F6)
    - Seguidores
    - Taxa de Retenção Média (% do texto que os leitores completam)
    - Textos publicados
  - Gráfico de linha (Chart.js): leituras ao longo dos últimos 30 dias. Linha #3B82F6, fundo da área sob a linha em azul com 15% opacidade.

  Seção "Meus Textos":
  - Lista de textos publicados com miniatura, título, data de publicação e KPIs rápidos (visualizações, retenção, likes).
  - Ao clicar em um texto: abre painel expandido com análise detalhada.

  Análise por texto — o destaque do produto:
  - Gráfico de Retenção de Leitura (linha): eixo X = progresso no texto (0% a 100%), eixo Y = % de leitores que ainda estão lendo. Mostra exatamente onde as pessoas
  abandonam. Curva #3B82F6.
  - Perfil do Público (rosca/donut — Chart.js): distribuição por faixa etária estimada. Cores da paleta.
  - Heatmap de horários: quando seu texto é mais lido (grade de dias x horas).
  - Seção de feedback: comentários e reações recebidas, exibidos cronologicamente.

  Seção "Meu Público" — visão consolidada de todos os textos:
  - Gráfico de barras: gêneros literários mais lidos pelo seu público.
  - Card: "Seus leitores também curtem..." — 3 outros autores que seu público segue (cruzamento do algoritmo).

  ---
  Resumo Visual por Tela

  ┌─────────────────┬─────────────────────────┬─────────────────────────────────┬─────────────────────────┐
  │      Tela       │     Fundo dominante     │      Elemento de destaque       │        Tom geral        │
  ├─────────────────┼─────────────────────────┼─────────────────────────────────┼─────────────────────────┤
  │ Landing         │ #1E293B (hero)          │ CTA azul cobalto                │ Sofisticado, impactante │
  ├─────────────────┼─────────────────────────┼─────────────────────────────────┼─────────────────────────┤
  │ Login/Cadastro  │ Branco + #1E293B        │ Formulário limpo                │ Acolhedor, simples      │
  ├─────────────────┼─────────────────────────┼─────────────────────────────────┼─────────────────────────┤
  │ Feed (Home)     │ #F1F5F9                 │ Cards brancos, badges azuis     │ Quente, editorial       │
  ├─────────────────┼─────────────────────────┼─────────────────────────────────┼─────────────────────────┤
  │ Leitura         │ #F1F5F9                 │ Tipografia serifada             │ Minimalista, imersivo   │
  ├─────────────────┼─────────────────────────┼─────────────────────────────────┼─────────────────────────┤
  │ Catálogo        │ #F1F5F9                 │ Grade de cards                  │ Descoberta, exploração  │
  ├─────────────────┼─────────────────────────┼─────────────────────────────────┼─────────────────────────┤
  │ Editor          │ Branco puro             │ Área de texto ampla             │ Foco total, limpo       │
  ├─────────────────┼─────────────────────────┼─────────────────────────────────┼─────────────────────────┤
  │ Arena           │ #1E293B                 │ Cards e barra de progresso azul │ Energético, gamificado  │
  ├─────────────────┼─────────────────────────┼─────────────────────────────────┼─────────────────────────┤
  │ Portal do Autor │ Branco + sidebar escura │ Gráficos Chart.js               │ Profissional, analítico │
  └─────────────────┴─────────────────────────┴─────────────────────────────────┴─────────────────────────┘

  ---