<?php
if (!isset($_GET['token'])) {
    die('No token provided.');
}

$token = $_GET['token'];
?>

<h1>Reset Password</h1>

<form action="scripts/reset_password.php" method="POST">
    <input type="hidden" name="token" value="<?php echo $token; ?>">
    <div class="mb-3">
        <label for="new_password" class="form-label">New Password</label>
        <input type="password" class="form-control" id="new_password" name="new_password" required>
    </div>
    <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirm New Password</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
    </div>
    <button type="submit" class="btn btn-primary">Reset Password</button>
</form>
