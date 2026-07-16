from datetime import datetime

from sqlalchemy import ForeignKey, func
from sqlalchemy.orm import Mapped, mapped_as_dataclass, mapped_column

from stanza_api.models.base import table_registry


@mapped_as_dataclass(table_registry)
class ReadingLog:
    __tablename__ = 'reading_logs'

    id: Mapped[int] = mapped_column(init=False, primary_key=True)
    reader_id: Mapped[int] = mapped_column(ForeignKey('users.id'))
    text_id: Mapped[int] = mapped_column(ForeignKey('texts.id'))
    started_at: Mapped[datetime] = mapped_column(
        init=False, server_default=func.now()
    )
    time_spent_seconds: Mapped[int]
