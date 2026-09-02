
from contextlib import asynccontextmanager
from fastapi import FastAPI

from app.faiss_index import carregar_indice, save_index
from app.routes import search


@asynccontextmanager
async def lifespan(app: FastAPI):  
    print("trying to load index...") 
    app.state.index = carregar_indice()
    print("index loaded successfully")


    yield

    #save the index before shutting down the application
    save_index(app.state.index)


app = FastAPI(
    title="Embeddings API",
    lifespan=lifespan,
)

app.include_router(search.router)