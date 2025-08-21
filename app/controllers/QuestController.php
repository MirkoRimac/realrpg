<?php

namespace App\Controllers;

use App\Core\Controller;

use App\Models\Quest;
use App\Models\User;

class QuestController extends Controller
{
    public function index()
    {
        $user_id = $_SESSION["user_id"];

        $questModel = new Quest();
        $quests = $questModel->getActiveByUser($user_id);
        $this->view("quests/index", ["quests" => $quests]);
    }

    public function create()
    {
        if (!isset($_SESSION["user_id"]))
        {
            $this->redirect("?controller=auth&action=login");
            exit;
        }

        $formData = [
            "title" => "",
            "description" => "",
            "reward" => "",
            "xp" => "",
        ];

        $errors = [];

        $this->view("quests/create", [
            "formData" => $formData,
            "errors" => $errors
        ]);
    }

    public function store()
    {
        if (!isset($_SESSION["user_id"])) {
            $this->redirect("?controller=auth&action=login");
            exit;
        }

        // Form-Daten abholen
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $reward = $_POST['reward'] ?? 0;
        $xp = $_POST['xp'] ?? 0;

        // Validierung
        if (empty($title) || empty($description)) {
            die("Titel und Beschreibung sind Pflichtfelder.");
        }

        $userId = $_SESSION["user_id"];

        // Model laden und speichern
        $questModel = new Quest();
        $questModel->store($userId, $title, $description, $reward, $xp);

        $this->redirect("?controller=dashboard&action=index");
        exit;
    }

    public function toggleStatus()
    {
        if (!isset($_POST["quest_id"], $_POST["is_active"]))
        {
            $this->redirect("?controller=dashboard&action=index");
            exit;
        }

        $questId = (int)$_POST["quest_id"];
        $isActive = (int)$_POST["is_active"];

        $questModel = new Quest();
        $questModel->updateStatus($questId, $isActive);

        $this->redirect("?controller=dashboard&action=index");
        exit;
    }

    public function complete()
    {

        $userId = $_SESSION["user_id"];
        $questId = $_GET["id"] ?? null;

        if (!$questId || !$userId) {
            $this->redirect("?controller=dashboard&action=index");
            exit;
        }

        $questModel = new Quest();
        $quest = $questModel->getById($questId);
        $xpReward = $quest["xp"] ?? 0;

        // 1. Quest deaktivieren
        $questModel->updateStatus($questId, 0);

        // 2. XP hinzufügen
        $userModel = new User();
        $user = $userModel->getById($userId);
        $currentXp = $user["xp"];
        $currentLevel = $user["level"];

        $newXp = $currentXp + $xpReward;
        $xpNeeded = xpForNextLevel($currentLevel);

        if ($newXp >= $xpNeeded)
        {
            $newXp -= $xpNeeded;
            $currentLevel++;
        }

        // Nutzer aktualisieren
        $userModel->updateXpAndLevel($userId, $newXp, $currentLevel);

        $this->redirect("?controller=dashboard&action=index");
    }
}