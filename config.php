<?php

    $DSN = $_ENV['DSN'] ?? 'mysql:host=localhost;dbname=job;charset=utf8;';
    $DB_USER = $_ENV['DB_USER'] ?? 'root';
    $DB_PASSWORD = $_ENV['DB_PASSWORD'] ?? '1234qwerASDF';
    $DB_OPTIONS = $_ENV['DB_OPTIONS'] ?? [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'];
    $DEBUG = isset($_ENV['DEBUG']) && $_ENV['DEBUG'] == 'true';
    $CHAT_BACKEND_URL = $_ENV['CHAT_BACKEND_URL'] ?? 'http://127.0.0.1:5000';
