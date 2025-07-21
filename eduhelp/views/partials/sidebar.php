<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px; height: 100vh; position: fixed;">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <img src="logo_light.png" alt="EduHelp Logo" width="32" height="32" class="me-2" id="sidebar-logo">
        <span class="fs-4">EduHelp</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <?php if (isset($_SESSION['user_id'])): ?>
            <?php if ($_SESSION['role'] === 'superuser'): ?>
                <li class="nav-item">
                    <a href="?page=dashboard" class="nav-link text-white <?php if ($page === 'dashboard') echo 'active'; ?>">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="?page=schools" class="nav-link text-white <?php if ($page === 'schools') echo 'active'; ?>">
                        Schools
                    </a>
                </li>
            <?php elseif ($_SESSION['role'] === 'headteacher'): ?>
                <li class="nav-item">
                    <a href="?page=dashboard" class="nav-link text-white <?php if ($page === 'dashboard') echo 'active'; ?>">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="?page=students" class="nav-link text-white <?php if ($page === 'students') echo 'active'; ?>">
                        Students
                    </a>
                </li>
                <li>
                    <a href="?page=teachers" class="nav-link text-white <?php if ($page === 'teachers') echo 'active'; ?>">
                        Teachers
                    </a>
                </li>
                <li>
                    <a href="?page=classes" class="nav-link text-white <?php if ($page === 'classes') echo 'active'; ?>">
                        Classes
                    </a>
                </li>
                <li>
                    <a href="?page=subjects" class="nav-link text-white <?php if ($page === 'subjects') echo 'active'; ?>">
                        Subjects
                    </a>
                </li>
                <li>
                    <a href="?page=teacher_subjects" class="nav-link text-white <?php if ($page === 'teacher_subjects') echo 'active'; ?>">
                        Teacher Assignments
                    </a>
                </li>
                <li>
                    <a href="?page=reports" class="nav-link text-white <?php if ($page === 'reports') echo 'active'; ?>">
                        Report Cards
                    </a>
                </li>
                <li>
                    <a href="?page=id_cards" class="nav-link text-white <?php if ($page === 'id_cards') echo 'active'; ?>">
                        ID Cards
                    </a>
                </li>
                <li>
                    <a href="?page=sms" class="nav-link text-white <?php if ($page === 'sms') echo 'active'; ?>">
                        Bulk SMS
                    </a>
                </li>
                <li>
                    <a href="?page=grading_scales" class="nav-link text-white <?php if ($page === 'grading_scales') echo 'active'; ?>">
                        Grading Scales
                    </a>
                </li>
            <?php elseif ($_SESSION['role'] === 'teacher'): ?>
                <li class="nav-item">
                    <a href="?page=dashboard" class="nav-link text-white <?php if ($page === 'dashboard') echo 'active'; ?>">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="?page=marks" class="nav-link text-white <?php if ($page === 'marks') echo 'active'; ?>">
                        Enter Marks
                    </a>
                </li>
                <li>
                    <a href="?page=reports" class="nav-link text-white <?php if ($page === 'reports') echo 'active'; ?>">
                        View Reports
                    </a>
                </li>
            <?php endif; ?>
        <?php else: ?>
            <li class="nav-item">
                <a href="?page=login" class="nav-link text-white <?php if ($page === 'login') echo 'active'; ?>">
                    Login
                </a>
            </li>
            <li class="nav-item">
                <a href="?page=register" class="nav-link text-white <?php if ($page === 'register') echo 'active'; ?>">
                    Register
                </a>
            </li>
        <?php endif; ?>
    </ul>
    <hr>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <?php if (isset($_SESSION['user_id'])): ?>
                <strong><?php echo $_SESSION['role']; ?></strong>
            <?php else: ?>
                <strong>Guest</strong>
            <?php endif; ?>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a class="dropdown-item" href="?page=profile">Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="?page=logout">Sign out</a></li>
            <?php else: ?>
                <li><a class="dropdown-item" href="?page=login">Sign in</a></li>
            <?php endif; ?>
        </ul>
    </div>
    </div>
</div>
