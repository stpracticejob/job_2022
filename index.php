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

Flight::route('GET /api/advertises/@id:[0-9]+', function ($id) {
    Flight::json(Flight::db()->fetchAdvertise($id));
});

Flight::route('POST /api/advertises/@id:[0-9]+', function ($id) {
    $data = Flight::request()->data;
    Flight::json(Flight::db()->updateAdvertise($id, $data->user_id, $data->title, $data->content, $data->datetime));
});

Flight::route('DELETE /api/advertises/@id:[0-9]+', function ($id) {
    Flight::json(Flight::db()->deleteAdvertise($id));
});

Flight::route('OPTIONS /api/advertises/@id:[0-9]+', function ($id) {
});

Flight::route('GET /api/advertises?.+', function () {
    $request = Flight::request();
    $db = Flight::db();
    $query = $request->query;

    Flight::json([
        'draw' => intval($query->draw),
        'recordsTotal' => $db->countAdvertises(),
        'recordsFiltered' => 0,
        'data' => $db->fetchAdvertises()->fetchAll(PDO::FETCH_ASSOC),
    ]);
});

Flight::route('POST /api/advertises?.+', function () {
    $request = Flight::request();
    $db = Flight::db();
    $data = $request->data;

    Flight::json([
        'result' => $db->addAdvertise($data->user_id, $data->title, $data->content, $data->datetime)
    ]);
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

Flight::route('GET /advertise', function () {
    Flight::render('advertise/index');
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
