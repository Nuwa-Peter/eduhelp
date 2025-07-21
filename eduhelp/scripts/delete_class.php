<?php
session_start();
require_once '../config.php';
require_once 'functions.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'headteacher') {
    die('Access denied.');
}

if (isset($_GET['id'])) {
    $school_id = $_SESSION['school_id'];
    $class_id = $_GET['id'];

    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("DELETE FROM classes WHERE class_id = ? AND school_id = ?");
    $stmt->bind_param("ii", $class_id, $school_id);

    if ($stmt->execute()) {
        log_audit_trail($_SESSION['user_id'], 'Delete class', "Class ID: $class_id");
        header('Location: ../?page=classes');
        exit;
    } else {
        die('Error deleting class: ' . $stmt->error);
    }

    $stmt->close();
    $conn->close();
} else {
    header('Location: ../?page=classes');
    exit;
}
?>
