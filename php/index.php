<?php

require 'vendor/autoload.php';

require_once 'src/handlers/Request.php';
require_once 'src/routers/Router.php';

use Api\Php\Handler\Request;
use Api\Php\Router\Router;

$request = new Request();

$router = new Router($request);

require_once 'src/routers/routes.php';

$router->route();

