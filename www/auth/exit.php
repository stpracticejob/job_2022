<?php

$session_name = session_name();
if (isset($_REQUEST[$session_name]) ||
isset($_COOKIE[$session_name]) ||
isset($_GET[$session_name]) ||
isset($_POST[$session_name])) {
    session_start();
    session_unset();
    $_SESSION = [];
    session_destroy();
}
header("Location: http://$_SERVER[HTTP_HOST]/");
