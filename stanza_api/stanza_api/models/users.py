import enum
from datetime import datetime

from sqlalchemy import func
from sqlalchemy.orm import Mapped, mapped_as_dataclass, mapped_column

from stanza_api.models.base import table_registry


class UserRole(str, enum.Enum):
    AUTHOR = 'author'
    READER = 'reader'


@mapped_as_dataclass(table_registry)
class User:
    __tablename__ = 'users'

    id: Mapped[int] = mapped_column(init=False, primary_key=True)
    name: Mapped[str]
    email: Mapped[str] = mapped_column(unique=True)
    password_hash: Mapped[str]
    role: Mapped[UserRole]
    created_at: Mapped[datetime] = mapped_column(
        init=False, server_default=func.now()
    )
