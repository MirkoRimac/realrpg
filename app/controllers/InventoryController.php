<?php

require_once "../app/models/Inventory.php";
require_once "../app/models/User.php";
require_once "../app/models/Shop.php";

class InventoryController extends Controller
{
    public function index()
    {
        $user_id = $_SESSION["user_id"];
        $inventoryModel = new Inventory();
        $inventory = $inventoryModel->getAll($user_id);

        $inventoryModel = new Inventory();
        $items = $inventoryModel->getByUser($user_id);

        $this->view("inventory/index", [
            "inventory" => $inventory,
            "items" => $items
        ]);
    }
}