<?php

class Shop extends Model
{
    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM items");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buy($userId, $itemId, $qty)
    {
        // Prüfe Preis
        $stmt = $this->pdo->prepare("SELECT price from items WHERE id = ?");
        $stmt->execute([$itemId]);
        $price = $stmt->fetchColumn();
        $total = $price * $qty;

        // Gold Abbuchen, wenn genug da ist
        $stmt = $this->pdo->prepare("UPDATE users set gold = gold - :t WHERE id = :u AND gold >= :t");
        $stmt->execute([":t" => $total, ":u" => $userId]);
        if ($stmt->rowCount() !== 1)
        {
            echo "<h1>Not enough gold!</h1>";
        }
        else
        {

            
            // Update Inventory
            $stmt = $this->pdo->prepare(
                    "INSERT INTO user_inventory (user_id, item_id, qty)
                VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE qty = qty + VALUES(qty)
                ");
            $stmt->execute([$userId, $itemId, $qty]);

            // Add to transactions
            $stmt = $this->pdo->prepare(
                "INSERT INTO transactions (user_id, item_id, qty, price_each, total, type)
                VALUES (?, ?, ?, ?, ?, 'buy')
                ");
            $stmt->execute([$userId, $itemId, $qty, $price, $total]);
        }

    }

    // public function buy($userId, $itemId, $qty)
    // {
    //     $this->pdo->beginTransaction();
    //     try {
    //         // 1) Item-Preis sperren
    //         $stmt = $this->pdo->prepare("SELECT price FROM items WHERE id = ? FOR UPDATE");
    //         $stmt->execute([$itemId]);
    //         $price = $stmt->fetchColumn();
    //         if ($price === false) {
    //             throw new RuntimeException('Item not found.');
    //         }
    //         $price = (int)$price;
    //         $total = $price * $qty;

    //         // 3) Gold abbuchen (nur wenn genug da ist)
    //         $stmt = $this->pdo->prepare("UPDATE users SET gold = gold - :t WHERE id = :u AND gold >= :t");
    //         $stmt->execute([':t' => $total, ':u' => $userId]);
    //         if ($stmt->rowCount() !== 1) {
    //             throw new RuntimeException('Not enough gold.'); // Race-Condition abgesichert
    //         }

    //         // 4) Inventory upsert
    //         $stmt = $this->pdo->prepare("INSERT INTO user_inventory (user_id, item_id, qty)
    //             VALUES (?, ?, ?)
    //             ON DUPLICATE KEY UPDATE qty = qty + VALUES(qty)
    //         ");
    //         $stmt->execute([$userId, $itemId, $qty]);

    //         // 5) Ledger schreiben
    //         $stmt = $this->pdo->prepare("INSERT INTO transactions (user_id, item_id, qty, price_each, total, type)
    //             VALUES (?, ?, ?, ?, ?, 'buy')
    //         ");
    //         $stmt->execute([$userId, $itemId, $qty, $price, $total]);

    //         var_dump($userId, $itemId, $qty, $price, $total);

    //         $this->pdo->commit();
    //     } catch (\Throwable $e) {
    //         $this->pdo->rollBack();
    //         throw $e;
    //     }
    // }
}