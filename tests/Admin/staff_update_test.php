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
    public function staffUpdate()
    {
        $_POST = [
            'id' => 1, // replace with actual staff ID
            'name' => 'Updated Staff',
            'email' => 'updated@example.com',
            'phone' => '9876543210',
            'role' => 'Chef'
        ];

        $_FILES = [
            'profile_picture' => [
                'name' => '',
                'tmp_name' => '',
                'type' => ''
            ]
        ];

        $staffId = $_POST['id'] ?? null;
        if (!$staffId) {
            echo "Staff ID is missing.";
            return;
        }

        $staff = StaffModel::findById($staffId);

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $role = $_POST['role'] ?? '';
       $profilePicture = is_array($staff) ? $staff['profile_picture'] : null;
        $validRoles = ['Manager', 'Chef', 'Waiter'];
        $errors = [];

        if (!preg_match('/^[A-Za-z\s]+$/', $name)) {
            $errors[] = 'Full Name must contain only letters and spaces.';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email address.';
        }

        if (!empty($phone) && !preg_match('/^\d{10}$/', $phone)) {
            $errors[] = 'Phone number must be exactly 10 digits.';
        }

        if (!in_array($role, $validRoles)) {
            $errors[] = 'Invalid role selected.';
        }

        if (!empty($errors)) {
            echo "<h3>Validation Errors:</h3><pre>";
            print_r($errors);
            echo "</pre>";
            return;
        }

        StaffModel::update($staffId, [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'role' => $role,
            'profile_picture' => $profilePicture
        ]);

        echo "<h3>✅ Staff updated successfully.</h3>";
        $updated = StaffModel::findById($staffId);
        echo "<pre>";
        print_r($updated);
        echo "</pre>";
    }
}

$controller = new TestStaffController();
$controller->staffUpdate();