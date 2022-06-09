from datetime import datetime

from app.database import db


class Role(db.Model):
    """Класс прелставления таблицы ролей пользователей"""
    __tablename__ = 'user_roles'
    id = db.Column('ID', db.Integer, primary_key=True)
    name = db.Column('Name', db.String(300))


class User(db.Model):
    """Класс прелставления таблицы пользователей"""
    __tablename__ = 'users'
    id = db.Column('ID', db.Integer, primary_key=True)
    name = db.Column('UserName', db.String(300))
    login = db.Column('Login', db.String(300))
    password = db.Column('Password', db.String(300))
    role_id = db.Column('RoleID', db.Integer, db.ForeignKey('user_roles.ID'))
    role = db.relationship('Role', backref=db.backref('users', lazy=True))
    state = db.Column('State', db.Integer)

    def __repr__(self):
        return '<User %r>' % self.name


class UserMessage(db.Model):
    """Класс прелставления таблицы сообщений пользователей"""
    __tablename__ = 'users_messages'
    id = db.Column('ID', db.Integer, primary_key=True)
    sender_id = db.Column(db.Integer, db.ForeignKey('users.ID'))
    sender = db.relationship('User', foreign_keys=[sender_id], backref=db.backref('sent_messages', lazy=True))
    recipient_id = db.Column(db.Integer, db.ForeignKey('users.ID'))
    recipient = db.relationship('User', foreign_keys=[recipient_id], backref=db.backref('received_messages', lazy=True))
    message = db.Column(db.String(500))
    date_send = db.Column(db.DateTime, default=datetime.now)

    def get_info(self):
        return {
            'id': self.id,
            'message': self.message,
            'sender_id': self.sender_id,
            'recipient_id': self.recipient_id,
            'date_send': self.date_send.strftime("%Y-%m-%dT%H:%M:%S"),
        }
