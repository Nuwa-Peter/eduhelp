<?php
session_start();
require_once '../config.php';
require_once 'functions.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'headteacher') {
    die('Access denied.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $school_id = $_SESSION['school_id'];
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $lin = $_POST['lin'];
    $class_id = $_POST['class_id'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $parent_contact = $_POST['parent_contact'];

    if (empty($student_id) || empty($name) || empty($lin) || empty($class_id) || empty($gender) || empty($dob) || empty($parent_contact)) {
        die('Please fill in all the required fields.');
    }

    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $student = $conn->query("SELECT edh_id, photo_path FROM students WHERE student_id = $student_id AND school_id = $school_id")->fetch_assoc();

    $photo_path = $student['photo_path'];
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $photo_path = upload_photo($_FILES['photo'], $student['edh_id']);
    }

    $stmt = $conn->prepare("UPDATE students SET name = ?, LIN = ?, class_id = ?, gender = ?, dob = ?, parent_contact = ?, photo_path = ? WHERE student_id = ? AND school_id = ?");
    $stmt->bind_param("ssissssis", $name, $lin, $class_id, $gender, $dob, $parent_contact, $photo_path, $student_id, $school_id);

    if ($stmt->execute()) {
        log_audit_trail($_SESSION['user_id'], 'Edit student', "Student ID: $student_id");
        header('Location: ../?page=students');
        exit;
    } else {
        die('Error updating student: ' . $stmt->error);
    }

    $stmt->close();
    $conn->close();
} else {
    header('Location: ../?page=students');
    exit;
}
?>
