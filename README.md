Сайт поиска работы
------------------

1. Установка менеджера пакетов PHP composer:

Скачать с сайта https://getcomposer.org/Composer-Setup.exe файл и запустить.

2. Установка библиотек проекта:

    composer install

3. Для удобства сделаны следующие команды:

Отформатировать код PHP во всем проекте:

    composer fix


Запустить сервер HTTP для отладки по адресу http://localhost:8000 :

    composer dev


Запустить сервер HTTP для отладки API по адресу http://localhost:9000 :

    composer api

Установить библиотеки для Swagger UI:

    cd swagger-ui
    npm install

Запустить Swagger UI:

    cd swagger-ui
    npm start
