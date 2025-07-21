<?php
session_start();
require_once '../config.php';
require_once 'functions.php';
require_once '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'headteacher') {
    die('Access denied.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['excel_file'])) {
    $school_id = $_SESSION['school_id'];
    $file = $_FILES['excel_file']['tmp_name'];

    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    try {
        $spreadsheet = IOFactory::load($file);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        // Remove the header row
        array_shift($rows);

        $conn->begin_transaction();

        foreach ($rows as $row) {
            $name = $row[0];
            $lin = $row[1];
            $class_name = $row[2];
            $gender = strtolower($row[3]);
            $dob = $row[4];
            $parent_contact = $row[5];

            if (empty($name) || empty($lin) || empty($class_name) || empty($gender) || empty($dob) || empty($parent_contact)) {
                continue;
            }

            // Get class_id from class_name
            $class_result = $conn->query("SELECT class_id FROM classes WHERE class_name = '$class_name' AND school_id = $school_id")->fetch_assoc();
            if (!$class_result) {
                // If class doesn't exist, create it
                $stmt = $conn->prepare("INSERT INTO classes (school_id, class_name) VALUES (?, ?)");
                $stmt->bind_param("is", $school_id, $class_name);
                $stmt->execute();
                $class_id = $stmt->insert_id;
                $stmt->close();
            } else {
                $class_id = $class_result['class_id'];
            }

            $edh_student_id = generate_edh_id('student', $gender);

            $stmt = $conn->prepare("INSERT INTO students (school_id, class_id, edh_id, LIN, name, gender, dob, parent_contact) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iissssss", $school_id, $class_id, $edh_student_id, $lin, $name, $gender, $dob, $parent_contact);
            $stmt->execute();
            $stmt->close();
        }

        $conn->commit();
        header('Location: ../?page=students&import=success');
        exit;
    } catch (Exception $e) {
        $conn->rollback();
        die('Error importing students: ' . $e->getMessage());
    } finally {
        $conn->close();
    }
} else {
    header('Location: ../?page=import_students');
    exit;
}
?>
