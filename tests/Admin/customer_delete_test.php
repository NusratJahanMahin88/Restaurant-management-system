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

    public function deleteCustomer(int $customerId) {
        $stmt = $this->db->prepare("DELETE FROM `customer` WHERE customer_id = :id");
        $stmt->bindValue(':id', $customerId, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function findById(int $customerId) {
        $stmt = $this->db->prepare("SELECT * FROM `customer` WHERE customer_id = :id");
        $stmt->bindValue(':id', $customerId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}

// --- Test run ---
$customerId = 21; // target customer ID

$model   = new FakeCustomerModel();
$success = $model->deleteCustomer($customerId);

if ($success) {
    echo "<h3> Customer deleted successfully (ID: {$customerId})</h3>";
    $check = $model->findById($customerId);
    if (empty($check)) {
        echo "Confirmed: Customer no longer exists in database.";
    } else {
        echo "Customer still found in database!";
        print_r($check);
    }
} else {
    echo "<h3> Failed to delete customer (ID: {$customerId})</h3>";
}