<?php
session_start();
$_SESSION['role'] = 'admin';
$_SESSION['admin_id'] = 123128;

require_once __DIR__ . '/../../app/controllers/AdminController.php';
use App\Controllers\AdminController;

$controller = new AdminController();
$controller->logout();

echo "<h3>Session after logout:</h3>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
//for testing this inthe admin controller change the logout method 
//addthis  $_SESSION = [];            // Clear session array
      //   session_unset(); and comment out the header and exit