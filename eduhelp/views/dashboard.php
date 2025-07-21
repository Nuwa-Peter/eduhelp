<?php
if (!isset($_SESSION['user_id'])) {
    header('Location: ?page=login');
    exit;
}

$role = $_SESSION['role'];

switch ($role) {
    case 'superuser':
        include 'admin/dashboard.php';
        break;
    case 'headteacher':
        include 'headteacher/dashboard.php';
        break;
    case 'teacher':
        include 'teacher/dashboard.php';
        break;
    default:
        echo "Invalid role.";
        break;
}
?>
