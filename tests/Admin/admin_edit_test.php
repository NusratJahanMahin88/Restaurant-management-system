<?php
session_start();
$_SESSION['role'] = 'admin';
$_SESSION['admin_id'] = 123128;

require_once __DIR__ . '/../../app/controllers/AdminController.php';
require_once __DIR__ . '/../../app/models/AdminModel.php';
require_once __DIR__ . '/../../app/core/Database.php';

use App\Controllers\AdminController;
use App\Models\AdminModel;

// Extend AdminController to skip requireAdmin for testing
class TestAdminController extends AdminController {
    public function adminEditForm()
    {
        $id = $_SESSION['admin_id'];
        $admin = AdminModel::findById($id);

        echo "<h3>Edit Admin Form:</h3>";
        echo "<pre>";
        print_r($admin); // Simulate view rendering
        echo "</pre>";
    }
}

// Run test
$controller = new TestAdminController();
$controller->adminEditForm();