<?php
session_start();
$_SESSION['role'] = 'admin';
$_SESSION['admin_id'] = 123132; // test admin ID  newly created

require_once __DIR__ . '/../../app/controllers/AdminController.php';
require_once __DIR__ . '/../../app/models/AdminModel.php';
require_once __DIR__ . '/../../app/core/Database.php';

use App\Controllers\AdminController;
use App\Models\AdminModel;

class TestAdminController extends AdminController {
    public function adminDeleteFinal()
    {
        $_POST['confirm'] = 'yes'; // simulate confirmation

        $adminId = $_SESSION['admin_id'] ?? null;
        if ($_POST['confirm'] === 'yes' && $adminId) {
            AdminModel::deleteById((int)$adminId);
            echo "<h3>Admin ID $adminId deleted successfully.</h3>";
        } else {
            echo "<h3>Deletion cancelled or not confirmed.</h3>";
        }
    }
}

$controller = new TestAdminController();
$controller->adminDeleteFinal();