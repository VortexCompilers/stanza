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


def save_index(index):
    """Save the index to disk."""
    faiss.write_index(index, FAISS_INDEX_PATH)
