<?php
session_start();
require_once '../config.php';
require_once 'functions.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'headteacher') {
    die('Access denied.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $school_id = $_SESSION['school_id'];
    $grading_scale_id = $_POST['grading_scale_id'];
    $level_name = $_POST['level_name'];
    $min_score = $_POST['min_score'];
    $max_score = $_POST['max_score'];

    if (empty($level_name) || !isset($min_score) || !isset($max_score)) {
        die('Please fill in all the required fields.');
    }

    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO grading_scale_levels (grading_scale_id, level_name, min_score, max_score) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isii", $grading_scale_id, $level_name, $min_score, $max_score);

    if ($stmt->execute()) {
        $level_id = $stmt->insert_id;
        log_audit_trail($_SESSION['user_id'], 'Add grading scale level', "Level ID: $level_id");
        header('Location: ../?page=grading_scale_levels&id=' . $grading_scale_id);
        exit;
    } else {
        die('Error adding grading scale level: ' . $stmt->error);
    }

    $stmt->close();
    $conn->close();
} else {
    header('Location: ../?page=grading_scales');
    exit;
}
?>
