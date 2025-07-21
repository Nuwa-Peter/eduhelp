<?php
require_once '../config.php';
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    if (empty($email)) {
        die('Please enter your email address.');
    }

    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $result = $conn->query("SELECT user_id FROM users WHERE email = '$email'");
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $user_id = $user['user_id'];

        $token = bin2hex(random_bytes(32));

        $stmt = $conn->prepare("INSERT INTO password_resets (user_id, token) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $token);
        $stmt->execute();
        $stmt->close();

        $reset_link = SITE_URL . '?page=reset_password&token=' . $token;
        $subject = 'Password Reset Request';
        $body = 'Click the following link to reset your password: ' . $reset_link;

        send_email(0, $email, $subject, $body); // sent_by 0 for system
    }

    // Always show a success message to prevent user enumeration
    echo 'If a user with that email exists, a password reset link has been sent.';

    $conn->close();
} else {
    header('Location: ../?page=forgot_password');
    exit;
}
?>
