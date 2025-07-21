<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'headteacher') {
    die('Access denied.');
}

if (!isset($_GET['teacher_id']) || !isset($_GET['class_id']) || !isset($_GET['subject_id'])) {
    header('Location: ../?page=teacher_subjects');
    exit;
}

$teacher_id = $_GET['teacher_id'];
$class_id = $_GET['class_id'];
$subject_id = $_GET['subject_id'];

$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("DELETE FROM teacher_subjects WHERE teacher_id = ? AND class_id = ? AND subject_id = ?");
$stmt->bind_param("iii", $teacher_id, $class_id, $subject_id);

if ($stmt->execute()) {
    header('Location: ../?page=teacher_subjects');
    exit;
} else {
    die('Error unassigning teacher: ' . $stmt->error);
}

$stmt->close();
$conn->close();
?>
