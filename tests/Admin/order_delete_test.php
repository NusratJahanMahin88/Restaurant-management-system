<?php
session_start();
$_SESSION['role'] = 'admin'; // simulate admin login

require_once __DIR__ . '/../../app/core/Database.php';
use App\Core\Database;

class FakeOrderModel {
    private $db;
    public function __construct() {
        $this->db = Database::connect();
    }

    public function deleteOrder(int $orderId) {
        $stmt = $this->db->prepare("DELETE FROM `order` WHERE order_id = :orderId");
        $stmt->bindValue(':orderId', $orderId, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function findById(int $orderId) {
        $stmt = $this->db->prepare("SELECT * FROM `order` WHERE order_id = :orderId");
        $stmt->bindValue(':orderId', $orderId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}

// --- Test run ---
$_POST['order_id'] = 282; // <-- delete order number 282

$orderId = $_POST['order_id'] ?? null;
if (!$orderId) {
    echo "<h3> No order ID provided.</h3>";
    return;
}

$orderModel = new FakeOrderModel();
$success = $orderModel->deleteOrder((int)$orderId);

if ($success) {
    echo "<h3> Order deleted successfully (ID: {$orderId})</h3>";
    $check = $orderModel->findById((int)$orderId);
    if (empty($check)) {
        echo "Confirmed: Order no longer exists in database.";
    } else {
        echo " Order still found in database!";
        print_r($check);
    }
} else {
    echo "<h3> Failed to delete order (ID: {$orderId})</h3>";
}