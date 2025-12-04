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
    public function adminPasswordUpdate()
    {
        $id = $_SESSION['admin_id'];
        $admin = AdminModel::findById($id);

        // Simulate form input
        $_POST['current_password'] = 'hisan'; // if i put the correct password here it will update the new password
        $_POST['new_password'] = 'newsecurepass';
        $_POST['confirm_password'] = 'newsecurepass';

        $current = $_POST['current_password'] ?? '';
        $new = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';
        $errors = [];

        if (!password_verify($current, $admin['password'])) {
            $errors[] = "Current password is incorrect.";
        }

        if (strlen($new) < 6) {
            $errors[] = "New password must be at least 6 characters.";
        }

        if ($new !== $confirm) {
            $errors[] = "New password and confirmation do not match.";
        }

        if ($errors) {
            echo "<h3>Errors:</h3><pre>";
            print_r($errors);
            echo "</pre>";
            return;
        }

        $hashed = password_hash($new, PASSWORD_DEFAULT);
        $adminModel = new AdminModel();
        $adminModel->update($id, ['password' => $hashed]);

        echo "<h3>Password updated successfully.</h3>";
    }
}

// Run test
$controller = new TestAdminController();
$controller->adminPasswordUpdate();