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

$teachers = $conn->query("SELECT * FROM users WHERE school_id = $school_id AND role = 'teacher'");
$classes = $conn->query("SELECT * FROM classes WHERE school_id = $school_id");
$subjects = $conn->query("SELECT * FROM subjects WHERE school_id = $school_id");

$assignments = $conn->query("
    SELECT ts.teacher_id, ts.class_id, ts.subject_id, u.username, c.class_name, s.subject_name
    FROM teacher_subjects ts
    JOIN users u ON ts.teacher_id = u.user_id
    JOIN classes c ON ts.class_id = c.class_id
    JOIN subjects s ON ts.subject_id = s.subject_id
    WHERE u.school_id = $school_id
");
?>

<h1>Teacher Subject Assignments</h1>

<div class="row">
    <div class="col-md-4">
        <h2>Assign Teacher to Subject</h2>
        <form action="scripts/assign_teacher_subject.php" method="POST">
            <div class="mb-3">
                <label for="teacher_id" class="form-label">Teacher</label>
                <select class="form-select" id="teacher_id" name="teacher_id" required>
                    <?php while ($row = $teachers->fetch_assoc()): ?>
                        <option value="<?php echo $row['user_id']; ?>"><?php echo $row['username']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="class_id" class="form-label">Class</label>
                <select class="form-select" id="class_id" name="class_id" required>
                    <?php mysqli_data_seek($classes, 0); ?>
                    <?php while ($row = $classes->fetch_assoc()): ?>
                        <option value="<?php echo $row['class_id']; ?>"><?php echo $row['class_name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="subject_id" class="form-label">Subject</label>
                <select class="form-select" id="subject_id" name="subject_id" required>
                    <?php mysqli_data_seek($subjects, 0); ?>
                    <?php while ($row = $subjects->fetch_assoc()): ?>
                        <option value="<?php echo $row['subject_id']; ?>"><?php echo $row['subject_name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Assign</button>
        </form>
    </div>
    <div class="col-md-8">
        <h2>Current Assignments</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Teacher</th>
                    <th>Class</th>
                    <th>Subject</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $assignments->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['class_name']; ?></td>
                        <td><?php echo $row['subject_name']; ?></td>
                        <td>
                            <a href="scripts/unassign_teacher_subject.php?teacher_id=<?php echo $row['teacher_id']; ?>&class_id=<?php echo $row['class_id']; ?>&subject_id=<?php echo $row['subject_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to unassign this teacher?')">Unassign</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$conn->close();
?>
