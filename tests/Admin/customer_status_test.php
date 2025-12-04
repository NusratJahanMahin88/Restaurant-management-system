<?php
session_start();
$_SESSION['role'] = 'admin'; // simulate admin login

//  Simulated test without DB dependency
$customerId = 24;       
$status     = 'active';
if (!$customerId || !$status) {
    echo "<h3> Missing customer ID or status.</h3>";
    exit;
}

// Simulate update success
echo "<h3>Customer status updated successfully (ID: {$customerId})</h3>";
echo "<h4>Updated Customer Record (simulated):</h4><pre>";
print_r([
    'customer_id' => $customerId,
    'name'        => 'Test Customer',
    'email'       => 'test@example.com',
    'status'      => $status
]);
echo "</pre>";