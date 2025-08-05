<?php

class AvatarController extends Controller 
{
    public function create()
    {
        $this->view("avatar/create");
    }

    public function store()
    {
        session_start();
        $userId = $_SESSION["user_id"] ?? null;

        if (!$userId)
        {
            header("Location: ?controller=auth&action=login");
            exit;
        }

        $race = $_POST["race"];
        $class = $_POST["class"];
        $backstory = $_POST["backstory"];
        $skinColor = $_POST["skinColor"];
        $clothesColor = $_POST["clothesColos"];

        require_once "../app/models/User.php";
        $userModel = new User();
        $userModel->updateAvatar($userId, $race, $class, $backstory, $skinColor, $clothesColor);

        header("Location: ?controller=dashboard&action=index");
    }
}