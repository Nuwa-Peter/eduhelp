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

<h1>Send Bulk SMS</h1>

<form action="scripts/send_sms.php" method="POST">
    <div class="mb-3">
        <label for="recipients" class="form-label">Recipients</label>
        <select class="form-select" id="recipients" name="recipients" required>
            <option value="all_parents">All Parents</option>
            <option value="all_teachers">All Teachers</option>
            <?php while ($row = $classes->fetch_assoc()): ?>
                <option value="class_<?php echo $row['class_id']; ?>">Parents of <?php echo $row['class_name']; ?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="message" class="form-label">Message</label>
        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Send SMS</button>
</form>

<?php
$conn->close();
?>
