<?php

    require_once("$_SERVER[DOCUMENT_ROOT]/../init.inc.php");
    //Обеспечение доступа к базе данных
    //Попытка подключения к серверу СУБД MySQL
    $cms_db_link = @mysql_connect($cms_connect_host, $cms_connect_login, $cms_connect_password);
    if ($cms_db_link) {
        if (!@mysql_select_db($cms_db_name, $cms_db_link)) { //Если не удалось выбрать указанную БД (например она не существует)
            die("Невозможно выбрать базу данных $cms_db_name");
        } else {
            mysql_query("SET NAMES utf8 COLLATE utf8_general_ci", $cms_db_link);
        }
    } else {
        die("Ошибка соединения с СУБД");
    }
