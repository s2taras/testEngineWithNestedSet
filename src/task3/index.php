<?php

require_once "./vendor/autoload.php";

use Task3\Controller\ShopController;

$page = (int)($_REQUEST['page'] ?? 1);

$frontController = new ShopController();
$frontController->index($page);