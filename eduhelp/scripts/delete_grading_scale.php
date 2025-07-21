<?php
session_start();
require_once '../config.php';
require_once 'functions.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'headteacher') {
    die('Access denied.');
}

if (isset($_GET['id'])) {
    $school_id = $_SESSION['school_id'];
    $scale_id = $_GET['id'];

    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("DELETE FROM grading_scales WHERE grading_scale_id = ? AND school_id = ?");
    $stmt->bind_param("ii", $scale_id, $school_id);

    if ($stmt->execute()) {
        log_audit_trail($_SESSION['user_id'], 'Delete grading scale', "Scale ID: $scale_id");
        header('Location: ../?page=grading_scales');
        exit;
    } else {
        die('Error deleting grading scale: ' . $stmt->error);
    }

    $stmt->close();
    $conn->close();
} else {
    header('Location: ../?page=grading_scales');
    exit;
}
?>
