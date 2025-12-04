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

    public function getAllOrdersWithCustomer() {
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
            ORDER BY o.order_id DESC
        ";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getAvailableStatuses() {
        return ['Received', 'Cancelled', 'Processing', 'Completed'];
    }
}

// --- Test run ---
$orderModel = new FakeOrderModel();
try {
    $orders   = $orderModel->getAllOrdersWithCustomer();
    $statuses = FakeOrderModel::getAvailableStatuses();

    echo "<h3>✅ Order List Test</h3>";
    echo "<h4>Available Statuses:</h4>";
    echo "<pre>";
    print_r($statuses);
    echo "</pre>";

    echo "<h4>Orders with Customer Info:</h4>";
    echo "<pre>";
    print_r($orders);
    echo "</pre>";
} catch (\PDOException $e) {
    echo "<h3>❌ Database Error:</h3>";
    echo htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
}