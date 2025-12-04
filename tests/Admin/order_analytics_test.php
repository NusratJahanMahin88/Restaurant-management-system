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

    public static function deleteOldOrders() {
        $db = Database::connect();
        $stmt = $db->prepare("DELETE FROM `order` WHERE placed_at < DATE_SUB(NOW(), INTERVAL 7 DAY)");
        $stmt->execute();
    }

    public static function getOrdersByDate($date) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM `order` WHERE DATE(placed_at) = :date");
        $stmt->bindValue(':date', $date);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getLast7DaysSummary() {
        $db = Database::connect();
        $stmt = $db->query("
            SELECT DATE(placed_at) AS day, COUNT(*) AS total
            FROM `order`
            WHERE placed_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
            GROUP BY day
            ORDER BY day ASC
        ");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}

// --- Test run ---
FakeOrderModel::deleteOldOrders();
$ordersToday   = FakeOrderModel::getOrdersByDate(date('Y-m-d'));
$weeklySummary = FakeOrderModel::getLast7DaysSummary() ?? [];

$statusCounts = [
    'pending' => 0,
    'received' => 0,
    'preparing' => 0,
    'in progress' => 0,
    'ready' => 0,
    'ready for pickup' => 0,
    'completed' => 0,
    'cancelled' => 0,
    'canceled' => 0,
    'nostatus' => 0,
];

foreach ($ordersToday ?? [] as $order) {
    $status = strtolower(trim($order['status'] ?? 'nostatus'));
    if (array_key_exists($status, $statusCounts)) {
        $statusCounts[$status]++;
    } else {
        $statusCounts['nostatus']++;
    }
}

$metrics = [
    'total_orders' => count($ordersToday),
    'status_breakdown' => $statusCounts
];

echo "<h3>✅ Order Analytics Dashboard Test</h3>";
echo "<h4>Metrics:</h4><pre>";
print_r($metrics);
echo "</pre>";

echo "<h4>Weekly Summary:</h4><pre>";
print_r($weeklySummary);
echo "</pre>";

echo "<h4>Orders Today:</h4><pre>";
print_r($ordersToday);
echo "</pre>";