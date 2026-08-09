import numpy as np
from app.config import EMBEDDING_DIM, get_connection

def salvar_embedding(embedding_id, embedding_bytes):
    connection = get_connection()
    cursor = connection.cursor()
    cursor.execute(
        "INSERT INTO embeddings (id, embedding) VALUES (%s, %s) "
        "ON DUPLICATE KEY UPDATE embedding = VALUES(embedding)",
        (embedding_id, embedding_bytes)
    )
    connection.commit()
    cursor.close()
    connection.close()

def carregar_todos_embeddings():
    """Devolve uma lista de tuplas (id, embedding) do bd"""
    connection = get_connection()
    cursor = connection.cursor()
    cursor.execute("SELECT id, embedding FROM embeddings")
    rows = cursor.fetchall()
    cursor.close()
    connection.close()

    if not rows: # se a lista estiver vazia, devolve arrays vazios, int64 por consistência
        return np.array([], dtype=np.int64), np.empty((0, EMBEDDING_DIM), dtype=np.float32)

    ids = np.array([row[0] for row in rows], dtype=np.int64)
    embeddings = np.array(
        [np.frombuffer(row[1], dtype=np.float32) for row in rows]
    )

    return ids, embeddings