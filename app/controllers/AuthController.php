<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
        $this->view("auth/login");
    }

    public function doLogin()
    {
        $userModel = new User();
        $user = $userModel->findByEmail($_POST["email"]);

        if ($user && password_verify($_POST["password"], $user["password"]))
        {
            $_SESSION["user_id"] = $user["id"];
            $this->redirect("?controller=dashboard&action=index");
        }
        else
        {
            $this->view("auth/login", ["error" => "Ungültige Zugangsdaten"]);
        }
    }

    public function register()
    {
        $this->view("auth/register");
    }

    public function doRegister()
    {
        $userModel = new User();
        $userModel->create($_POST["username"], $_POST["email"], $_POST["password"]);

        $user = $userModel->findByEmail($_POST["email"]);
        
        $_SESSION["user_id"] = $user["id"];

        $this->redirect("?controller=avatar&action=create");
    }

    public function logout()
    {
        session_destroy();
        $this->redirect("?controller=home&action=index");
    }
}