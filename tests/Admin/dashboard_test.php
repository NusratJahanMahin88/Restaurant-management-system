<?php
session_start();
$_SESSION['role'] = 'admin'; // simulate logged-in admin

require_once __DIR__ . '/../../app/controllers/AdminController.php';
require_once __DIR__ . '/../../app/models/OrderModel.php';
require_once __DIR__ . '/../../app/core/Database.php';
use App\Controllers\AdminController;
use App\Models\OrderModel;

// Extend AdminController but skip requireAdmin for testing
class TestAdminController extends AdminController {
    public function dashboard()
    {
        // Skip $this->requireAdmin(); since it's private and we already set session

        // Chart data for last 7 days
        $weeklySummary = OrderModel::getLast7DaysSummary();

        // Today's orders
        $ordersToday   = OrderModel::getOrdersByDate(date('Y-m-d'));

        // Recent orders
        $recentOrders  = OrderModel::getRecentOrders();

        // Status breakdown
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

        $todayMetrics = [
            'total_orders' => count($ordersToday),
            'status_breakdown' => $statusCounts
        ];

        // Print results instead of rendering a view
        echo "<h3>Weekly Summary (last 7 days):</h3>";
        echo "<pre>";
        print_r($weeklySummary);
        echo "</pre>";

        echo "<h3>Today's Metrics:</h3>";
        echo "<pre>";
        print_r($todayMetrics);
        echo "</pre>";

        echo "<h3>Recent Orders:</h3>";
        echo "<pre>";
        print_r($recentOrders);
        echo "</pre>";
    }
}

// Run test
$controller = new TestAdminController();
$controller->dashboard();