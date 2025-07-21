<?php
if (!isset($_SESSION['user_id'])) {
    header('Location: ?page=login');
    exit;
}
?>

<h1>Settings</h1>
<p>This page is under construction.</p>
