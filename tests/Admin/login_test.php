<?php
session_start();

// Simulate POST request
$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST['admin_id'] = 123128;       // Must match an existing admin ID
$_POST['password'] = 'hisan123';   // Must match the plain password before hashing

// Load all required files
require_once __DIR__ . '/../../app/core/Database.php';
require_once __DIR__ . '/../../app/models/AdminModel.php';
require_once __DIR__ . '/../../app/controllers/AdminController.php';

use App\Controllers\AdminController;
use App\Models\AdminModel;

// Extend AdminController to override redirect for testing
class TestAdminController extends AdminController {
    public function login()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminId = $_POST['admin_id'];
            $password = $_POST['password'];

            $admin = AdminModel::findById($adminId);

            if ($admin && password_verify($password, $admin['password'])) {
                $_SESSION['role'] = 'admin';
                $_SESSION['admin_id'] = $admin['admin_id'];
                echo "<p> Login successful</p>";
            } else {
                echo "<p> Invalid Admin ID or password</p>";
            }
        } else {
            echo "<p>Login form rendered</p>";
        }
    }
}

// Run the test
$controller = new TestAdminController();
$controller->login();

echo "<h3>Session after login:</h3>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";