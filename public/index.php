<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/routes/router.php';

$routes = require_once($_SERVER['DOCUMENT_ROOT'].'/routes/routes.php');

startRoute($routes);