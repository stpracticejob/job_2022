Сайт поиска работы
==================

Запуск проекта
--------------

1. Установка менеджера пакетов PHP composer:

    Скачать с сайта https://getcomposer.org/Composer-Setup.exe файл и запустить.

1. Установка библиотек проекта:
    ```
    composer install
    ```
    
1. Для удобства сделаны следующие команды:

    Отформатировать код PHP во всем проекте:
    ```
    composer fix
    ```
    
    Запустить сервер HTTP для отладки по адресу http://localhost:8000 :
    ```
    composer dev
    ```

    Установить библиотеки для Swagger UI:
    ```
    cd swagger-ui
    npm install
    ```
    
    В отедельном терминале запускаем Swagger UI:
    ```
    cd swagger-ui
    npm start
    ```

Настройка окружения разработчика
--------------------------------

Для настройки окружения разработчика можно воспользоваться пакетным менеджером [chocolate](https://chocolatey.org/).

1. Для установка chocolatey необходимо запустить терминал powershell с администраторскими правами и выполнить последовательно следующие команды:

    ```powershell
    Set-ExecutionPolicy Bypass -Scope Process -Force;
    [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072;
    iex ((New-Object System.Net.WebClient).DownloadString('https://community.chocolatey.org/install.ps1'))
    ```
    После перезапуска терминала станет оступна команда `choco`.

1. Устанавливаем необходимые инструменты разработчика:
    ```powershell
    choco install git php composer mariadb nodejs-lts
    ```
    Затем перезапускаем терминал.

1. Генерируем и настраиваем открытый и закрытый ключ для ssh:
    ```powershell
    ssh-keygen
    ```
    Далее все по умолчанию, нажимаем Enter несколько раз.
    
    Вывод на экран содержимого открытого ключа:
    ```
    type ~/.ssh/id_rsa.pub
    ```
    
1. Копируем содержимое файла и добавляем новый SSH-ключ в аккаунт GitHub по адресу https://github.com/settings/keys

1. Клонируем репозитарий проекта и переходим в каталог проекта:
    ```powershell
    git clone git+ssh://github.com/stpractice/job_2022
    cd job_2022
    ```

1. Устанавливаем PHP пакеты необходимые для проекта:
    ```powershell
    composer install
    ```

1. Разварачиваем дамп базы данных предварительно создав пользователя и базу данных:

    Вход без пароля:
    ```powershell
    mysql -uroot
    ```

    Вход с паролем password:
    ```powershell
    mysql -uroot -ppassword
    ```

    Создать базу данных:
    ```sql
    CREATE DATABASE job;
    ```

    Выходим из консоли MySQL:
    ```powershell
    quit
    ```

1. Импортировать таблицы:
    ```powershell
    mysql -uroot job < db_job.sql
    ```

1. Создаем файл настроек окружения
    ```powershell
    cp .env.example .env
    ```
    Если необходимо, изменяем настройки окружения в файле .env

1. Запускаем сервер разработчика на http://localhost:8000
    ```powershell
    composer dev
    ```

1. Установливаем пакеты для Swagger UI и запускаем сервер для него:
    ```powershell
    cd swagger-ui
    npm install
    npm start
    ```

1. Делаем свою ветку в репозитарии и даем ей уникальное имя:
    ```powershell
    git checkout -b feature/my-cool-page
    ```

1. Разрабатываем свою фичу в любом удобном редакторе Visual Studio Code, Vim, Emacs или Notepad++.

1. Добавляем файлы под контроль версий:
    ```
    git add some_file
    ```

1. По ходу работы делаем коммиты в свою ветку:
    ```powershell
    git commit -m "Add some cool stuff" -a
    ```

1. Для форматирования кода по стандарту [PSR-12](https://www.php-fig.org/psr/psr-12/) выполняем команду и при необходимости коммитим:
    ```powershell
    composer fix
    ```

14. Когда фича готова, то выталкиваем его на сервер:
    ```powershell
    git push --set-upstream origin feature/my-cool-page
    ```

1. Переходим на сайт GitHub и создаем PR c описанием того, что было сделано в этом Pull Request.

1. Просим коллегу сделать code review.

Настройка Git для проекта под Windows
=====================================

1. Установка Git на компьютер с помощью [chocolate](https://chocolatey.org/):
    ```
    choco install git.install
    ```

1. Добавление имени и фамилии разработчика в конфигурационный файл:
    ```
    git config --global user.name "Firstname Lastname"
    ```
    Настойки будут хрваниться в файле `%USERPROFILE%\.gitconfig`

1. Добавление e-mail разработчика в конфигурационный файл:
    ```
    git config --global user.email "your_email_here@example.com"
    ```
    Если хотите осьавить свой e-mail приватным, то в [настройках](https://github.com/settings/emails) поставьте галочку "Keep my email addresses private". GitHub выдаст вам технический адрес в виде 123456789+your-login-here@users.noreply.github.com, который можно использовать для работы с GitHub.

1. Добавление настройки для автоматического перезаписывания урлов для клонирования с https://github.com на git://git@github.com:
    ```
    git config --global url."git@github.com:".insteadOf "https://github.com/"
    ```
    Для этой настройки нужно, чтобы git авторизировался на сервере GitHub с помощью закрытого ssh ключа. На данный момент, GitHub не разрешает использовать авторизацию через https и требует настройки ssh подключения с логином `git` и вашим закрытым ssh ключем.

1. Установка настройки перевода строки:
    ```
    git config --global core.autocrlf true
    ```
    По умолчанию в веб проектах принято использовать перевод строки Unix-like (LF). При разработки под Windows необходимо, чтобы при комитах перевод строки из Windows-like (CRLF) преобразовывался в Unix-like (LF).

1. Создание открытого и закрытого ключа:
    ```
    ssh-keygen -t rsa -C "your_email@example.com"
    ```
    После запуска эта команда попросит ввести название файла для ключей. Если на запрос имени файла нажать клавишу <Ввод>, то будут созданы файлы по умолчанию с именами `id_rsa` и `id_rsa.pub` для закрытого и открытого ключа соответственно. Затем команда два раза спросит пароль для закрытого ключа, который надо обязательно задать, так как если этот файл утекет в сеть, то вы можете поставить под угрозу свой проект, фирму и своих коллег. Пароль вводить обязательно!!! Желательно, чтобы пароль был больше 8 символов и содержал буквы, цифры и другие знаки препинания. Пароль не должен быть взят из словаря. Созданые файлы будут находиться в домашнем каталоге пользователя в папочке `%USERPROFILE%\.ssh`.

1. Для добавление закрытого ключа в настройки ssh для автоматического использования с сервисами GitHub, перейдите в каталог `%USERPROFILE%\.ssh` и содайте/откройте файл `config`:
    ```
    cd %USERPROFILE%\.ssh
    notepad config
    ```
    И добавте следующие строки:
    ```
    Host github.com
        User git
        IdentityFile ~/.ssh/id_rsa
    ```
1. Добавте открытый ключ на сайт GitHub в настройках по адресу https://github.com/settings/keys. Проверьте, что он нормально доступен на сайте, перейдя по адресу https://github.com/your-login-here.keys. Где `your-login-here` ваш логин на GitHub.

1. Проверяем соединение с GitHub:
    ```
    ssh -T github.com
    ```
    Эта команда запросит пароль от закрытого ключа, а после его ввода соединится с сервером строку подобную этой:
    ```
    Hi <userтname>! You've successfully authenticated, but GitHub does not provide shell access.
    ```
    Если увидите такую строку, значит соединение прошло успешно и вы все правильно настроили.

Настройка ssh-agent
===================

1. Для того, чтобы постоянно не вводить пароль для закрытого ключа, настроим сервис `ssh-agent`, который безопасно сохраняет в памяти пароль для закрытого ключа и автоматически его применяет при соедиении с серверами ssh. Для запуска сервиса ssh-agent выполняем следующую команду:
    ```
    net start ssh-agent
    ```

1. Добавляем закрытый ключ к сервису `ssh-agent`:
    ```
    ssh-add %USERPROFILE%\.ssh\id_rsa
    ```
    Команда запросит пароль к закрытому ключу, который надо ввести. По необходимости можно добавить к сервису другие закрытые ключи. 

1. Проверяем, что закрытый ключ добавился в список ключей сервиса `ssh-agent` и проверяем соединение с сервером GitHub:
    ```
    ssh-add -l
    ssh -T github.com
    ```
    При проверки соединения уже не будет запрашиваться пароль к закрытому ключу. 
    
 1. После работы останавливаем сервис `ssh-agent`:
     ```
     net stop ssh-agent
     ```
     
Разный удобные мелочи для работы с Git
======================================

1. Чтобы не вводить полностью часто употребляемые команды Git можно настроить алиасы.
    ```
    git config --global alias.st "status"
    ```
    После выполнения этой команды, можно будет узнать статус упрощенной командой
    ```
    git st
    ```
    Можно создавать более сложные алиасы. Вот примеры команд для добавления их в настройки:
    ```
    git config --global alias.br "branch"
    git config --global alias.co "checkout"
    git config --global alias.ci "commit"
    git config --global alias.branches "branch -a"
    git config --global undo-last-commit "reset --soft HEAD~1"
    ```

1. Для удобства можно включить цвет в Git командой:
    ```
    git config --global color.ui auto
    ```

1. Для просмотра изменений вашей ветки и ветки `master` можно добавить алиас `diff-master`:
    ```
    git config --global alias.diff-master "diff master..."
    ```

И т.д.
