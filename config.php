<?php

    $DSN = $_ENV['DSN'] ?? 'mysql:host=localhost;dbname=db_job;charset=utf8;';
    $DB_USER = $_ENV['DB_USER'] ?? 'root';
    $DB_PASSWORD = $_ENV['DB_PASSWORD'] ?? '';
    $DB_OPTIONS = $_ENV['DB_OPTIONS'] ?? [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'];
    $DEBUG = isset($_ENV['DEBUG']) && $_ENV['DEBUG'] == 'true';
