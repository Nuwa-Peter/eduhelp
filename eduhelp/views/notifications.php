<?php
if (!isset($_SESSION['user_id'])) {
    header('Location: ?page=login');
    exit;
}

$user_id = $_SESSION['user_id'];

$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$notifications = $conn->query("SELECT * FROM notifications WHERE user_id = $user_id ORDER BY created_at DESC");

// Mark notifications as read
$conn->query("UPDATE notifications SET is_read = 1 WHERE user_id = $user_id");
?>

<h1>Notifications</h1>

<div class="list-group">
    <?php while ($row = $notifications->fetch_assoc()): ?>
        <div class="list-group-item">
            <p class="mb-1"><?php echo $row['message']; ?></p>
            <small class="text-muted"><?php echo $row['created_at']; ?></small>
        </div>
    <?php endwhile; ?>
</div>

<?php
$conn->close();
?>
