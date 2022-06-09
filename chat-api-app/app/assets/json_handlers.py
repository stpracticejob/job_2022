import json

from flask import Response


def form_response(status: int, success: bool, error: str, **kwargs) -> Response:
    """Вернуть ответ сервера в формате JSON.

    :param status: Статус ответа сервера.
    :param success: Выполнен ли доступ к серверу.
    :param error: Сообщение об ошибке.
    :param kwargs: Дополнительные паля ответа.
    :return: Ответ сервера.
    """
    result_dict = dict(**{'success': success, 'error': error}, **kwargs)
    resp = Response(json.dumps(result_dict), status=status, mimetype='application/json')
    resp.headers.set('Access-Control-Allow-Origin', '*')
    resp.headers.set('Access-Control-Allow-Methods', '*')
    resp.headers.set('Access-Control-Allow-Headers', '*')
    resp.headers.set('Access-Control-Max-Age', '1728000')
    return resp
