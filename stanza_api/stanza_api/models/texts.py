from datetime import datetime

from sqlalchemy import ForeignKey, func
from sqlalchemy.orm import Mapped, mapped_as_dataclass, mapped_column

from stanza_api.models.base import table_registry


@mapped_as_dataclass(table_registry)
class Text:
    __tablename__ = 'texts'

    id: Mapped[int] = mapped_column(init=False, primary_key=True)
    author_id: Mapped[int] = mapped_column(ForeignKey('users.id'))
    title: Mapped[str]
    body: Mapped[str]
    created_at: Mapped[datetime] = mapped_column(
        init=False, server_default=func.now()
    )
    genre: Mapped[str]
    read_count: Mapped[int] = mapped_column(init=False, server_default='0')
