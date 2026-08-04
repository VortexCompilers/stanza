## 📅 Plano de Ação StanzAI: Estratégia de 18 Meses

Para garantir um estande de destaque na feira em 6 meses e uma defesa de TCC impecável no final de 18 meses, o cronograma precisa ser dividido entre o **Produto Viável Mínimo (MVP)** e a **Maturidade Acadêmica/Técnica**.

A regra de ouro do gerenciamento de projetos aqui é o paralelismo: enquanto o motor lógico é construído, a interface ganha vida e o modelo de IA é treinado simultaneamente.

---

### 🚀 FASE 1: O Caminho para a Feira (Meses 1 a 6)

**Objetivo:** Levar para a feira um protótipo funcional onde os visitantes possam criar uma conta, publicar um texto curto e receber uma recomendação do algoritmo.

**Meses 1 e 2: Alicerces e Prototipagem**
Nesta etapa, o código final ainda não é o foco, mas sim a estrutura e a lógica.

* **Jonas:** Criação dos *wireframes* (esboços das telas) focando no editor de textos e no feed *Mobile First*. Início do esqueleto da monografia (Introdução e Justificativa).
* **Tadala:** Modelagem do Banco de Dados SQL (tabelas de usuários e textos) e configuração do servidor local.
* **Viola:** Coleta de um *dataset* de testes (cerca de 100 a 200 textos curtos em domínio público ou gerados sinteticamente) para ter massa de dados. Início dos testes com a biblioteca Pandas em Python.

**Meses 3 e 4: O Motor e a Interface (O CRUD ganha vida)**
Aqui o sistema começa a se comunicar.

* **Jonas:** Transformar o design em código visual (HTML, CSS, Bootstrap). Garantir que os botões de publicar e ler estejam responsivos.
* **Tadala:** Programar o Back-end (API) para fazer o meio de campo. O formulário do Jonas precisa salvar o texto com sucesso no banco de dados.
* **Viola:** Aplicar o algoritmo TF-IDF no *dataset* de testes e fazer o K-Nearest Neighbors (KNN) rodar no terminal, retornando os IDs dos textos mais semelhantes.

**Meses 5 e 6: Integração e Preparação para o Evento**
A união das três frentes para criar o "Efeito Uau" na feira.

* **Viola e Tadala:** Criar a rota de comunicação entre o Back-end e o modelo de Machine Learning. O site deve enviar o texto recém-publicado para o Python e receber os textos recomendados de volta.
* **Jonas:** Polimento da Interface do Usuário (UI). Criação do material de apresentação da feira (banners, pitch de vendas, slides explicativos do projeto).
* **O Grande Marco (Mês 6):** Apresentação na Feira de Tecnologia com o sistema rodando.

---

### 📈 FASE 2: Escalabilidade e Negócios (Meses 7 a 12)

**Objetivo:** Transformar o protótipo da feira em uma plataforma robusta, adicionando a gamificação e a inteligência de mercado (Dashboard).

**Meses 7 e 8: Coleta de Dados Reais e Gamificação**

* **Jonas:** Avanço na escrita do TCC (Capítulos de Metodologia e Fundamentação Teórica de UI/UX). Design das telas da Arena StanzAI e do Portal do Autor.
* **Tadala:** Desenvolvimento do sistema de pontuação e quizzes (Arena StanzAI). Estruturação das queries SQL complexas para extrair métricas de leitura.
* **Viola:** Calibragem do modelo KNN com os dados reais coletados durante a feira. Refinamento da vetorização para entender gírias e estilos de escrita amadora.

**Meses 9 a 12: O Portal do Autor (Analytics)**

* **Tadala e Jonas:** Implementação do Dashboard B2B. Conectar os dados brutos de tráfego a bibliotecas de gráficos visuais (como Chart.js) para exibir a retenção de leitura e perfil demográfico.
* **Viola:** Integração dos resultados dos quizzes ao modelo de recomendação para torná-lo ainda mais assertivo (pesos dinâmicos no algoritmo).

---

### 🎓 FASE 3: O Refino Acadêmico (Meses 13 a 18)

**Objetivo:** Congelar o desenvolvimento de novas funções (Code Freeze) e focar na robustez do sistema e na excelência do documento final.

**Meses 13 a 15: Testes e Documentação Técnica**

* **Jonas:** Liderar a união de todos os textos dos membros na monografia final. Formatação nas normas ABNT.
* **Viola:** Escrever o capítulo detalhado sobre a matemática por trás do modelo de recomendação (explicando as escolhas do TF-IDF e do KNN para a banca).
* **Tadala:** Testes de estresse no banco de dados e correção de falhas de segurança no CRUD (prevenção de SQL Injection e validação de dados).

**Meses 16 a 18: Reta Final e Defesa**

* **Todos:** Revisão geral do projeto. Ensaio da apresentação técnica.
* **O Grande Marco (Mês 18):** Defesa do Trabalho de Conclusão de Curso.

---

### 💡 Regras de Ouro para a Equipe

* **Evitem a Síndrome do Escopo Infinito:** Foquem em fazer o CRUD de publicação de textos e o motor de recomendação funcionarem perfeitamente antes de tentar inventar recursos secundários (como chat entre usuários ou sistema de avatares 3D).
* **Controle de Versão (Git/GitHub):** Utilizem repositórios desde o primeiro dia. O Tadala, Jonas e Viola estarão mexendo em partes diferentes que se conectam; o GitHub evitará a perda de código e conflitos de arquivos.
* **Reuniões de Sincronização (Dailies/Weeklies):** Definam um dia da semana (ex: sexta-feira, 30 minutos) apenas para alinharem o que cada um conseguiu fazer e quais bloqueios encontraram.