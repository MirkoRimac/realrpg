<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class AvatarController extends Controller 
{
    public function create()
    {
        $this->view("avatar/create");
    }

    public function store()
    {
        $userId = $_SESSION["user_id"] ?? null;

        if (!$userId)
        {
            $this->redirect("?controller=auth&action=login");
            exit;
        }

        $race = $_POST["race"];
        $class = $_POST["class"];
        $backstory = $_POST["backstory"];
        $skinColor = $_POST["skinColor"];
        $clothesColor = $_POST["clothesColos"];

        $userModel = new User();
        $userModel->updateAvatar($userId, $race, $class, $backstory, $skinColor, $clothesColor);

        $this->redirect("?controller=dashboard&action=index");
    }
}