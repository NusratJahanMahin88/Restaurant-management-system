<?php
session_start();
$_SESSION['role'] = 'admin';

// Temporary mock class to bypass the broken MenuModel
class FakeMenuModel {
    public function create($data) {
        echo "<h3> menu item created:</h3>";
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
    public function getAllItems() {
        return [$this->lastCreated ?? []];
    }
}

// Use the fake model instead of the real one
$menuModel = new FakeMenuModel();

// Simulate POST data
$_POST = [
    'name'   => 'Test Pizza',
    'price'  => 12.50,
    'status' => 'published'
];

// Run the fake create
$menuModel->create($_POST);