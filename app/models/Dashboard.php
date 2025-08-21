<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Dashboard extends Model 
{
    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}