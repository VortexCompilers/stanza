from fastapi import APIRouter, Request
import numpy as np

from sentence_transformers import SentenceTransformer

from app.config import MODEL_NAME
from app.models import (
    AddRequest, AddResponse,
    SearchRequest, SearchResponse, SearchResultItem,
)
from app.database import salvar_embedding

router = APIRouter()

# MODELAO
model = SentenceTransformer(MODEL_NAME)


@router.post("/add", response_model=AddResponse)
def add_item(item: AddRequest, request: Request):
    index = request.app.state.index

    embedding = model.encode([item.texto]).astype(np.float32)
    index.add_with_ids(embedding, np.array([item.id], dtype=np.int64))

    salvar_embedding(item.id, embedding[0].tobytes())

    return AddResponse(status="ok", id=item.id)


@router.post("/search", response_model=SearchResponse)
def search(req: SearchRequest, request: Request):
    index = request.app.state.index

    embedding = model.encode([req.query]).astype(np.float32)
    distances, ids = index.search(embedding, req.k)

    resultados = [
        SearchResultItem(id=int(i), score=float(d))
        for i, d in zip(ids[0], distances[0])
        if i != -1  # FAISS retorna -1 quando não há resultado suficiente
    ]

    return SearchResponse(results=resultados)