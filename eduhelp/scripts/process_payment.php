<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $school_id = $_POST['school_id'];
    $amount = $_POST['amount'];
    $transaction_id = $_POST['transaction_id'];

    if (empty($school_id) || empty($amount) || empty($transaction_id)) {
        die('Invalid payment data.');
    }

    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("UPDATE schools SET payment_status = 'paid', payment_transaction_id = ? WHERE school_id = ?");
    $stmt->bind_param("si", $transaction_id, $school_id);

    if ($stmt->execute()) {
        header('Location: ../?page=login&payment=success');
        exit;
    } else {
        die('Error processing payment: ' . $stmt->error);
    }

    $stmt->close();
    $conn->close();
} else {
    header('Location: ../?page=home');
    exit;
}
?>
