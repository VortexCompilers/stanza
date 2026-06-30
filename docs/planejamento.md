# ✍ Planejamento e Proposta de Plataforma: Portal StanzAI

---

## 1️⃣ Tema da Plataforma

**Comunidade Literária e Machine Learning Customizado:** O projeto foca no desenvolvimento de um ecossistema digital independente onde escritores amadores e leitores se conectam. A plataforma utiliza um motor de Inteligência Artificial próprio (construído do zero pela equipe) para recomendar obras e gerar inteligência de dados para os autores.

---

## 2️⃣ Proposta da Plataforma

* **Objetivo:** Criar um ambiente interativo de publicação e leitura, onde um algoritmo de Machine Learning analisa o perfil de leitura e o conteúdo dos textos para conectar cirurgicamente autores independentes aos seus leitores ideais.
* **O que o usuário encontrará:** Um editor de textos para publicação, um feed de leitura altamente personalizado pela IA e uma seção de gamificação (Arena StanzAI) com quizzes literários.
* **Problema a resolver:** A invisibilidade de escritores independentes na internet e a falta de ferramentas de análise (analytics) que mostrem a eles quem realmente está lendo e engajando com seus textos.
* **Serviços oferecidos:** Hospedagem de textos (poemas, contos, crônicas), sistema de recomendação proprietário baseado em KNN (K-Nearest Neighbors) e painel de análise de dados estratégico exclusivo para os autores da plataforma.

---

## 3️⃣ Público-Alvo

* **Leitores (Consumidores):** Pessoas de todas as idades (foco em 15 a 45 anos) interessadas em descobrir novas vozes literárias fora do mercado editorial tradicional.
* **Escritores Independentes (Criadores/Parceiros):** Autores amadores ou em início de carreira que buscam uma comunidade engajada e insights de valor comercial (dados) sobre como o público interage com suas histórias.

---

## 4️⃣ Conceito Mobile First

* **Modelo de Adaptação:** Desenvolvimento priorizando a visualização e a leitura confortável em dispositivos móveis, utilizando a grade responsiva do Bootstrap.
* **Cuidados Técnicos:** Menus simplificados em formato "drawer", interfaces de leitura sem distrações (clean design) e botões de interação otimizados para o toque da tela.

---

## 5️⃣ Identidade Visual

* **Nome da Empresa:** Stanza.
* **Dados Fictícios:** Avenida 9 de Julho, 3575, Anhangabaú, Jundiaí/SP.
* **Descrição do Logo:** O logotipo apresenta um design minimalista e sofisticado com o nome "stanzai" escrito em fonte cursiva (manuscrita) de cor branca sobre um fundo preto sólido. O detalhe distintivo é uma pena estilizada (caneta-tinteiro) que substitui o ponto da letra "i", inclinada para a direita, simbolizando a união entre a escrita tradicional e a inteligência de dados.
* A paleta de cores da StanzAI foi selecionada para unir a sofisticação tecnológica à tradição literária, garantindo acessibilidade e conforto visual.
* **Azul Profundo (Deep Knowledge) `#1E293B**`: Base para textos longos, rodapés e seções de alta autoridade.
* **Azul Cobalto (AI Precision) `#3B82F6**`: Cor de destaque para botões de ação (CTA), links e elementos impulsionados pelo algoritmo de recomendação.
* **Bege Avelã (Paper Warmth) `#F1F5F9**`: Cor de fundo geral que suaviza a leitura digital e remete ao calor e textura das páginas de papel dos livros.
* **Verde Oliva (Organic Growth) `#64748B**`: Cor de apoio utilizada em títulos secundários e ícones, trazendo sobriedade aos gráficos de dados dos autores.

---

## 6️⃣ Estrutura Inicial e Navegação

**Páginas Principais:**

* **Home (Feed Inteligente):** Vitrine dinâmica onde o algoritmo exibe os textos recomendados especificamente para o perfil de quem está acessando.
* **Comunidade & Catálogo:** Espaço de descoberta geral e interface de criação (editor) onde os usuários publicam suas obras.
* **Arena StanzAI:** Espaço de quizzes e jogos literários (cujos resultados ajudam a alimentar o motor de recomendação).
* **Portal do Autor (Dashboard):** Área restrita para quem publica, exibindo gráficos de visualizações, retenção de leitura e perfil demográfico do seu público.

---

## 7️⃣ Recursos e Stack Tecnológica

* **Motor de Recomendação (Machine Learning):** Criação de um modelo matemático preditivo em Python utilizando o algoritmo KNN (K-Nearest Neighbors) e técnicas de vetorização de texto (TF-IDF) para iterar sobre o banco de textos e recomendar similaridades.
* **Banco de Dados & Back-end:** Persistência de dados das publicações, perfis de usuários e logs de tráfego utilizando SQL, gerenciados por uma arquitetura que integra o sistema web ao modelo de IA.
* **Front-end & UI/UX:** Desenvolvimento visual focado em acessibilidade e retenção (HTML, CSS, JS, Bootstrap), garantindo que a experiência de ler e escrever na plataforma seja fluida e imersiva.    

Aqui está o texto formatado em Markdown, estruturado para ficar visualmente limpo e fácil de ler na sua documentação:

---

## 8️⃣ Divisão Estratégica da Equipe

Para garantir a execução autossuficiente e o alto nível técnico do projeto, as responsabilidades foram divididas conforme as especialidades de cada membro:

* **João (Design, UI/UX e Documentação):** Responsável pela criação das interfaces limpas e imersivas do editor de textos e do feed de leitura, aplicando a identidade visual e garantindo a navegação *Mobile First*. Também atua como líder da documentação acadêmica, traduzindo a complexidade técnica do projeto para a monografia do TCC.
* **Igor Matheus (Engenharia de Machine Learning):** Responsável pelo "cérebro" do StanzAI. Focará na construção do motor de recomendação do zero, lidando com a vetorização dos textos (TF-IDF), treinamento e ajustes do algoritmo KNN, além de criar a interface de comunicação (API interna) entre o modelo matemático e o site.
* **Igor Daniel (Arquitetura, Banco de Dados e Analytics):** Responsável pela infraestrutura lógica e comercial da plataforma. Focará na modelagem do banco de dados relacional (SQL) que sustenta a comunidade, no desenvolvimento do painel de inteligência de dados (*Dashboard Analytics* do Portal do Autor) e na programação das mecânicas da Arena gamificada.