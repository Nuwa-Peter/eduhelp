<?php
session_start();
require_once '../config.php';
require_once 'functions.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'headteacher') {
    die('Access denied.');
}

if (isset($_GET['id'])) {
    $level_id = $_GET['id'];

    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $level = $conn->query("SELECT grading_scale_id FROM grading_scale_levels WHERE level_id = $level_id")->fetch_assoc();
    $grading_scale_id = $level['grading_scale_id'];

    $stmt = $conn->prepare("DELETE FROM grading_scale_levels WHERE level_id = ?");
    $stmt->bind_param("i", $level_id);

    if ($stmt->execute()) {
        log_audit_trail($_SESSION['user_id'], 'Delete grading scale level', "Level ID: $level_id");
        header('Location: ../?page=grading_scale_levels&id=' . $grading_scale_id);
        exit;
    } else {
        die('Error deleting grading scale level: ' . $stmt->error);
    }

    $stmt->close();
    $conn->close();
} else {
    header('Location: ../?page=grading_scales');
    exit;
}
?>
