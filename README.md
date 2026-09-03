# ✍️ Welcome to the Stanza Portal

**Your new way to engage with literature.**

For **readers**, Stanza is a digital ecosystem that helps you find the right book.

And if you are an **independent writer**, our recommendation engine helps you find the right audience.

Here, the catalog is not just a list — it **talks to you**.

---

## 🚀 What can you do on Stanza?

* 📚 **Smart Catalog:** Browse the available works intuitively and find exactly what you are looking for.
* 💬 **Talk to our StanzAI:** Our assistant acts as your literary mentor. Discuss works, ask for suggestions based on your mood of the day, or take part in writing challenges.
* 🎮 **StanzAI Arena:** Want to test your knowledge? Step into our arena to answer literary quizzes and join engaging games.

## 📱 Built for your phone

The whole platform was designed Mobile First. That means simplified menus, images that load fast, and a chat interface that is comfortable to use on your smartphone screen, wherever you are.

---

## 🤝 For Bookstores and Marketplaces (B2B Partners)

If you run a bookstore, StanzAI is the bridge between your inventory and the reader's heart.
Our AI acts as a specialist salesperson available 24/7. Once integrated into your system, the bot analyzes your catalog in real time to make accurate recommendations to customers, while generating an **Insights Dashboard** so you can understand your audience's real interests and optimize your sales.

---

## ⚙️ What powers our system?

For the tech-curious, StanzAI is built with cutting-edge tools:
* **Artificial Intelligence:** A chat bubble in the bottom-right corner, ready to help you.
* **Recommendation Engine:** Algorithms in **Python** using a RAG (*Retrieval-Augmented Generation*) architecture to connect the chat directly to the catalog's SQL database.
* **Responsive Front-end:** Clean interfaces and a design focused on the reader's visual comfort.

---

## ▶️ Running the project

**Prerequisites:** XAMPP (Apache + MySQL), with the repository cloned inside the `htdocs/` folder (on Linux, `/opt/lampp/htdocs/stanza`).

**1. Start Apache and MySQL.** On Linux:

```bash
sudo /opt/lampp/lampp start
```

On Windows or macOS, start Apache and MySQL from the XAMPP Control Panel.

**2. Create the database and load the demo data:**

```bash
/opt/lampp/bin/mysql --default-character-set=utf8mb4 -u root < db/schema.sql
/opt/lampp/bin/mysql --default-character-set=utf8mb4 -u root stanza < db/seed.sql
```

`db/schema.sql` is the source of truth for the schema. `db/seed.sql` populates users, texts, and the counters (views and favourites) that feed the StanzAI Tops sections.

**3. Open it in the browser:**

```text
http://localhost/stanza/
```

**Demo login:** `autor@gmail.com` / password `123456`. Every seeded account shares this password, purely for demo convenience.

> The five cover images referenced by `seed.sql` are not tracked by Git and must be copied by hand into `frontend/img/uploads/`. The recommendation engine (`ml-engine/`, Python) and the frozen back-end (`backend-php/`, Slim) run separately and are not required to run the site.

---

## DECLARAÇÃO DE USO DE INTELIGÊNCIA ARTIFICIAL

| Tool | Stage | Purpose | Validation |
|---|---|---|---|
| ChatGPT | Planning | Organizing the planning files and refining ideas | Reviewed and adjusted by the team |
| ChatGPT | Development | Help identifying bugs in the code | Code reviewed, corrected, and tested by the team |
| Claude Code | Development | Help identifying bugs in the code | Code reviewed, corrected, and tested by the team |
