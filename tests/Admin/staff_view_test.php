<?php
session_start();
$_SESSION['role'] = 'admin';
$_SESSION['admin_id'] = 123128;

require_once __DIR__ . '/../../app/controllers/StaffController.php';
require_once __DIR__ . '/../../app/models/StaffModel.php';
require_once __DIR__ . '/../../app/core/Database.php';

use App\Controllers\StaffController;
use App\Models\StaffModel;

// Extend StaffController to skip requireAdmin for testing
class TestStaffController extends StaffController {
    public function staffView()
    {
        $_GET['id'] = 123465; // Replace with a valid staff ID

        $id = $_GET['id'] ?? null;
        $staff = StaffModel::findById($id);

        if (!$staff) {
            echo "<h3>❌ Staff not found.</h3>";
            return;
        }

        echo "<h3>✅ Staff Profile:</h3><pre>";
        print_r($staff);
        echo "</pre>";
    }
}

$controller = new TestStaffController();
$controller->staffView();