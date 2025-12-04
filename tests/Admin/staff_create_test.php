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
    public function createStaff()
    {
        $_POST = [
            'name' => 'Test Staff',
            'email' => 'staff@example.com',
            'phone' => '1234567890',
            'role' => 'staff',
            'password' => 'securepass123'
        ];

        // Simulate no file upload
        $_FILES = [
            'profile_picture' => [
                'name' => '',
                'tmp_name' => ''
            ]
        ];

        $name     = $_POST['name'] ?? '';
        $email    = $_POST['email'] ?? '';
        $phone    = $_POST['phone'] ?? '';
        $role     = $_POST['role'] ?? '';
        $password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);

        $profilePicture = null;

        $success = StaffModel::create([
            'name'            => $name,
            'email'           => $email,
            'phone'           => $phone,
            'role'            => $role,
            'password'        => $password,
            'profile_picture' => $profilePicture
        ]);

        if ($success) {
            echo "<h3>✅ Staff created successfully.</h3>";
            $staff = StaffModel::findById($success);
            echo "<pre>";
            print_r($staff);
            echo "</pre>";
        } else {
            echo "<h3>❌ Failed to create staff. Please try again.</h3>";
        }
    }
}

$controller = new TestStaffController();
$controller->createStaff();