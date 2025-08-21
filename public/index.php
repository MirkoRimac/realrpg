<?php 

declare(strict_types=1);

require __DIR__ . "/../vendor/autoload.php";

if (session_status() !== PHP_SESSION_ACTIVE) session_start();

$controller = $_GET['controller'] ?? 'home';
$action     = $_GET['action'] ?? 'index';

$controllerClass = "App\\Controllers\\" . ucfirst($controller) . "Controller";

if(!class_exists($controllerClass))
{
    http_response_code(404);
    echo "Controller not found: {$controllerClass}";
    exit;
}

$instance = new $controllerClass;

if(!method_exists($instance, $action))
{
    http_response_code(404);
    echo "Action not found: {$action}";
    exit;
}

$instance->$action();