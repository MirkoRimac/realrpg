<?php

class Quest extends Model 
{
    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM quests");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function store($userId, $title, $description, $reward, $xp)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO quests (user_id, title, description, reward, xp, is_active, created_at)
            VALUES (?, ?, ?, ?, ?, 0, NOW())"
        );
        $stmt->execute([
            $userId,
            $title,
            $description,
            $reward,
            $xp
        ]);
    }

    public function getActiveByUser($userId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM quests WHERE user_id = ? AND is_active = 1");
        $stmt->execute([$userId]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results ?: []; // ← Niemals NULL!
    }

    public function getInactiveByUser($userId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM quests WHERE user_id = ? AND is_active = 0");
        $stmt->execute([$userId]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results ?: []; // ← Niemals NULL!
    }

    public function updateStatus($id, $isActive)
    {
        $stmt = $this->pdo->prepare("UPDATE quests SET is_active = ? WHERE id = ?");
        $stmt->execute([$isActive, $id]);
    }
}