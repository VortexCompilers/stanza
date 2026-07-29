# Stanza API

Backend for **StanzAI**, a literary community platform connecting independent writers with readers through a recommendation engine built from scratch. This is the piece that owns users, texts, and reading activity, and exposes the REST API the frontend and the ML engine talk to.

## Stack

- **FastAPI** + Uvicorn — REST API
- **SQLAlchemy** + **Alembic** — ORM and database migrations
- **MySQL** — relational database
- **Pydantic Settings** — environment-based configuration
- **Pytest** — testing, against an isolated in-memory SQLite database

## Getting started

Setup steps (installing dependencies, configuring your `.env`, running migrations, starting the dev server) live in [`CONTRIBUTING.md`](../CONTRIBUTING.md) at the root of the repo. Keeping it there instead of duplicating it here means there's one place to update when the workflow changes.

## Project layout

```
stanza_api/
├── app.py          # FastAPI app instance and route registration
├── settings.py     # environment configuration (pydantic-settings)
├── database.py     # SQLAlchemy engine and session dependency
├── models/         # SQLAlchemy models (users, texts, reading_logs)
├── schemas/        # Pydantic request/response schemas
├── routers/        # API route handlers
└── services/       # business logic
```

## Running tests

```
poetry run task test
```

Tests spin up their own in-memory SQLite database per run, so you don't need a MySQL instance up to test the API.
