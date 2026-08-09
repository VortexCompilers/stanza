# app/models.py
from pydantic import BaseModel


class AddRequest(BaseModel):
    id: int
    texto: str


class AddResponse(BaseModel):
    status: str
    id: int


class SearchRequest(BaseModel):
    query: str
    k: int = 20


class SearchResultItem(BaseModel):
    id: int
    score: float


class SearchResponse(BaseModel):
    results: list[SearchResultItem]