<?php
session_start();
$_SESSION['role'] = 'admin'; // simulate admin login

require_once __DIR__ . '/../../app/core/Database.php';
//  Not requiring MenuModel.php directly if it's still tied to DatabaseModel
use App\Core\Database;

// Lightweight test model
class FakeMenuModel {
    private $db;
    public function __construct() {
        $this->db = Database::connect();
    }

    public function updateStatus(int $id, string $status) {
        //  Replace 'menu_item_id' with your actual primary key column
        $stmt = $this->db->prepare(
            "UPDATE menu_item SET status = :status WHERE menu_item_id = :id"
        );
        $stmt->bindValue(':status', $status);
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

// --- Test publish ---
$id = 1;  // replace with a valid menu_item_id
$menuModel = new FakeMenuModel();
$menuModel->updateStatus($id, 'published');
$item = $menuModel->findById($id);

echo "<h3> Publish Test</h3>";
if ($item && $item['status'] === 'published') {
    echo "Menu item {$id} published successfully.<br>";
    print_r($item);
} else {
    echo " Publish failed for menu item {$id}.<br>";
}

// --- Test unpublish ---
$menuModel->updateStatus($id, 'unpublished');
$item = $menuModel->findById($id);

echo "<h3>Unpublish Test</h3>";
if ($item && $item['status'] === 'unpublished') {
    echo "Menu item {$id} unpublished successfully.<br>";
    print_r($item);
} else {
    echo " Unpublish failed for menu item {$id}.<br>";
}