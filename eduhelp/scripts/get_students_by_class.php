<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['headteacher', 'teacher'])) {
    die('Access denied.');
}

if (isset($_POST['class_id'])) {
    $class_id = $_POST['class_id'];
    $school_id = $_SESSION['school_id'];

    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $students = $conn->query("SELECT * FROM students WHERE class_id = $class_id AND school_id = $school_id");

    echo '<option value="">Select a student</option>';
    while ($row = $students->fetch_assoc()) {
        echo '<option value="' . $row['student_id'] . '">' . $row['name'] . '</option>';
    }

    $conn->close();
}
?>
