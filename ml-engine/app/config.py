import os
import mysql.connector

# credenciais do xampp
DB_HOST = os.environ.get("DB_HOST", "localhost")
DB_PORT = int(os.environ.get("DB_PORT", 3306))
DB_USER = os.environ.get("DB_USER", "root")
DB_PASSWORD = os.environ.get("DB_PASSWORD", "")
DB_NAME = os.environ.get("DB_NAME", "stanza")

# variáveis do índice e do modelo
EMBEDDING_DIM = 1024
FAISS_INDEX_PATH = os.environ.get("FAISS_INDEX_PATH", "index_cache.faiss")

MODEL_NAME = os.environ.get("MODEL_NAME", "baai/bge-m3")


def get_connection():
  return mysql.connector.connect(
        host=DB_HOST,
        port=DB_PORT,
        user=DB_USER,
        password=DB_PASSWORD,
        database=DB_NAME,
    )