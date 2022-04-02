<?php

require_once("$_SERVER[DOCUMENT_ROOT]/../db/dbinit.inc.php");

define("EXP_QUERYERR", 2);
define("EXP_NOGROUPID", 3);

function _DBFetch($res)
{
}

function _DBEscString($str)
{
    global $cms_db_link;
    return mysqli_real_escape_string($cms_db_link, $str);
}

function _DBInsertID()
{
    global $cms_db_link;
    return mysqli_insert_id($cms_db_link);
}

function _DBGetQuery($Query)
{
    return mysqli_fetch_array(_DBQuery($Query));
}

function _DBFetchQuery($Query, $options = [])
{
    static $res,$not_first;

    if (isset($options["fetcher_id"])) {
        $res = &$res[$options["fetcher_id"]];
        $not_first = &$not_first[$options["fetcher_id"]];
    } else {
        $res = &$res["default"];
        $not_first = &$not_first["default"];
    }

    if (isset($options["reset"])) {
        $not_first = 0;
        return 0;
    }

    if ($not_first == 0) {
        $res = _DBQuery($Query);
        $not_first = 1;
    }

    if (isset($options["num_rows"])) {
        return mysqli_num_rows($res);
    }

    return mysqli_fetch_array($res);
}

function _DBQuery($Query)
{
    global $cms_db_link;

    $res = mysqli_query($cms_db_link, $Query);
    if (!$res) {
        throw new Exception("ОШИБКА СУБД: [".mysqli_errno($cms_db_link)."] ".mysqli_error($cms_db_link), EXP_QUERYERR);
    }
    return $res;
}

function _DBRowsCount($res)
{
    return mysqli_num_rows($res);
}
