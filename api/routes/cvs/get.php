<?php

$id = intval($_GET['id'] ?? 0);

if (!$id) {
    return ['error' => 'incorrect id'];
}

return DBGetCV($id);
