<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Journal extends Model 
{
    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM journals");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function store($userId, $title, $description)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO journals (user_id, title, description, is_active, created_at)
            VALUES (?, ?, ?, 0, NOW())"
        );
        $stmt->execute([
            $userId,
            $title,
            $description
        ]);
    }

    public function getActiveByUser($userId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM journals WHERE user_id = ? AND is_active = 1");
        $stmt->execute([$userId]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results ?: []; // ← Niemals NULL!
    }

    public function getInactiveByUser($userId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM journals WHERE user_id = ? AND is_active = 0");
        $stmt->execute([$userId]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results ?: []; // ← Niemals NULL!
    }

    public function updateStatus($id, $isActive)
    {
        $stmt = $this->pdo->prepare("UPDATE journals SET is_active = ? WHERE id = ?");
        $stmt->execute([$isActive, $id]);
    }

    public function getById($journalId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM journals WHERE id = ?");
        $stmt->execute([$journalId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}