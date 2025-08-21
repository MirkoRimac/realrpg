<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Journal;

class JournalController extends Controller
{
    public function index()
    {
        $user_id = $_SESSION["user_id"];

        $journalModel = new Journal();
        $journals = $journalModel->getActiveByUser($user_id);
        $this->view("journals/index", ["journals" => $journals]);
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
        ];

        $errors = [];

        $this->view("journals/create", [
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

        // Optional: Validierung hinzufügen
        if (empty($title) || empty($description)) {
            // später: Fehlerbehandlung
            die("Titel und Beschreibung sind Pflichtfelder.");
        }

        $userId = $_SESSION["user_id"];

        // Model laden und speichern
        $questModel = new Journal();
        $questModel->store($userId, $title, $description);

        // Weiterleitung zurück ins Dashboard
        $this->redirect("?controller=dashboard&action=index");
        exit;
    }

    public function toggleStatus()
    {
        if (!isset($_POST["journal_id"], $_POST["is_active"]))
        {
            $this->redirect("?controller=dashboard&action=index");
            exit;
        }

        $journalId = (int)$_POST["journal_id"];
        $isActive = (int)$_POST["is_active"];

        $journalModel = new Journal();
        $journalModel->updateStatus($journalId, $isActive);

        $this->redirect("?controller=dashboard&action=index");
        exit;
    }
}