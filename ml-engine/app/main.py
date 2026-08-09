
from contextlib import asynccontextmanager
from fastapi import FastAPI

from app.faiss_index import carregar_indice, save_index
from app.routes import search


@asynccontextmanager
async def lifespan(app: FastAPI):  
    print("tentano carregar o indice socorro") 
    app.state.index = carregar_indice()
    print("deu certo :)")


    yield

    #salva o index antes de encerrar a aplicação
    save_index(app.state.index)


app = FastAPI(
    title="Embeddings API",
    lifespan=lifespan,
)

app.include_router(search.router)