<?php
session_start();
require_once '../config.php';
require_once 'functions.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'headteacher') {
    die('Access denied.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $school_id = $_SESSION['school_id'];
    $scale_name = $_POST['scale_name'];

    if (empty($scale_name)) {
        die('Please enter a scale name.');
    }

    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO grading_scales (school_id, scale_name) VALUES (?, ?)");
    $stmt->bind_param("is", $school_id, $scale_name);

    if ($stmt->execute()) {
        $scale_id = $stmt->insert_id;
        log_audit_trail($_SESSION['user_id'], 'Add grading scale', "Scale ID: $scale_id");
        header('Location: ../?page=grading_scales');
        exit;
    } else {
        die('Error adding grading scale: ' . $stmt->error);
    }

    $stmt->close();
    $conn->close();
} else {
    header('Location: ../?page=grading_scales');
    exit;
}
?>
