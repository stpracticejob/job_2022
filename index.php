<?php

require_once 'vendor/autoload.php';

error_reporting(E_ALL);

use Dotenv\Dotenv;
use Flight as Flight;
use Job\Database\DB;
use Job\Auth\User;

Dotenv::createImmutable(__DIR__)->safeLoad();

require_once 'config.php';

Flight::set('flight.log_errors', $DEBUG);
Flight::set('flight.case_sensitive', true);
Flight::set('flight.views.path', __DIR__ . '/views');

Flight::register('db', DB::class, [$DSN, $DB_USER, $DB_PASSWORD, $DB_OPTIONS]);
Flight::register('user', User::class);

Flight::view()->set('db', Flight::db());
Flight::view()->set('user', Flight::user());

Flight::map('validate', function ($params) {
    echo "hello $params!";
});

Flight::map('accessDenied', function () {
    Flight::render('errors/403');
});

Flight::before('start', function (&$params, &$output) {
    session_start();
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
});

Flight::route('GET /api/users/@id:[0-9]+', function ($id) {
    Flight::json(Flight::db()->fetchUser($id));
});

Flight::route('POST /api/users/@id:[0-9]+', function ($id) {
    $data = Flight::request()->data;
    Flight::json(Flight::db()->updateUser($id, $data->username, $data->login, $data->password, $data->roleid, $data->state));
});

Flight::route('DELETE /api/users/@id:[0-9]+', function ($id) {
    Flight::json(Flight::db()->deleteUser($id));
});

Flight::route('OPTIONS /api/users/@id:[0-9]+', function ($id) {
});

Flight::route('GET /api/users?.+', function () {
    $request = Flight::request();
    $db = Flight::db();
    $query = $request->query;

    Flight::json([
        'draw' => intval($query->draw),
        'recordsTotal' => $db->countUsers(),
        'recordsFiltered' => 0,
        'data' => $db->fetchUsers()->fetchAll(PDO::FETCH_ASSOC),
    ]);
});

Flight::route('POST /api/users?.+', function () {
    $request = Flight::request();
    $db = Flight::db();
    $data = $request->data;

    Flight::json([
        'result' => $db->addUser($data->username, $data->login, $data->password, $data->roleid, $data->state)
    ]);
});

Flight::route('GET /api/advertises/@id:[0-9]+', function ($id) {
    Flight::json(Flight::db()->fetchAdvertise($id));
});

Flight::route('POST /api/advertises/@id:[0-9]+', function ($id) {
    $data = Flight::request()->data;
    Flight::json(Flight::db()->updateAdvertise($id, $data->user_id, $data->title, $data->content));
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
        'result' => $db->addAdvertise($data->user_id, $data->title, $data->content)
    ]);
});

Flight::route('GET /api/vacancy/@id:[0-9]+', function ($id) {
    Flight::json(Flight::db()->fetchVacancy($id));
});

Flight::route('POST /api/vacancy/@id:[0-9]+', function ($id) {
    $data = Flight::request()->data;
    Flight::json(Flight::db()->updateVacancy($id, $data->user_id, $data->section_id, $data->title, $data->content, $data->salary, $data->experience, $data->is_main, $data->is_partnership, $data->is_remote));
});

Flight::route('DELETE /api/vacancy/@id:[0-9]+', function ($id) {
    Flight::json(Flight::db()->deleteVacancy($id));
});

Flight::route('OPTIONS /api/vacancy/@id:[0-9]+', function ($id) {
});

Flight::route('GET /api/vacancy?.+', function () {
    $request = Flight::request();
    $db = Flight::db();
    $query = $request->query;

    Flight::json([
        'draw' => intval($query->draw),
        'recordsTotal' => $db->countVacancy(),
        'recordsFiltered' => 0,
        'data' => $db->fetchVacancies()->fetchAll(PDO::FETCH_ASSOC),
    ]);
});

Flight::route('POST /api/vacancy?.+', function () {
    $request = Flight::request();
    $db = Flight::db();
    $data = $request->data;

    Flight::json([
        'result' => $db->addVacancy($data->user_id, $data->section_id, $data->title, $data->content, $data->salary, $data->experience, $data->is_main, $data->is_partnership, $data->is_remote)
    ]);
});

Flight::route('POST /api/cvs/@id:[0-9]+', function ($id) {
    $request = Flight::request();
    $db = Flight::db();

    $data = $request->data;
    Flight::json($db->updateCv($id, $data->user_id, $data->section_id, $data->title, $data->content, $data->datetime));
});

Flight::route('GET /api/cvs/@id:[0-9]+', function ($id) {
    Flight::json(Flight::db()->fetchCv($id));
});

Flight::route('DELETE /api/cvs/@id:[0-9]+', function ($id) {
    Flight::json(Flight::db()->deleteCv($id));
});

Flight::route('OPTIONS /api/cvs/@id:[0-9]+', function ($id) {
});

Flight::route('GET /api/cvs?.+', function () {
    $request = Flight::request();
    $db = Flight::db();

    Flight::json([
        'draw' => intval($request->query->draw),
        'recordsTotal' => $db->countCv(),
        'recordsFiltered' => 0,
        'data' => $db->fetchCvs()->fetchAll(PDO::FETCH_ASSOC),
    ]);
});

Flight::route('POST /api/cvs?.+', function () {
    $request = Flight::request();
    $db = Flight::db();

    $data = $request->data;
    Flight::json([
        'result' => $db->addCv($data->user_id, $data->section_id, $data->title, $data->content)
    ]);
});

Flight::route('GET /', function () {
    Flight::render('main_page');
});

Flight::route('GET /login', function () {
    $user = Flight::user();

    if ($user->isUserAuthorized()) {
        Flight::accessDenied();
        return;
    }

    Flight::render('auth_user');
});

Flight::route('GET /profile/admin', function () {
    Flight::render('profile/admin');
});


Flight::route('POST /login', function () {
    $user = Flight::user();

    if (!$user->isUserAuthorized()) {
        Flight::accessDenied();
        return;
    }

    if (isset($_POST['user_login']) && isset($_POST['user_password'])) {
        if (!$user->authUser($_POST['user_login'], $_POST['user_password'])) {
            Flight::render('auth_user', ['error' => 'Неверный логин или пароль']);
        } else {
            Flight::redirect('/');
        }
    }
});

Flight::route('GET /logout', function () {
    $user = Flight::user();

    if (!$user->isUserAuthorized()) {
        Flight::accessDenied();
        return;
    }

    $user->logout();
    Flight::redirect('/');
});


Flight::route('GET /cv', function () {
    $user = Flight::user();

    if (!$user->isUserAdmin()) {
        Flight::accessDenied();
        return;
    }

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
