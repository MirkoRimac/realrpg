<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Shop;

class ShopController extends Controller
{
    public function index(): void
    {
        $shop = new Shop();
        $items = $shop->getAll();

        $this->view("shop/index", ["items" => $items]);
    }

    public function buy()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST")
        {
            $this->redirect("?controller=shop&action=index");
        }

        $userId = $_SESSION["user_id"] ?? null;
        if(!$userId) 
        { 
            $this->redirect("?controller=auth&action=login"); 
        }

        $itemId = (int)$_POST["item_id"] ?? 0;
        $qty = max(1, (int)$_POST["qty"]) ?? 1;

        $shop = new Shop();

        try {
            $shop->buy($userId, $itemId, $qty);
            $_SESSION["flasch_success"] = "Item purchased!";
        }
        catch (\Throwable $e) {
            $_SESSION["flash_error"] = "Purchase failes: " .$e->getMessage();
        }

        $this->redirect("?controller=shop&action=index");
    }
}