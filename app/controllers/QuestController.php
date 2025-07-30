<?php

require_once "../app/models/Quest.php";
require_once "../app/helpers/xp.php";
require_once "../app/models/User.php";

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
        session_start();
        if (!isset($_SESSION["user_id"]))
        {
            header ("Location: ?controller=auth&action=login");
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
        session_start();
        if (!isset($_SESSION["user_id"])) {
            header("Location: ?controller=auth&action=login");
            exit;
        }

        // Form-Daten abholen
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $reward = $_POST['reward'] ?? 0;
        $xp = $_POST['xp'] ?? 0;

        // Optional: Validierung hinzufügen
        if (empty($title) || empty($description)) {
            // später: Fehlerbehandlung
            die("Titel und Beschreibung sind Pflichtfelder.");
        }

        $userId = $_SESSION["user_id"];

        // Model laden und speichern
        require_once "../app/models/Quest.php";
        $questModel = new Quest();
        $questModel->store($userId, $title, $description, $reward, $xp);

        // Weiterleitung z. B. zurück ins Dashboard
        header("Location: ?controller=dashboard&action=index");
        exit;
    }

    public function toggleStatus()
    {
        if (!isset($_POST["quest_id"], $_POST["is_active"]))
        {
            header("Location: ?controller=dashboard&action=index");
            exit;
        }

        $questId = (int)$_POST["quest_id"];
        $isActive = (int)$_POST["is_active"];

        require_once "../app/models/Quest.php";
        $questModel = new Quest();
        $questModel->updateStatus($questId, $isActive);

        header("Location: ?controller=dashboard&action=index");
        exit;
    }

    public function complete()
    {

        session_start();
        $userId = $_SESSION["user_id"];
        $questId = $_GET["id"] ?? null;

        if (!$questId || !$userId) {
            header("Location: ?controller=dashboard");
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

        header("Location: ?controller=dashboard");
    }
}