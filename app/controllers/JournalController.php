<?php

require_once "../app/models/Journal.php";
require_once "../app/models/User.php";

class JournalController extends Controller
{
    public function index()
    {
        session_start();
        $user_id = $_SESSION["user_id"];

        $journalModel = new Journal();
        $journals = $journalModel->getActiveByUser($user_id);
        $this->view("journals/index", ["journals" => $journals]);
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
        ];

        $errors = [];

        $this->view("journals/create", [
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

        // Optional: Validierung hinzufügen
        if (empty($title) || empty($description)) {
            // später: Fehlerbehandlung
            die("Titel und Beschreibung sind Pflichtfelder.");
        }

        $userId = $_SESSION["user_id"];

        // Model laden und speichern
        require_once "../app/models/Journal.php";
        $questModel = new Journal();
        $questModel->store($userId, $title, $description);

        // Weiterleitung z. B. zurück ins Dashboard
        header("Location: ?controller=dashboard&action=index");
        exit;
    }

    public function toggleStatus()
    {
        if (!isset($_POST["journal_id"], $_POST["is_active"]))
        {
            header("Location: ?controller=dashboard&action=index");
            exit;
        }

        $journalId = (int)$_POST["journal_id"];
        $isActive = (int)$_POST["is_active"];

        require_once "../app/models/Journal.php";
        $journalModel = new Journal();
        $journalModel->updateStatus($journalId, $isActive);

        header("Location: ?controller=dashboard&action=index");
        exit;
    }
}