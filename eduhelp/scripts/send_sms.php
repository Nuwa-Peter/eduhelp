<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'headteacher') {
    die('Access denied.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $school_id = $_SESSION['school_id'];
    $recipients = $_POST['recipients'];
    $message = $_POST['message'];

    if (empty($recipients) || empty($message)) {
        die('Please fill in all the required fields.');
    }

    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $phone_numbers = [];
    if ($recipients === 'all_parents') {
        $result = $conn->query("SELECT parent_contact FROM students WHERE school_id = $school_id");
        while ($row = $result->fetch_assoc()) {
            $phone_numbers[] = $row['parent_contact'];
        }
    } elseif ($recipients === 'all_teachers') {
        $result = $conn->query("SELECT phone FROM users WHERE school_id = $school_id AND role = 'teacher'");
        while ($row = $result->fetch_assoc()) {
            $phone_numbers[] = $row['phone'];
        }
    } elseif (strpos($recipients, 'class_') === 0) {
        $class_id = str_replace('class_', '', $recipients);
        $result = $conn->query("SELECT parent_contact FROM students WHERE class_id = $class_id AND school_id = $school_id");
        while ($row = $result->fetch_assoc()) {
            $phone_numbers[] = $row['parent_contact'];
        }
    }

    $phone_numbers = array_unique($phone_numbers);

    $stmt = $conn->prepare("INSERT INTO sms_logs (school_id, recipient_phone, message, status) VALUES (?, ?, ?, 'sent')");

    foreach ($phone_numbers as $phone) {
        // In a real application, you would integrate with an SMS gateway here.
        // For this mock implementation, we just log the message to the database.
        $stmt->bind_param("iss", $school_id, $phone, $message);
        $stmt->execute();
    }

    $stmt->close();
    $conn->close();

    header('Location: ../?page=sms&status=success');
    exit;
} else {
    header('Location: ../?page=sms');
    exit;
}
?>
