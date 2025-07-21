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

$grading_scales = $conn->query("SELECT * FROM grading_scales WHERE school_id = $school_id");
?>

<h1>Grading Scales</h1>

<div class="row">
    <div class="col-md-4">
        <h2>Add Grading Scale</h2>
        <form action="scripts/add_grading_scale.php" method="POST">
            <div class="mb-3">
                <label for="scale_name" class="form-label">Scale Name</label>
                <input type="text" class="form-control" id="scale_name" name="scale_name" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Scale</button>
        </form>
    </div>
    <div class="col-md-8">
        <h2>Existing Scales</h2>
        <ul class="list-group">
            <?php while ($scale = $grading_scales->fetch_assoc()): ?>
                <li class="list-group-item">
                    <h5><?php echo $scale['scale_name']; ?></h5>
                    <a href="?page=grading_scale_levels&id=<?php echo $scale['grading_scale_id']; ?>" class="btn btn-sm btn-secondary">Manage Levels</a>
                    <a href="scripts/delete_grading_scale.php?id=<?php echo $scale['grading_scale_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</div>

<?php
$conn->close();
?>
