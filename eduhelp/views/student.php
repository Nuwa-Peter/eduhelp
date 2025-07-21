<?php
if (!isset($_GET['id'])) {
    die('No student ID provided.');
}

$edh_id = $_GET['id'];

$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$student = $conn->query("
    SELECT s.*, c.class_name, sc.name as school_name
    FROM students s
    JOIN classes c ON s.class_id = c.class_id
    JOIN schools sc ON s.school_id = sc.school_id
    WHERE s.edh_id = '$edh_id'
")->fetch_assoc();

if (!$student) {
    die('Student not found.');
}
?>

<h1>Student Information</h1>
<div class="card">
    <div class="card-body">
        <h5 class="card-title"><?php echo $student['name']; ?></h5>
        <p class="card-text">
            <b>EDH ID:</b> <?php echo $student['edh_id']; ?><br>
            <b>LIN:</b> <?php echo $student['LIN']; ?><br>
            <b>School:</b> <?php echo $student['school_name']; ?><br>
            <b>Class:</b> <?php echo $student['class_name']; ?><br>
            <b>Gender:</b> <?php echo $student['gender']; ?><br>
            <b>Date of Birth:</b> <?php echo $student['dob']; ?><br>
        </p>
    </div>
</div>

<?php
$conn->close();
?>
