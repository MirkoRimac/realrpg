<?php

class Router
{

    public function handleRequest()
    {
        $controller = $_GET["controller"] ?? "quest";
        $action = $_GET["action"] ?? "index";

        $controllerName = ucfirst($controller) . "Controller";
        $controllerFile = "../app/controllers/{$controllerName}.php";

        if(file_exists($controllerFile))
        {
            require_once $controllerFile;
            $controllerObj = new $controllerName();
            if(method_exists($controllerObj, $action))
            {
                $controllerObj->$action();
            }
            else
            {
                echo "Action '$action' nicht gefunden.";
            }
        }
        else
        {
            echo "Controller '$controllerName' nicht gefunden.";
        }
    }
}