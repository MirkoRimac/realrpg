<?php

// if (session_status() !== PHP_SESSION_ACTIVE) { session_start();}

require_once "../app/models/Shop.php";
require_once "../app/models/User.php";

class ShopController extends Controller
{
    public function index()
    {
        $user_id = $_SESSION["user_id"];
        $shopModel = new Shop();
        $items = $shopModel->getAll($user_id);

        $this->view("shop/index", [
            "items" => $items
        ]);
    }

    public function buy()
    {
        $userId = $_SESSION["user_id"] ?? null;
        $itemId = (int)$_POST["item_id"];
        $qty = max(1, (int)$_POST["qty"]);

        $shop = new Shop();
        $shop->buy($userId, $itemId, $qty);

        header("Location: ?controller=shop&action=index");
        
    }
}