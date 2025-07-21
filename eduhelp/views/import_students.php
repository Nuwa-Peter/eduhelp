<?php
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'headteacher') {
    header('Location: ?page=login');
    exit;
}
?>

<h1>Import Students</h1>
<p>Upload an Excel file to bulk import students.</p>
<p>Download the template file: <a href="templates/student_template.xlsx">student_template.xlsx</a></p>

<form action="scripts/import_students.php" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="excel_file" class="form-label">Excel File</label>
        <input type="file" class="form-control" id="excel_file" name="excel_file" required>
    </div>
    <button type="submit" class="btn btn-primary">Import Students</button>
</form>
