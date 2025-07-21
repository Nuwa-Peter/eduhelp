<?php
require_once '../config.php';
require_once 'functions.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $school_name = $_POST['school_name'];
    $contact_email = $_POST['contact_email'];
    $contact_phone = $_POST['contact_phone'];
    $address = $_POST['address'];
    $headteacher_username = $_POST['headteacher_username'];
    $headteacher_email = $_POST['headteacher_email'];
    $headteacher_password = $_POST['headteacher_password'];
    $headteacher_gender = $_POST['headteacher_gender'];

    // Validate the form data
    if (empty($school_name) || empty($contact_email) || empty($contact_phone) || empty($address) || empty($headteacher_username) || empty($headteacher_email) || empty($headteacher_password) || empty($headteacher_gender)) {
        die('Please fill in all the required fields.');
    }

    // Generate a unique EDH School ID
    $edh_school_id = generate_edh_id('school');

    // Hash the headteacher's password
    $password_hash = password_hash($headteacher_password, PASSWORD_DEFAULT);

    // Create a database connection
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Insert the school data into the database
        $stmt = $conn->prepare("INSERT INTO schools (edh_id, name, contact_email, contact_phone, address) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $edh_school_id, $school_name, $contact_email, $contact_phone, $address);
        $stmt->execute();
        $school_id = $stmt->insert_id;
        $stmt->close();

        // Upload the school logo
        if (isset($_FILES['school_logo']) && $_FILES['school_logo']['error'] === UPLOAD_ERR_OK) {
            $logo_path = upload_logo($_FILES['school_logo'], $edh_school_id);
            if ($logo_path) {
                $stmt = $conn->prepare("UPDATE schools SET logo_path = ? WHERE school_id = ?");
                $stmt->bind_param("si", $logo_path, $school_id);
                $stmt->execute();
                $stmt->close();
            }
        }

        // Generate a unique EDH Teacher ID for the headteacher
        $edh_teacher_id = generate_edh_id('teacher', $headteacher_gender);

        // Insert the headteacher data into the database
        $stmt = $conn->prepare("INSERT INTO users (school_id, role, edh_id, username, email, password_hash, gender) VALUES (?, 'headteacher', ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $school_id, $edh_teacher_id, $headteacher_username, $headteacher_email, $password_hash, $headteacher_gender);
        $stmt->execute();
        $stmt->close();

        // Commit the transaction
        $conn->commit();

        // Redirect the user to the payment page
        header('Location: ../?page=payment&school_id=' . $school_id);
        exit;
    } catch (Exception $e) {
        // Rollback the transaction if something went wrong
        $conn->rollback();
        die('Registration failed: ' . $e->getMessage());
    } finally {
        $conn->close();
    }
} else {
    // If the form was not submitted, redirect to the registration page
    header('Location: ../?page=register');
    exit;
}
?>
