<?php
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['headteacher', 'teacher'])) {
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

<h1>Generate Report Cards</h1>

<form action="scripts/generate_report_card.php" method="POST" target="_blank">
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="class_id" class="form-label">Class</label>
                <select class="form-select" id="class_id" name="class_id" required>
                    <option value="">Select a class</option>
                    <?php while ($row = $classes->fetch_assoc()): ?>
                        <option value="<?php echo $row['class_id']; ?>"><?php echo $row['class_name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="student_id" class="form-label">Student</label>
                <select class="form-select" id="student_id" name="student_id" required>
                    <option value="">Select a student</option>
                </select>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Generate Report Card</button>
</form>

<script>
$(document).ready(function() {
    $('#class_id').change(function() {
        var class_id = $(this).val();
        if (class_id) {
            $.ajax({
                url: 'scripts/get_students_by_class.php',
                type: 'POST',
                data: {class_id: class_id},
                success: function(data) {
                    $('#student_id').html(data);
                }
            });
        } else {
            $('#student_id').html('<option value="">Select a student</option>');
        }
    });
});
</script>

<?php
$conn->close();
?>
