<?php
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'headteacher') {
    header('Location: ?page=login');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: ?page=grading_scales');
    exit;
}

$school_id = $_SESSION['school_id'];
$scale_id = $_GET['id'];

$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$scale = $conn->query("SELECT * FROM grading_scales WHERE grading_scale_id = $scale_id AND school_id = $school_id")->fetch_assoc();
$levels = $conn->query("SELECT * FROM grading_scale_levels WHERE grading_scale_id = $scale_id");
?>

<h1>Manage Levels for <?php echo $scale['scale_name']; ?></h1>

<div class="row">
    <div class="col-md-4">
        <h2>Add Level</h2>
        <form action="scripts/add_grading_scale_level.php" method="POST">
            <input type="hidden" name="grading_scale_id" value="<?php echo $scale_id; ?>">
            <div class="mb-3">
                <label for="level_name" class="form-label">Level Name</label>
                <input type="text" class="form-control" id="level_name" name="level_name" required>
            </div>
            <div class="mb-3">
                <label for="min_score" class="form-label">Min Score</label>
                <input type="number" class="form-control" id="min_score" name="min_score" required>
            </div>
            <div class="mb-3">
                <label for="max_score" class="form-label">Max Score</label>
                <input type="number" class="form-control" id="max_score" name="max_score" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Level</button>
        </form>
    </div>
    <div class="col-md-8">
        <h2>Existing Levels</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Level Name</th>
                    <th>Min Score</th>
                    <th>Max Score</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($level = $levels->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $level['level_name']; ?></td>
                        <td><?php echo $level['min_score']; ?></td>
                        <td><?php echo $level['max_score']; ?></td>
                        <td>
                            <a href="scripts/delete_grading_scale_level.php?id=<?php echo $level['level_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
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
