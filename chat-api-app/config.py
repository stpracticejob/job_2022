"""Конфигурация программного обеспечения."""
import configparser

CONFIG_FILE = 'config.ini'
config = configparser.ConfigParser()
config.read(CONFIG_FILE)

DB_SERVER: str = config.get('DATABASE', 'server')
DB_USER: str = config.get('DATABASE', 'username')
DB_PASSWORD: str = config.get('DATABASE', 'password')
DB_NAME: str = config.get('DATABASE', 'name')


class Config(object):
    DEBUG = True
    CSRF_ENABLED = False
    SQLALCHEMY_DATABASE_URI = f'mysql://{DB_USER}:{DB_PASSWORD}@{DB_SERVER}/{DB_NAME}'
    SQLALCHEMY_TRACK_MODIFICATIONS = False
