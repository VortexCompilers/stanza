from datetime import datetime

from sqlalchemy import ForeignKey, String, func
from sqlalchemy import Text as TextType
from sqlalchemy.orm import Mapped, mapped_as_dataclass, mapped_column

from stanza_api.models.base import table_registry


@mapped_as_dataclass(table_registry)
class Text:
    __tablename__ = 'texts'

    id: Mapped[int] = mapped_column(init=False, primary_key=True)
    author_id: Mapped[int] = mapped_column(ForeignKey('users.id'))
    title: Mapped[str] = mapped_column(String(255))
    body: Mapped[str] = mapped_column(TextType)
    created_at: Mapped[datetime] = mapped_column(
        init=False, server_default=func.now()
    )
    genre: Mapped[str] = mapped_column(String(100))
    read_count: Mapped[int] = mapped_column(init=False, server_default='0')
