import os
import faiss
import numpy as np

from app.config import EMBEDDING_DIM, FAISS_INDEX_PATH
from app.database import carregar_todos_embeddings


def criar_indice_vazio():
    """create an empty FAISS index"""
    base = faiss.IndexFlatL2(EMBEDDING_DIM)
    return faiss.IndexIDMap(base)


def carregar_indice():
    """
    Try to load the index. If it doesn't exist, build it from the data bank.
    """
    if os.path.exists(FAISS_INDEX_PATH):
        return faiss.read_index(FAISS_INDEX_PATH)

    index = criar_indice_vazio()
    ids, embeddings = carregar_todos_embeddings()

    if len(ids) > 0:
        index.add_with_ids(embeddings, ids)

    return index

def index_reconstruct():
    """Reconstruct the FAISS index from the database. """
    
    print("=== RECONSTRUINDO FAISS ===")

    index = criar_indice_vazio()

    ids, embeddings = carregar_todos_embeddings()

    print("IDS NO BANCO:", ids)
    print("QUANTIDADE NO BANCO:", len(ids))
    print("SHAPE EMBEDDINGS:", embeddings.shape)

    if len(ids) > 0:
        index.add_with_ids(
            embeddings,
            np.array(ids, dtype=np.int64)
        )

    print("VETORES ADICIONADOS AO FAISS:", index.ntotal)

    save_index(index)

    print("ÍNDICE SALVO:", FAISS_INDEX_PATH)

    return index

# This function is here because if i put it in database.py
# we'll hava a circular import error
def index_update_embedding(index, embedding_id, embedding):
    """Update one embedding in the FAISS index."""

    if index is None:
        index = carregar_indice()
    print("=== ATUALIZANDO EMBEDDING NO FAISS ===")
    # Remove the old embedding if it exists.
    index.remove_ids(
        np.array([embedding_id], dtype=np.int64)
    )
    print("socorro2")

    # Add the new embedding.
    index.add_with_ids(
        embedding,
        np.array([embedding_id], dtype=np.int64)
    )
    print("socorro3")

    save_index(index)


def save_index(index):
    """Save the index to disk."""
    faiss.write_index(index, FAISS_INDEX_PATH)
