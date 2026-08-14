FROM python:3.13-slim

WORKDIR /app

COPY Requirements.txt .

# Instala o torch (build CPU) antes do resto para evitar puxar a wheel com CUDA,
# que é muito maior e desnecessária aqui.
RUN pip install --no-cache-dir torch --index-url https://download.pytorch.org/whl/cpu \
    && pip install --no-cache-dir -r Requirements.txt

COPY . .

# Baixa e cacheia o modelo de embeddings durante o build, para não precisar
# baixar da Hugging Face toda vez que o container sobe em uma máquina nova.
RUN python -c "from sentence_transformers import SentenceTransformer; SentenceTransformer('baai/bge-m3')"

ENV FAISS_INDEX_PATH=/app/data/index_cache.faiss
RUN mkdir -p /app/data

EXPOSE 8000

CMD ["uvicorn", "app.main:app", "--host", "0.0.0.0", "--port", "8000", "--workers", "1"]
