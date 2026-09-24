
from contextlib import asynccontextmanager
from fastapi import FastAPI
import faiss
from app.faiss_index import carregar_indice, save_index
from app.routes import search


@asynccontextmanager
async def lifespan(app: FastAPI):  
    print("trying to load index...") 
    app.state.index = carregar_indice()
    id_map = faiss.vector_to_array(app.state.index.id_map)
    print("index loaded successfully")
    app.state.filter_index_dict = {i:book_id for i, book_id in enumerate(id_map)}


    yield

    #save the index before shutting down the application
    save_index(app.state.index)


app = FastAPI(
    title="Embeddings API",
    lifespan=lifespan,
)

app.include_router(search.router)