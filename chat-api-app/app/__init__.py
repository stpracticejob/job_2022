from flask import Flask

import config
from .models import db


def create_app():
    app = Flask(__name__)
    app.config.from_object(config.Config)

    db.init_app(app)
    with app.test_request_context():
        db.create_all()

    from app.api import ping
    from app.api import message

    app.register_blueprint(ping.module)
    app.register_blueprint(message.module)

    return app
