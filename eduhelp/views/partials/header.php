<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduHelp</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?php echo SITE_URL; ?>">EduHelp</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="?page=dashboard">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?page=profile">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?page=notifications">Notifications</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?page=logout">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="?page=login">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?page=register">Register</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="themeDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Theme
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="themeDropdown">
                            <li><a class="dropdown-item" href="#" data-theme="light">Light</a></li>
                            <li><a class="dropdown-item" href="#" data-theme="dark">Dark</a></li>
                            <li><a class="dropdown-item" href="#" data-theme="auto">Auto</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
