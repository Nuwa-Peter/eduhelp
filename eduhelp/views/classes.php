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

$classes = $conn->query("SELECT * FROM classes WHERE school_id = $school_id ORDER BY class_level, class_name");
?>

<h1>Manage Classes</h1>

<div class="row">
    <div class="col-md-4">
        <h2>Add Class</h2>
        <form action="scripts/add_class.php" method="POST">
            <div class="mb-3">
                <label for="class_level" class="form-label">Class Level</label>
                <select class="form-select" id="class_level" name="class_level" required>
                    <option value="Nursery">Nursery</option>
                    <option value="Primary">Primary</option>
                    <option value="Secondary">Secondary</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="class_name" class="form-label">Class Name</label>
                <input type="text" class="form-control" id="class_name" name="class_name" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Class</button>
        </form>
    </div>
    <div class="col-md-8">
        <h2>Existing Classes</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Class Level</th>
                    <th>Class Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($class = $classes->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $class['class_level']; ?></td>
                        <td><?php echo $class['class_name']; ?></td>
                        <td>
                            <a href="scripts/delete_class.php?id=<?php echo $class['class_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
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
