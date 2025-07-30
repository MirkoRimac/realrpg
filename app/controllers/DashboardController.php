<?php

require_once "../app/models/Dashboard.php";
require_once "../app/models/User.php";

class DashboardController extends Controller
{
    public function index()
    {
        session_start();
        if (!isset($_SESSION["user_id"]))
        {
            header("Location: ?controller=auth&action=login");
            exit;
        }

        $user_id = $_SESSION["user_id"];

        require_once "../app/models/Dashboard.php";
        require_once "../app/models/Quest.php";

        $dashboardModel = new Dashboard();
        $dashboard = $dashboardModel->getAll();

        $questModel = new Quest();
        $quests = $questModel->getActiveByUser($user_id);
        $availableQuests = $questModel->getInactiveByUser($user_id);

        $userModel = new User();
        $user = $userModel->getById($user_id);

        $this->view("dashboard/index", [
            "dashboard" => $dashboard,
            "quests" => $quests,
            "availableQuests" => $availableQuests,
            "user" => $user
        ]);

        // $this->view("dashboard/index", ["dashboard" => $dashboard]);


        //  // Quest Model laden
        

        // // Daten an die View übergeben
        // $this->view('dashboard/index', ['quests' => $quests]);
    }
}