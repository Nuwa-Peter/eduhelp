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

$classes = $conn->query("SELECT * FROM classes WHERE school_id = $school_id");
?>

<h1>Add Student</h1>

<form action="scripts/add_student.php" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="lin" class="form-label">LIN</label>
                <input type="text" class="form-control" id="lin" name="lin" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="class_id" class="form-label">Class</label>
                <select class="form-select" id="class_id" name="class_id" required>
                    <?php while ($row = $classes->fetch_assoc()): ?>
                        <option value="<?php echo $row['class_id']; ?>"><?php echo $row['class_name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-select" id="gender" name="gender" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="date" class="form-control" id="dob" name="dob" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="parent_contact" class="form-label">Parent Contact</label>
                <input type="text" class="form-control" id="parent_contact" name="parent_contact" required>
            </div>
        </div>
    </div>
    <div class="mb-3">
        <label for="photo" class="form-label">Photo</label>
        <input type="file" class="form-control" id="photo" name="photo">
    </div>
    <button type="submit" class="btn btn-primary">Add Student</button>
</form>

<?php
$conn->close();
?>
