<?php
session_start();
$_SESSION['role'] = 'admin'; // simulate admin login

require_once __DIR__ . '/../../app/core/Database.php';
use App\Core\Database;

class FakeCustomerModel {
    private $db;
    public function __construct() {
        $this->db = Database::connect();
    }

    public function getAllCustomers() {
        $stmt = $this->db->query("SELECT customer_id, name, email FROM `customer` ORDER BY customer_id DESC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}

// --- Test run ---
$model = new FakeCustomerModel();
$customers = $model->getAllCustomers();

echo "<h3> Customer List Test</h3>";
echo "<pre>";
print_r($customers);
echo "</pre>";