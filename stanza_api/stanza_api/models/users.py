import enum
from datetime import datetime

from sqlalchemy import Enum, String, func
from sqlalchemy.orm import Mapped, mapped_as_dataclass, mapped_column

from stanza_api.models.base import table_registry


class UserRole(str, enum.Enum):
    AUTHOR = 'author'
    READER = 'reader'


@mapped_as_dataclass(table_registry)
class User:
    __tablename__ = 'users'

    id: Mapped[int] = mapped_column(init=False, primary_key=True)
    name: Mapped[str] = mapped_column(String(255))
    email: Mapped[str] = mapped_column(String(255), unique=True)
    password_hash: Mapped[str] = mapped_column(String(255))
    role: Mapped[UserRole] = mapped_column(
        Enum(UserRole, values_callable=lambda role: [e.value for e in role])
    )
    created_at: Mapped[datetime] = mapped_column(
        init=False, server_default=func.now()
    )
