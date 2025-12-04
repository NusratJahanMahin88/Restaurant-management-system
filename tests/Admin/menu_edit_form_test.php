<?php
session_start();
$_SESSION['role'] = 'admin';

require_once __DIR__ . '/../../app/controllers/MenuController.php';
require_once __DIR__ . '/../../app/core/Database.php';

use App\Controllers\MenuController;
use App\Core\Database;

class FakeMenuModel {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function findById(int $id) {
        //  Replace 'menu_item_id' with the actual primary key column name in your table
        $stmt = $this->db->prepare("SELECT * FROM menu_item WHERE menu_item_id = :id");
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}

class TestMenuController extends MenuController {
    public function testEditForm()
    {
        $_GET['id'] = 1; // ← Replace with a valid menu_item_id from your database

        $menuModel = new FakeMenuModel();
        $item = $menuModel->findById((int)$_GET['id']);

        if (!$item) {
            echo "<h3> Menu item not found (ID: {$_GET['id']})</h3>";
        } else {
            echo "<h3>Menu item loaded for editing:</h3>";
            echo "<pre>";
            print_r($item);
            echo "</pre>";
        }
    }
}

$controller = new TestMenuController();
$controller->testEditForm();