<!DOCTYPE html>
<html lang="en" data-bs-theme="<?php echo $theme; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduHelp</title>
    <link rel="icon" href="logo.png" type="image/png">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="<?php echo htmlspecialchars($theme_class); ?>">
    <?php if (isset($_SESSION['user_id'])): ?>
        <?php include 'sidebar.php'; ?>
        <div style="margin-left: 280px;">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo $_SESSION['role']; ?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="?page=profile">Profile</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="?page=logout">Logout</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="themeDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Theme
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="themeDropdown">
                                    <li><a class="dropdown-item" href="#" onclick="setTheme('light')">Light</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="setTheme('dark')">Dark</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="setTheme('auto')">Auto</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="container mt-4">
    <?php else: ?>
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="<?php echo SITE_URL; ?>">
                    <img src="logo_light.png" alt="EduHelp Logo" width="32" height="32" class="me-2" id="header-logo">
                    EduHelp
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="?page=login">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?page=register">Register</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="themeDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Theme
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="themeDropdown">
                                <li><a class="dropdown-item" href="#" onclick="setTheme('light')">Light</a></li>
                                <li><a class="dropdown-item" href="#" onclick="setTheme('dark')">Dark</a></li>
                                <li><a class="dropdown-item" href="#" onclick="setTheme('auto')">Auto</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container mt-4">
    <?php endif; ?>
    <form method="POST" id="themeForm" class="d-none">
        <input type="hidden" name="theme" id="themeInput">
    </form>
    <script>
        function setTheme(theme) {
            document.getElementById('themeInput').value = theme;
            document.getElementById('themeForm').submit();
        }
    </script>
