from fastapi import APIRouter, Request
import numpy as np
import faiss 
from sentence_transformers import SentenceTransformer
from app.faiss_index import index_update_embedding
from app.config import MODEL_NAME
from app.models import (
    AddRequest, AddResponse,
    SearchRequest, SearchResponse, SearchResultItem, FilteredSearchRequest
)
from app.database import salvar_embedding

router = APIRouter()

# MODEL
model = SentenceTransformer(MODEL_NAME)

@router.post("/add", response_model=AddResponse)
def add_item(item: AddRequest, request: Request):
    index = request.app.state.index

    embedding = model.encode([item.texto]).astype(np.float32)
    
    salvar_embedding(item.id, embedding[0].tobytes())

    index_update_embedding(index, item.id, embedding)

    return AddResponse(status="ok", id=item.id)


@router.post("/search", response_model=SearchResponse)
def search(req: SearchRequest, request: Request):
    
    index = request.app.state.index

    embedding = model.encode([req.query]).astype(np.float32)
    distances, ids = index.search(embedding, req.k)

    results = [
        SearchResultItem(id=int(i), score=float(d))
        for i, d in zip(ids[0], distances[0])
        if i != -1  # FAISS returns -1 when there are no more results, so we filter those out
    ]

    return SearchResponse(results=results)

@router.post("/filteredsearch", response_model=SearchResponse)
def search(req: FilteredSearchRequest, request: Request):

    index = request.app.state.index

    query = model.encode([req.query]).astype(np.float32)

    # book ids after the filter
    filtered_ids = [
        id
        for id in req.ids
        if id in request.app.state.filter_index_dict
    ]

    # books position in the index 
    positions = [
        request.app.state.filter_index_dict[id]
        for id in filtered_ids
    ]

    # takes the needed vectors to the similarity search
    vectors = index.index.reconstruct_batch(
        np.array(positions, dtype=np.int64)
    )

    # creates a temporary index to do the similarity
    filtered_index = faiss.IndexFlatL2(vectors.shape[1])
    filtered_index.add(vectors)

    # searches the query only in this books
    distances, subset_positions = filtered_index.search(
        query,
        min(req.k, len(filtered_ids))
    )

    results = [
        SearchResultItem(id = int(filtered_ids[position]), score=float(distance))
        for position, distance in zip(subset_positions[0], distances[0])
        if position != -1
    ]

    return SearchResponse(results=results)
