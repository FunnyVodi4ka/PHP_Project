<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once ($_SERVER['DOCUMENT_ROOT'].'/config/links.php');

require $linkToRouter;
$allRoutes = require $linkToRoutes;

$router = new Router($_SERVER['REQUEST_URI']);
$router->startRoute($allRoutes);
