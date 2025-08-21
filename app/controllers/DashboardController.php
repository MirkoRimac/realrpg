<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\Dashboard;
use App\Models\Quest;
use App\Models\Journal;

class DashboardController extends Controller
{
    public function index()
    {

        $userId = $_SESSION["user_id"] ?? null;

        if(!$userId)
        {
            $this->redirect("?controller=auth&action?loign");
        }

        // Models instanziieren
        $dashboardModel = new Dashboard();
        $questModel = new Quest();
        $journalModel = new Journal();
        $userModel = new User();

        // Daten laden
        $dashboard = $dashboardModel->getAll();
        $quests = $questModel->getActiveByUser((int)$userId);
        $availableQuests = $questModel->getInactiveByUser((int)$userId);
        $journals = $journalModel->getActiveByUser((int)$userId);
        $availableJournal = $journalModel->getInactiveByUser((int)$userId);
        $user = $userModel->getById((int)$userId);

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
        echo "OK";
    }
}