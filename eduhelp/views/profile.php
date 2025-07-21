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

$user = $conn->query("SELECT * FROM users WHERE user_id = $user_id")->fetch_assoc();
?>

<h1>Edit Profile</h1>

<form action="scripts/update_profile.php" method="POST">
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username']; ?>" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required>
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Phone</label>
        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $user['phone']; ?>">
    </div>
    <hr>
    <h5 class="card-title">Change Password</h5>
    <div class="mb-3">
        <label for="current_password" class="form-label">Current Password</label>
        <input type="password" class="form-control" id="current_password" name="current_password">
    </div>
    <div class="mb-3">
        <label for="new_password" class="form-label">New Password</label>
        <input type="password" class="form-control" id="new_password" name="new_password">
    </div>
    <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirm New Password</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password">
    </div>
    <button type="submit" class="btn btn-primary">Update Profile</button>
</form>

<?php
$conn->close();
?>
