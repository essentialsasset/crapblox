<?php
require($_SERVER['DOCUMENT_ROOT'] . "/Lib/Configuration.php");
require($_SERVER['DOCUMENT_ROOT'] . "/Lib/Base.php");
require($_SERVER['DOCUMENT_ROOT'] . "/Models/Include.php");
require('../../app/vendor/autoload.php');

$Configurator = new Crapblox\Configurator();
$Base         = new Crapblox\Base();
$Router       = new \Bramus\Router\Router();

/* 
    CRAPBLOX Routes (Api)
    (eg. https://crapblox.com/API/*)
*/ 

$Router->All('/API/Auth/Register', "\Crapblox\Models\Auth\User@CreateUser");
$Router->All('/API/Auth/Signin',   "\Crapblox\Models\Auth\User@SigninUser");

$Router->run();

/*
    // Test

    $c = new Crapblox\Views\Homepage;
    $c->View();
*/