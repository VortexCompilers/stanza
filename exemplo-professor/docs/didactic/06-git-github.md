# 🧠 Git e GitHub

Git é um sistema de versionamento.

GitHub é uma plataforma utilizada para armazenar projetos Git.

Neste projeto os alunos irão aprender:

- commits;
- push;
- pull;
- branches;
- releases;
- colaboração.

Exemplo:

```bash
git add .
git commit -m "Create responsive navbar"
git push origin beta
```
---

## No GitHub, o controle de versões normalmente aparece de três formas principais:

---

# 1️⃣ Commits

Cada alteração enviada para o repositório gera um commit.

Exemplo visual no GitHub:

```text id="1ly9tw"
Create initial project structure
Add responsive navbar
Implement multilingual system
Fix mobile layout
```

Os alunos verão:

* data;
* autor;
* descrição;
* arquivos alterados.

---

# 2️⃣ Tags / Releases

As versões oficiais aparecem na área de **Releases** do GitHub.

Exemplo:

```text id="v5tjlwm"
v0.1.0-beta
v0.5.0-beta
v1.0.0-rc.1
v1.0.0
```

---

# 📌 Como fica visualmente

Na página do repositório aparecerá algo parecido com:

```text id="6o3r67"
Releases
---------
v1.0.0
Latest
Published today

v1.0.0-rc.1

v0.5.0-beta
```

Isso dá aparência muito profissional ao projeto.

---

# 3️⃣ Branches

Você também pode trabalhar com branches simples.

Exemplo:

| Branch             | Finalidade               |
| ------------------ | ------------------------ |
| `main`             | versão estável           |
| `beta`             | testes e desenvolvimento |
| `feature-delivery` | futuro sistema delivery  |

---

# 📚 Forma simples para os alunos

Eu recomendaria inicialmente:

## ✅ Apenas:

* `main`
* `beta`

Assim fica mais fácil de entender.

---

# 🌳 Fluxo didático simples

## Desenvolvimento

```text id="d9b9iy"
beta
```

## Versão pronta

```text id="evk6p2"
main
```

---

# 🚀 Exemplo prático

## Aluno desenvolve:

```bash id="uc1x8j"
git checkout beta
```

Faz alterações:

```bash id="u0mldc"
git add .
git commit -m "Create multilingual navbar"
git push origin beta
```

---

## Quando estiver estável

Juntar no `main`:

```bash id="4ndvdd"
git checkout main
git merge beta
git push origin main
```

---

# 🏷️ Criando versões (tags)

Depois:

```bash id="6dbr70"
git tag v1.0.0
git push origin v1.0.0
```

No GitHub aparecerá:

* versão;
* histórico;
* arquivos daquela versão.

---

# 📌 Recomendação para este projeto

## Estrutura simples:

| Item     | Uso                |
| -------- | ------------------ |
| `main`   | versão estável     |
| `beta`   | desenvolvimento    |
| Releases | versões publicadas |

---

# 📘 Explicação simples para os alunos

## 🔀 Organização das Branches

Este projeto utiliza duas branches principais:

| Branch | Objetivo                 |
| ------ | ------------------------ |
| `main` | versão estável           |
| `beta` | desenvolvimento e testes |

O desenvolvimento será realizado inicialmente na branch `beta`.

Após os testes e validações, as alterações serão integradas na branch `main`.

---

## 🏷️ Releases

As versões importantes do projeto serão organizadas utilizando:

* tags;
* releases do GitHub.

Exemplo:

```text id="0i4pc0"
v0.1.0-beta
v1.0.0-rc.1
v1.0.0
```

---

Isso já ensina:

* fluxo profissional;
* versionamento;
* estabilidade;
* organização de projeto;
* trabalho colaborativo.
