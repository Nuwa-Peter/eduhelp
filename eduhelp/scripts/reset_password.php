<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($token) || empty($new_password) || empty($confirm_password)) {
        die('Please fill in all the required fields.');
    }

    if ($new_password !== $confirm_password) {
        die('New passwords do not match.');
    }

    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $result = $conn->query("SELECT user_id FROM password_resets WHERE token = '$token' AND created_at > DATE_SUB(NOW(), INTERVAL 1 HOUR)");
    if ($result->num_rows === 1) {
        $reset = $result->fetch_assoc();
        $user_id = $reset['user_id'];

        $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE users SET password_hash = ? WHERE user_id = ?");
        $stmt->bind_param("si", $password_hash, $user_id);
        $stmt->execute();
        $stmt->close();

        $conn->query("DELETE FROM password_resets WHERE token = '$token'");

        echo 'Your password has been reset successfully. You can now <a href="?page=login">login</a>.';
    } else {
        die('Invalid or expired token.');
    }

    $conn->close();
} else {
    header('Location: ../?page=home');
    exit;
}
?>
