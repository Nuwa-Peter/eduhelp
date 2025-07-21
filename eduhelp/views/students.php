<?php
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'headteacher') {
    header('Location: ?page=login');
    exit;
}

$school_id = $_SESSION['school_id'];

$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT s.*, c.class_name FROM students s JOIN classes c ON s.class_id = c.class_id WHERE s.school_id = $school_id");
?>

<h1>Manage Students</h1>
<a href="?page=add_student" class="btn btn-primary mb-3">Add Student</a>
<a href="?page=import_students" class="btn btn-secondary mb-3">Import Students</a>

<table class="table table-striped">
    <thead>
        <tr>
            <th>EDH ID</th>
            <th>LIN</th>
            <th>Name</th>
            <th>Class</th>
            <th>Gender</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['edh_id']; ?></td>
                <td><?php echo $row['LIN']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['class_name']; ?></td>
                <td><?php echo $row['gender']; ?></td>
                <td>
                    <a href="?page=edit_student&id=<?php echo $row['student_id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="scripts/delete_student.php?id=<?php echo $row['student_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php
$conn->close();
?>
