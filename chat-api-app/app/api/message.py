from datetime import datetime

from flask import Blueprint, request
from flask_api import status
from app.assets.json_handlers import form_response
from app.models import User, UserMessage, db
from pydantic import BaseModel
from app.assets.http_errors import HTTP_ERRORS
from typing import Optional

module = Blueprint('message', __name__, url_prefix='/message')


class SendMessageBody(BaseModel):
    recipient_id: Optional[int]
    recipient_login: Optional[str]
    message: str


@module.route('/', methods=['GET', 'POST', 'OPTIONS'])
def chat_api():
    if request.method == 'OPTIONS':
        return form_response(200, True, '')
    token = request.headers.get('Authorization')
    user: User = User.query.filter_by(id=token).first()
    if not user:
        return form_response(status.HTTP_401_UNAUTHORIZED, False, HTTP_ERRORS['not_auth'])
    if request.method == 'POST':
        try:
            req_body: SendMessageBody = SendMessageBody.parse_raw(request.data)
        except ValueError as error:
            return form_response(status.HTTP_400_BAD_REQUEST, False, HTTP_ERRORS['bad_request'], details=error.errors())
        if req_body.recipient_id:
            recipient: User = User.query.filter_by(id=req_body.recipient_id).first()
        else:
            recipient: User = User.query.filter_by(login=req_body.recipient_login).first()

        if not recipient:
            return form_response(status.HTTP_400_BAD_REQUEST, False, HTTP_ERRORS['bad_user'])
        if recipient.id == user.id:
            return form_response(status.HTTP_400_BAD_REQUEST, False, HTTP_ERRORS['send_self'])
        new_message = UserMessage(sender=user, recipient=recipient, message=req_body.message, date_send=datetime.now())
        db.session.add(new_message)
        db.session.commit()
        return form_response(200, True, '')


@module.route('/<int:recipient_id>', methods=['GET', 'POST', 'OPTIONS'])
def get_message(recipient_id: int):
    if request.method == 'OPTIONS':
        return form_response(200, True, '')
    token = request.headers.get('Authorization')
    user: User = User.query.filter_by(id=token).first()
    if request.method == 'GET':
        messages = UserMessage.query.filter(
            ((UserMessage.recipient_id == recipient_id) & (UserMessage.sender_id == user.id)) |
            ((UserMessage.recipient_id == user.id) & (UserMessage.sender_id == recipient_id))
        ).order_by("date_send")
        result = [message.get_info() for message in messages]
        return form_response(200, True, '', result=result)


@module.route('/recipients', methods=['GET', 'OPTIONS'])
def recipients_api():
    if request.method == 'OPTIONS':
        return form_response(200, True, '')
    token = request.headers.get('Authorization', '')
    user: User = User.query.filter_by(id=token).first()
    if not user:
        return form_response(status.HTTP_401_UNAUTHORIZED, False, HTTP_ERRORS['not_auth'])
    query = """
        SELECT DISTINCT users.UserName as name, recipient_id as id FROM users_messages
        JOIN users ON users_messages.recipient_id = users.ID
        WHERE sender_id = {0}
        UNION
        SELECT DISTINCT users.UserName as name, sender_id as id FROM users_messages
        JOIN users ON users_messages.sender_id = users.ID
        WHERE recipient_id = {1}
        ORDER BY name
    """.format(user.id, user.id)
    results = [{'name': row[0], 'id': row[1]} for row in db.engine.execute(query)]
    return form_response(200, True, '', result=results)
