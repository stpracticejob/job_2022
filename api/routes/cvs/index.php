<?php

$section_id = $_GET['section_id'] ?? -1;
$items = [];

_DBFetchQuery(null, ["reset" => 1]);
while ($item = DBFetchCV(-1, $section_id)) {
    $items[] = $item;
}

return $items;
