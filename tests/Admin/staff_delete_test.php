<?php
session_start();
$_SESSION['role'] = 'admin';
$_SESSION['admin_id'] = 123128;

require_once __DIR__ . '/../../app/controllers/StaffController.php';
require_once __DIR__ . '/../../app/models/StaffModel.php';
require_once __DIR__ . '/../../app/core/Database.php';

use App\Controllers\StaffController;
use App\Models\StaffModel;

class TestStaffController extends StaffController {
    public function staffDelete()
    {
        $_GET['id'] = 123461; // ← Replace with the actual staff ID you want to delete

        $id = $_GET['id'] ?? null;
        if ($id) {
            StaffModel::delete($id);
            echo "<h3> Staff ID $id deleted successfully.</h3>";
        } else {
            echo "<h3> Staff ID missing.</h3>";
        }
    }
}

$controller = new TestStaffController();
$controller->staffDelete();