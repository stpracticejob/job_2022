<?php

function run_route($name) {
    $response = require "$_SERVER[DOCUMENT_ROOT]/routes/$name.php";
    
    echo json_encode($response);
}
