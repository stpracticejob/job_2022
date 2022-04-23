<?php

//    if (!$user->isUserEmployer() && !$user->isUserAdmin()) {
//        exit();
//    }

    echo $id;
    $item = $db->fetchVacancy($id);
    var_dump($item);
