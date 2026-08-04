from fastapi import FastAPI
from pydantic import BaseModel

app = FastAPI()


@app.get('/health')
def health():
    return {'status': 'OK'}


class RecommendRequest(BaseModel):
    text_id: int


class RecommendResponse(BaseModel):
    recommendations: list[int]


@app.post('/recomendar', response_model=RecommendResponse)
def recomendar(payload: RecommendRequest):
    raise NotImplementedError
