<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'headteacher') {
    die('Access denied.');
}

if (!isset($_GET['id'])) {
    header('Location: ../?page=students');
    exit;
}

$student_id = $_GET['id'];
$school_id = $_SESSION['school_id'];

$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("DELETE FROM students WHERE student_id = ? AND school_id = ?");
$stmt->bind_param("ii", $student_id, $school_id);

if ($stmt->execute()) {
    log_audit_trail($_SESSION['user_id'], 'Delete student', "Student ID: $student_id");
    header('Location: ../?page=students');
    exit;
} else {
    die('Error deleting student: ' . $stmt->error);
}

$stmt->close();
$conn->close();
?>
