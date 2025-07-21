<?php
session_start();

// Default theme
$default_theme = 'auto';

// Check if theme is set in session, otherwise use default
if (!isset($_SESSION['theme'])) {
    $_SESSION['theme'] = $default_theme;
}

// Handle theme change request
if (isset($_POST['theme'])) {
    $theme = $_POST['theme'];
    if (in_array($theme, ['light', 'dark', 'auto'])) {
        $_SESSION['theme'] = $theme;
    }
}

// Determine the theme to apply
$theme = $_SESSION['theme'];
$theme_class = $theme === 'auto' ? '' : $theme;

// include the config file
require_once 'config.php';

// Get the requested page
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Whitelist of allowed pages
$allowed_pages = [
    'home',
    'login',
    'logout',
    'register',
    'dashboard',
    'students',
    'add_student',
    'edit_student',
    'import_students',
    'teachers',
    'teacher_subjects',
    'classes',
    'subjects',
    'student',
    'reports',
    'id_cards',
    'sms',
    'settings',
    'profile',
    'payment',
    'forgot_password',
    'reset_password',
    'notifications',
    'grading_scales',
    'grading_scale_levels'
];

// If the requested page is not in the whitelist, show a 404 error
if (!in_array($page, $allowed_pages)) {
    http_response_code(404);
    include 'views/errors/404.php';
    exit;
}

// Include the header
include 'views/partials/header.php';

// Include the page content
if ($page === 'logout') {
    include 'scripts/logout.php';
} else {
    include 'views/' . $page . '.php';
}

// Include the footer
include 'views/partials/footer.php';
?>
