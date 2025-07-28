<?php

require_once "../app/models/Quest.php";

class QuestController extends Controller
{
    public function index()
    {
        session_start();
        $user_id = $_SESSION["user_id"];

        $questModel = new Quest();
        $quests = $questModel->getActiveByUser($user_id);
        $this->view("quests/index", ["quests" => $quests]);
    }

    public function create()
    {
        $this->view("quests/create");
    }

    public function store()
    {
        $questModel = new Quest();
        $questModel->store($_POST["title"]);
        header("Location: ?controller=quest&action=index");
    }
}