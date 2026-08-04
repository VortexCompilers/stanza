# ML Engine

Recommendation engine for **StanzAI**, a literary community platform connecting independent writers with readers. This service owns the TF-IDF + KNN pipeline: it receives a newly published text from the PHP back-end and returns the IDs of the most similar recommended texts. It does not own users, texts, or any relational data — that lives in `backend-php/`.

## Stack

- **FastAPI** + Uvicorn — thin HTTP layer exposing the recommendation endpoint
- **pandas** / **numpy** — dataset handling and vectorized similarity computation
- **nltk** — PT-BR text preprocessing (stopwords, tokenization)
- **Pydantic** — request/response contract validation
- **Pytest** — testing

## Getting started

Setup steps live in [`CONTRIBUTING.md`](../CONTRIBUTING.md) at the root of the repo.

## Project layout

```
ml-engine/
├── ml_engine/
│   ├── app.py            # FastAPI app instance, /health and /recomendar
│   ├── vectorizer.py      # TF-IDF (planned)
│   ├── recommender.py     # KNN + cosine similarity (planned)
│   └── preprocessing.py   # PT-BR text cleanup, stopwords (planned)
└── tests/
```

## API contract

**PHP back-end sends:**
```json
POST /recomendar
{ "text_id": 5 }
```

**ML engine responds:**
```json
{ "recommendations": [12, 7, 23] }
```

## Running tests

```
poetry run task test
```
