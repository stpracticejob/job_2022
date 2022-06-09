from flask_script import Manager

import config
from app import create_app
from flask_cors import CORS


app = create_app()
CORS(app)
app.config.from_object(config.Config)
manager = Manager(app)

if __name__ == '__main__':
    manager.run()
