<?php
session_start();
require_once '../config.php';
require_once 'functions.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'headteacher') {
    die('Access denied.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $school_id = $_SESSION['school_id'];
    $name = $_POST['name'];
    $lin = $_POST['lin'];
    $class_id = $_POST['class_id'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $parent_contact = $_POST['parent_contact'];

    if (empty($name) || empty($lin) || empty($class_id) || empty($gender) || empty($dob) || empty($parent_contact)) {
        die('Please fill in all the required fields.');
    }

    $edh_student_id = generate_edh_id('student', $gender);

    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $photo_path = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $photo_path = upload_photo($_FILES['photo'], $edh_student_id);
    }

    $stmt = $conn->prepare("INSERT INTO students (school_id, class_id, edh_id, LIN, name, photo_path, gender, dob, parent_contact) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iisssssss", $school_id, $class_id, $edh_student_id, $lin, $name, $photo_path, $gender, $dob, $parent_contact);

    if ($stmt->execute()) {
        $student_id = $stmt->insert_id;
        log_audit_trail($_SESSION['user_id'], 'Add student', "Student ID: $student_id");
        header('Location: ../?page=students');
        exit;
    } else {
        die('Error adding student: ' . $stmt->error);
    }

    $stmt->close();
    $conn->close();
} else {
    header('Location: ../?page=add_student');
    exit;
}

function upload_photo($file, $edh_student_id) {
    $target_dir = "../uploads/photos/";
    $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    $target_file = $target_dir . $edh_student_id . '.' . $imageFileType;
    $uploadOk = 1;

    // Check if image file is a actual image or fake image
    $check = getimagesize($file["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($file["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        return null;
    } else {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            return 'uploads/photos/' . $edh_student_id . '.' . $imageFileType;
        } else {
            echo "Sorry, there was an error uploading your file.";
            return null;
        }
    }
}
?>
