<?php

/*
    View Autoloader
    Fetches all Views from /Views/
*/

$Views = preg_grep('/^([^.])/', scandir($_SERVER['DOCUMENT_ROOT'] . '/Views/Web/'));
include_once($_SERVER['DOCUMENT_ROOT'] . '/Views/Web/Base.php');
foreach($Views as $View) {
    include_once($_SERVER['DOCUMENT_ROOT'] . '/Views/Web/' . $View);
}
