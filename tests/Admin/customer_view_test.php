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

    public function getCustomerById(int $customerId) {
        $stmt = $this->db->prepare("SELECT customer_id, name, email FROM `customer` WHERE customer_id = :id");
        $stmt->bindValue(':id', $customerId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}

// --- Test run ---
$_GET['id'] = 24; // Replace with a valid customer_id

$customerId = $_GET['id'] ?? null;
if (!$customerId) {
    echo "<h3> No customer ID provided.</h3>";
    return;
}

$model = new FakeCustomerModel();
$customer = $model->getCustomerById((int)$customerId);

if (!$customer) {
    echo "<h3> Customer not found (ID: {$customerId})</h3>";
} else {
    echo "<h3> Customer Details Loaded:</h3>";
    echo "<pre>";
    print_r($customer);
    echo "</pre>";
}