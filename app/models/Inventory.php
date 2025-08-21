<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Inventory extends Model
{
    public function getAll($userId)
    {
        $stmt = $this->pdo->prepare("SELECT * from user_inventory WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByUser(int $userId)
    {
        $sql = 
        "   SELECT
                ui.item_id,
                ui.qty,
                i.name,
                i.icon,
                i.rarity,
                i.price,
                i.description
            FROM user_inventory ui
            JOIN items i on i.id = ui.item_id
            WHERE ui.user_id = ?
            ORDER BY i.name
        ";

        $st = $this->pdo->prepare($sql);
        $st->execute([$userId]);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
}