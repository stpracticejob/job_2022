Сайт поиска работы
------------------

1. Установка менеджера пакетов PHP composer:

Скачать с сайта https://getcomposer.org/Composer-Setup.exe файл и запустить.

2. Установка библиотек проекта:
```
composer install
```
3. Для удобства сделаны следующие команды:

Отформатировать код PHP во всем проекте:
```
composer fix
```
Запустить сервер HTTP для отладки по адресу http://localhost:8000 :
```
composer dev
```

Запустить сервер HTTP для отладки API по адресу http://localhost:9000 :

    composer api

Установить библиотеки для Swagger UI:

    cd swagger-ui
    npm install

Запустить Swagger UI:

    cd swagger-ui
    npm start


Настройка окружения разработчика
================================

Для настройки окружения разработчика можно воспользоваться пакетным менеджером [chocolate](https://chocolatey.org/).

1. Для установка chocolatey необходимо запустит терминал powershell с администраторскими правами и выполнить последовательно следующие команды:

```powershell
Set-ExecutionPolicy Bypass -Scope Process -Force; 
[System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; 
iex ((New-Object System.Net.WebClient).DownloadString('https://community.chocolatey.org/install.ps1')) 
```
После перезапуска терминала появится команда `choco`.

2. Устанавливаем необходимые инструменты разработчика:
```powershell
choco install git php composer mariadb nodejs
```    
Затем перезапускаем терминал.

3. Генерируеи м настраиваем открыты и закрытый ключ для ssh:
```
TODO
```
4. Клонируем репозитарий проекта и переходив каталог проекта :
```powershell
git clone git+ssh://github.com/stpractice/job_2022
cd job_2022
```
5. Устанавливаем PHP пакеты необходимые для проекта:
```powershell
composer install
```
6. Разварачиваем дамп базы данных предварительно создав пользователя и базу данных:

TODO

7. Запускаем сервер разработчика на http://localhost:8000
```powershell
composer dev
```
Либо сервер API на http://localhost:9000:
```
composer api
```
8. Установливаем пакеты для Swagger UI и запускаем сервер для него:
```powershell
cd swagger-ui
npm install
npm start
```
9. Делаем свою ветку в репозитарии и даем ей уникальное имя:
```powershell
git checkout -b feature/my-cool-page
```
10. Разрабатываем свою фичу в любом удобном редакторе Visual Studio Code, Vim, Emacs или Notepad++.
11. По ходу работы делаем коммиты в свою ветку:
```powershell
git commit -m "Add some cool stuff" -a
```
12. Для форматирования кода по стандарту (PSR-12](https://www.php-fig.org/psr/psr-12/) выполняем команду и при необходимости коммитим:
```powershell
composer fix
```
13. Когда фича готова, то выталкиваем его на сервер:
```powershell
git push --set-upstream origin feature/my-cool-page
```
14. Переходим на сайт GitHub и создаем PR c описанием того что былоло сделано в это Pull Request.
15. Просим коллегу сделать code review.
16. The END 