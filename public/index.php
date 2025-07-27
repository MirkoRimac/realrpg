<?php

require_once "../core/Router.php";
require_once "../core/Controller.php";
require_once "../core/Model.php";

$router = new Router();
$router->handleRequest();