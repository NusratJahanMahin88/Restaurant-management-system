<?php
session_start();
$_SESSION['role'] = 'admin'; // simulate admin login

require_once __DIR__ . '/../../app/controllers/MenuController.php';
require_once __DIR__ . '/../../app/core/Database.php';
//  Not requiring MenuModel.php directly to avoid the DatabaseModel issue
use App\Controllers\MenuController;
use App\Core\Database;

// Lightweight test model using PDO directly
class FakeMenuModel {
    private $db;
    public function __construct() {
        $this->db = Database::connect();
    }

    public function update(int $id, array $data) {
        //  Replace 'menu_item_id' with your actual primary key column
        $stmt = $this->db->prepare(
            "UPDATE menu_item 
             SET name = :name, price = :price, status = :status 
             WHERE menu_item_id = :id"
        );
        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':price', $data['price']);
        $stmt->bindValue(':status', $data['status']);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
    }

    public function findById(int $id) {
        $stmt = $this->db->prepare("SELECT * FROM menu_item WHERE menu_item_id = :id");
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}

class TestMenuController extends MenuController {
    public function testUpdate()
    {
        // Simulate POST data (valid case)
        $_POST = [
            'id'     => 1, // replace with a valid menu_item_id
            'name'   => 'Updated Pizza',
            'price'  => 15.00,
            'status' => 'published'
        ];

        $id   = $_POST['id'];
        $data = $_POST;
        $errors = [];

        if (empty($data['name'])) $errors[] = "Name is required.";
        if (!is_numeric($data['price']) || $data['price'] <= 0) $errors[] = "Price must be positive.";
        if (!in_array($data['status'], ['published', 'unpublished'])) $errors[] = "Invalid status.";

        if ($errors) {
            echo "<h3> Validation Errors:</h3><ul>";
            foreach ($errors as $error) {
                echo "<li>$error</li>";
            }
            echo "</ul>";
        } else {
            $menuModel = new FakeMenuModel();
            $menuModel->update((int)$id, $data);

            echo "<h3> Menu item updated successfully.</h3>";
            $item = $menuModel->findById((int)$id);
            echo "<pre>";
            print_r($item);
            echo "</pre>";
        }
    }
}

$controller = new TestMenuController();
$controller->testUpdate();