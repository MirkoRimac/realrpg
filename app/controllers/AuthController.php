<?php

require_once "../app/models/User.php";

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
            session_start();
            $_SESSION["user_id"] = $user["id"];
            header("Location: ?controller=dashboard&action=index");
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
        header("Location: ?controller=dashboard&action=index");
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header("Location: ?controller=auth&action=login");
    }
}