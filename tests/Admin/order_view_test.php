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

    public function getOrderDetails(int $orderId) {
        $sql = "
            SELECT 
                o.order_id,
                o.status,
                o.placed_at,
                o.comments,
                c.name   AS customer_name,
                c.email  AS customer_email
            FROM `order` AS o
            JOIN `customer` AS c ON o.customer_id = c.customer_id
            WHERE o.order_id = :orderId
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':orderId', $orderId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}

// --- Test run ---
$_GET['id'] = 267; // Replace with a valid order_id from your database

$orderId = $_GET['id'] ?? null;
if (!$orderId) {
    echo "<h3> No order ID provided.</h3>";
    return;
}

$orderModel = new FakeOrderModel();
$order = $orderModel->getOrderDetails((int)$orderId);

if (empty($order)) {
    echo "<h3> Order not found (ID: {$orderId})</h3>";
} else {
    echo "<h3>Order Details Loaded:</h3>";
    echo "<pre>";
    print_r($order);
    echo "</pre>";
}