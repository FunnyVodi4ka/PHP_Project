<?php
require $_SERVER['DOCUMENT_ROOT'].'/app/Core/Router.php';

$allRoutes = require $_SERVER['DOCUMENT_ROOT'].'/routes/routes.php';

$route = new Router($_SERVER['REQUEST_URI']);

$route->startRoute($allRoutes);