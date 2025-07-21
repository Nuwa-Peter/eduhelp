<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id'])) {
    die('Access denied.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($username) || empty($email)) {
        die('Please fill in all the required fields.');
    }

    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update username, email, and phone
    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, phone = ? WHERE user_id = ?");
    $stmt->bind_param("sssi", $username, $email, $phone, $user_id);
    $stmt->execute();
    $stmt->close();

    // Update password if new password is provided
    if (!empty($new_password)) {
        if ($new_password !== $confirm_password) {
            die('New passwords do not match.');
        }

        $user = $conn->query("SELECT password_hash FROM users WHERE user_id = $user_id")->fetch_assoc();
        if (password_verify($current_password, $user['password_hash'])) {
            $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET password_hash = ? WHERE user_id = ?");
            $stmt->bind_param("si", $password_hash, $user_id);
            $stmt->execute();
            $stmt->close();
        } else {
            die('Incorrect current password.');
        }
    }

    $conn->close();
    header('Location: ../?page=profile&status=success');
    exit;
} else {
    header('Location: ../?page=profile');
    exit;
}
?>
