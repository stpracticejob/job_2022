from flask import Blueprint, request
from app.assets.json_handlers import form_response
from app.models import User

module = Blueprint('ping', __name__, url_prefix='/ping')


@module.route('/', methods=['GET'])
def ping_api():
    return form_response(200, True, '')
