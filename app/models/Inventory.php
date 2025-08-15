<?php

class Inventory extends Model
{
    public function getAll()
    {
        $stmt = $this->pdo->prepare("SELECT * from inventory");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}