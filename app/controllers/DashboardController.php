<?php

require_once "../app/models/Dashboard.php";
require_once "../app/models/User.php";

class DashboardController extends Controller
{
    public function index()
    {

        $user_id = $_SESSION["user_id"];

        require_once "../app/models/Dashboard.php";
        require_once "../app/models/Quest.php";
        require_once "../app/models/Journal.php";

        $dashboardModel = new Dashboard();
        $dashboard = $dashboardModel->getAll();

        $questModel = new Quest();
        $quests = $questModel->getActiveByUser($user_id);
        $availableQuests = $questModel->getInactiveByUser($user_id);

        $journalModel = new Journal();
        $journals = $journalModel->getActiveByUser($user_id);
        $availableJournal = $journalModel->getInactiveByUser($user_id);

        $userModel = new User();
        $user = $userModel->getById($user_id);

        $this->view("dashboard/index", [
            "dashboard" => $dashboard,
            "quests" => $quests,
            "availableQuests" => $availableQuests,
            "journals" => $journals,
            "availableJournal" => $availableJournal,
            "user" => $user
        ]);
    }

    public function test()
    {
        
    }
}