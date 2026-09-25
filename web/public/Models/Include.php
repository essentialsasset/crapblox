<?php

/*
    View Autoloader
    Fetches all Views from /Views/
*/

$Models = preg_grep('/^([^.])/', scandir($_SERVER['DOCUMENT_ROOT'] . '/Models/API/'));
include_once($_SERVER['DOCUMENT_ROOT'] . '/Models/API/Base.php');
foreach($Models as $Model) {
    include_once($_SERVER['DOCUMENT_ROOT'] . '/Models/API/' . $Model);
}
