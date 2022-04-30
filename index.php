<?php

require_once 'vendor/autoload.php';
require_once 'config.php';

error_reporting(E_ALL);

use Flight as Flight;
use Job\Database\DB;
use Job\Auth\User;

Flight::set('flight.log_errors', $DEBUG);
Flight::set('flight.case_sensitive', true);

Flight::register('db', DB::class, [$DSN, $DB_USER, $DB_PASSWORD, $DB_OPTIONS]);
Flight::register('user', User::class);

Flight::view()->set('db', Flight::db());
Flight::view()->set('user', Flight::user());

Flight::map('validate', function ($params) {
    echo "hello $params!";
});

Flight::before('start', function (&$params, &$output) {
    session_start();
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
});

Flight::route('GET|POST|DELETE|OPTIONS /api/cvs/@id:[0-9]+', function ($id) {
    $request = Flight::request();
    $db = Flight::db();

    switch ($request->method) {
        case 'POST':
            $data = $request->data;
            Flight::json($db->updateCv($id, $data->user_id, $data->section_id, $data->title, $data->content, $data->datetime));
            break;

        case 'GET':
            Flight::json($db->fetchCv($id));
            break;

        case 'DELETE':
            Flight::json($db->deleteCv($id));
            break;
    }
});
Flight::route('GET|POST /api/cvs?.+', function () {
    $request = Flight::request();
    $db = Flight::db();

    switch ($request->method) {
        case 'GET':
            Flight::json([
                'draw' => intval($request->query->draw),
                'recordsTotal' => $db->countCv(),
                'recordsFiltered' => 0, // TODO
                'data' => $db->fetchCvs()->fetchAll(PDO::FETCH_ASSOC),
            ]);
            break;

        case 'POST':
            $data = $request->data;
            Flight::json([
                'result' => $db->addCv($data->user_id, $data->section_id, $data->title, $data->content, $data->datetime)
            ]);
            break;
    }
});
//<--Вакансии
Flight::route('GET|POST|DELETE|OPTIONS /api/vacancy/@id:[0-9]+', function ($id) {
    $request = Flight::request();
    $db = Flight::db();

    switch ($request->method) {
        case 'POST':
            $data = $request->data;
            Flight::json($db->updateVacancy($id, $data->user_id, $data->section_id, $data->title, $data->content, $data->salary, $data->experience, $data->is_main, $data->is_partnership, $data->is_remote, $data->datetime));
            break;

        case 'GET':
            Flight::json($db->fetchVacancy($id));
            break;

        case 'DELETE':
            Flight::json($db->deleteVacancy($id));
            break;
    }
});
Flight::route('GET|POST /api/vacancy?.+', function () {
    $request = Flight::request();
    $db = Flight::db();

    switch ($request->method) {
        case 'GET':
            Flight::json([
                'draw' => intval($request->query->draw),
                'recordsTotal' => $db->countCv(),
                'recordsFiltered' => 0, // TODO
                'data' => $db->fetchVacancies()->fetchAll(PDO::FETCH_ASSOC),
            ]);
            break;

        case 'POST':
            $data = $request->data;
            Flight::json([
                'result' => $db->addVacancy($data->user_id, $data->section_id, $data->title, $data->content, $data->salary, $data->experience, $data->is_main, $data->is_partnership, $data->is_remote, $data->datetime)
            ]);
            break;
    }
});
//Вакансии-->
Flight::route('GET /', function () {
    Flight::render('main_page');
});

Flight::route('GET /login', function () {
    Flight::render('auth_user');
});

Flight::route('GET /profile/admin', function () {
    Flight::render('profile/admin');
});


Flight::route('POST /login', function () {
    if (isset($_POST['user_login']) && isset($_POST['user_password'])) {
        $user = Flight::user();

        if (!$user->authUser($_POST['user_login'], $_POST['user_password'])) {
            Flight::render('auth_user', ['error' => 'Неверный логин или пароль']);
        } else {
            Flight::redirect('/');
        }
    }
});

Flight::route('GET /logout', function () {
    $user = Flight::user()->logout();
    Flight::redirect('/');
});


Flight::route('GET /cv', function () {
    Flight::render('cv/index');
});


Flight::route('/edit/vacancy', function () {
    Flight::render('edit/vacancy');
});

Flight::route('GET|POST /edit/vacancy/@id:[0-9]+', function ($id) {
    $request = Flight::request();
    if ($request->method == 'POST') {
        return;
    }
    Flight::render('edit/vacancy', ['id' => $id]);
});


Flight::start();
