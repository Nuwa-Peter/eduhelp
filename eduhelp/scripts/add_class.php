<?php
session_start();
require_once '../config.php';
require_once 'functions.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'headteacher') {
    die('Access denied.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $school_id = $_SESSION['school_id'];
    $class_level = $_POST['class_level'];
    $class_name = $_POST['class_name'];

    if (empty($class_level) || empty($class_name)) {
        die('Please fill in all the required fields.');
    }

    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO classes (school_id, class_level, class_name) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $school_id, $class_level, $class_name);

    if ($stmt->execute()) {
        $class_id = $stmt->insert_id;
        log_audit_trail($_SESSION['user_id'], 'Add class', "Class ID: $class_id");
        header('Location: ../?page=classes');
        exit;
    } else {
        die('Error adding class: ' . $stmt->error);
    }

    $stmt->close();
    $conn->close();
} else {
    header('Location: ../?page=classes');
    exit;
}
?>
