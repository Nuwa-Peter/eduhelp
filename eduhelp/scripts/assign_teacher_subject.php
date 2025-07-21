<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'headteacher') {
    die('Access denied.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teacher_id = $_POST['teacher_id'];
    $class_id = $_POST['class_id'];
    $subject_id = $_POST['subject_id'];

    if (empty($teacher_id) || empty($class_id) || empty($subject_id)) {
        die('Please fill in all the required fields.');
    }

    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO teacher_subjects (teacher_id, class_id, subject_id) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $teacher_id, $class_id, $subject_id);

    if ($stmt->execute()) {
        header('Location: ../?page=teacher_subjects');
        exit;
    } else {
        die('Error assigning teacher: ' . $stmt->error);
    }

    $stmt->close();
    $conn->close();
} else {
    header('Location: ../?page=teacher_subjects');
    exit;
}
?>
