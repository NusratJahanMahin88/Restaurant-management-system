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
    public function adminCreate()
    {
        $data = [
            'name' => 'New Admin',
            'email' => 'newadmin@example.com',
            'password' => 'securepass123'
        ];
        $_POST = $data;

        $errors = [];

        if (empty($data['name'])) {
            $errors[] = "Name is required.";
        }

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "A valid email is required.";
        }

        if (empty($data['password']) || strlen($data['password']) < 6) {
            $errors[] = "Password must be at least 6 characters.";
        }

        if ($errors) {
            echo "<h3>Validation Errors:</h3><pre>";
            print_r($errors);
            echo "</pre>";
            return;
        }

        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        $newAdminId = AdminModel::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $hashedPassword
        ]);

        if (!$newAdminId) {
            echo "<h3>Failed to create admin.</h3>";
            return;
        }

        $newAdmin = AdminModel::findById($newAdminId);
        echo "<h3>New Admin Created:</h3><pre>";
        print_r($newAdmin);
        echo "</pre>";
    }
}

// Run test
$controller = new TestAdminController();
$controller->adminCreate();