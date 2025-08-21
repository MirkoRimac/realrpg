<?php

namespace App\Models;

use App\Core\Model;

class Home extends Model
{
    public function getFeatures()
    {
        return [
            "Erstelle deinen eigenen Charakter",
            "Erlebe echte Quests im Alltag",
            "Level dich selbst – nicht nur dein Avatar",
        ];
    }
}