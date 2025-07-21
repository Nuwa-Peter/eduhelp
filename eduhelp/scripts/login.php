<?php
session_start();
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        die('Please fill in all the required fields.');
    }

    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT user_id, school_id, role, password_hash FROM users WHERE email = ? OR phone = ?");
    $stmt->bind_param("ss", $email, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['school_id'] = $user['school_id'];
            $_SESSION['role'] = $user['role'];

            require_once 'functions.php';
            log_audit_trail($user['user_id'], 'User login');

            header('Location: ../?page=dashboard');
            exit;
        } else {
            die('Incorrect password.');
        }
    } else {
        die('User not found.');
    }

    $stmt->close();
    $conn->close();
} else {
    header('Location: ../?page=login');
    exit;
}
?>
