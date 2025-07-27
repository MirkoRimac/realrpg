<?php

class Quest extends Model 
{
    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM quests");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function store($title)
    {
        // todo: xp auch als prepared statement
        $stmt = $this->pdo->prepare("INSERT INTO quests (title,xp) VALUES (?, 50)");
        $stmt->execute([$title]);
    }
}