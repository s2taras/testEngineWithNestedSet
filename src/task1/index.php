<?php

require_once "./vendor/autoload.php";

use Task1\Controller\FrontController;

session_start();

$parameters = [
    'session'        => &$_SESSION['loggined'],
    'attempts'       => &$_SESSION['attempts'],
    'ban_time'       => &$_SESSION['ban_time'],
    'username'       => $_REQUEST['username'],
    'password'       => $_REQUEST['password'],
    'request_uri'    => $_SERVER['REQUEST_URI'],
    'request_method' => $_SERVER['REQUEST_METHOD'],
];

$frontController = new FrontController();
$frontController->run($parameters);
