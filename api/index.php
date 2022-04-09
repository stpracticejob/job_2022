<?php
require_once "$_SERVER[DOCUMENT_ROOT]/../auth/auth.inc.php";
require_once "$_SERVER[DOCUMENT_ROOT]/../db/dal.inc.php";
require_once "$_SERVER[DOCUMENT_ROOT]/inc/functions.php";

$request = $_SERVER['REQUEST_URI'];
$base_request = $request;

if ($pos = strpos($base_request, '?')) {
    $base_request = substr($base_request, 0, $pos);
}

if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');
}

switch ($base_request) {
    case '/':
    case '':
        run_route('index');
        break;
    case '/cvs':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            run_route('cvs/create');
        } else {
            run_route('cvs/index');
        }
        break;
    case '/cv':
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            run_route('cvs/delete');
        } else {
            run_route('cvs/get');
        }
        break;
    default:
        http_response_code(404);
        run_route('404');
        break;
}