<?php

namespace App\Core;

use PDO;
use PDOException;

class Database 
{
    /*
    public static function connect()
    {
        return new PDO("mysql:host=localhost;dbname=realrpg;charset=utf8", "root", "");
    }
    */


    // Singleton Prinzip
    // Die Klasse merkt sich eine einzige Datenbankverbindung und wird nur einmal erstellt beim ersten Aufruf. Kein ständiges neu Verbinden wie davor

    private static ?PDO $instance = null;

    public static function getInstance(): PDO
    {
        if (self::$instance === null)
        {
            $dsn = "mysql:host=127.0.0.1;dbname=realrpg;charset=utf8mb4";
            $user = "root";
            $pass = "";

            try {
                // ERRMODE_EXCEPTION wirft Fehler als Exceptions aus (gut zum debuggen)
                // FETCH_ASSOC - die DB Ergebnisse werden als assoziative Arrays zurückgegeben statt numerischer Indizes
                self::$instance = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
            } catch(PDOException $e) {
                die("Database Connection failed: " . $e->getMessage());
            }
        }
        return self::$instance;
    }

}