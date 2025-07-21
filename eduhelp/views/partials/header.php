<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduHelp</title>
    <link rel="icon" href="logo.png" type="image/png">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php if (isset($_SESSION['user_id'])): ?>
        <?php include 'sidebar.php'; ?>
        <div class="container mt-4" style="margin-left: 300px; padding-left: 20px;">
    <?php else: ?>
        <div class="container mt-4">
    <?php endif; ?>
