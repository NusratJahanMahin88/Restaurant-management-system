<?php
session_start();
$_SESSION['role'] = 'admin';   // simulate logged-in admin
$_SESSION['admin_id'] = 123128;     // simulate current admin ID

// Adjusted path: points directly to AdminController.php
require_once __DIR__ . '/../../app/controllers/AdminController.php';
require_once __DIR__ . '/../../app/models/AdminModel.php';
require_once __DIR__ . '/../../app/core/Database.php';

use App\Controllers\AdminController;
use App\Models\AdminModel;

// Extend AdminController to skip requireAdmin for testing
class TestAdminController extends AdminController {
    public function adminProfile()
    {
        // Normally requireAdmin() would run, but we already set session
        $id = $_SESSION['admin_id'];
        $admin = AdminModel::findById($id);

        // Print results instead of rendering a view
        echo "<h3>Admin Profile:</h3>";
        echo "<pre>";
        print_r($admin);
        echo "</pre>";
    }
}

// Run test
$controller = new TestAdminController();
$controller->adminProfile();