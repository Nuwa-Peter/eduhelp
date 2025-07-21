<?php
session_start();
require_once '../config.php';
require_once '../vendor/autoload.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['headteacher', 'teacher'])) {
    die('Access denied.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $school_id = $_SESSION['school_id'];

    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $school = $conn->query("SELECT * FROM schools WHERE school_id = $school_id")->fetch_assoc();
    $student = $conn->query("SELECT s.*, c.class_name FROM students s JOIN classes c ON s.class_id = c.class_id WHERE s.student_id = $student_id AND s.school_id = $school_id")->fetch_assoc();
    $marks = $conn->query("
        SELECT m.mark, m.remarks, s.subject_name
        FROM marks m
        JOIN subjects s ON m.subject_id = s.subject_id
        WHERE m.student_id = $student_id
    ");

    // create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('EduHelp');
    $pdf->SetTitle('Report Card - ' . $student['name']);
    $pdf->SetSubject('Report Card');

    // add a page
    $pdf->AddPage();

    // set font
    $pdf->SetFont('helvetica', '', 12);

    // School Info
    $html = '<h1>' . $school['name'] . '</h1>';
    $html .= '<p>' . $school['address'] . '<br>Email: ' . $school['contact_email'] . '<br>Phone: ' . $school['contact_phone'] . '</p>';
    $html .= '<hr>';

    // Student Info
    $html .= '<h2>Student Report Card</h2>';
    $html .= '<p><b>Name:</b> ' . $student['name'] . '<br>';
    $html .= '<b>EDH ID:</b> ' . $student['edh_id'] . '<br>';
    $html .= '<b>LIN:</b> ' . $student['LIN'] . '<br>';
    $html .= '<b>Class:</b> ' . $student['class_name'] . '</p>';

    // Marks Table
    $html .= '<table border="1" cellpadding="5">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Mark</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>';

    $total_marks = 0;
    $num_subjects = 0;
    while ($row = $marks->fetch_assoc()) {
        $html .= '<tr>
                    <td>' . $row['subject_name'] . '</td>
                    <td>' . $row['mark'] . '</td>
                    <td>' . $row['remarks'] . '</td>
                  </tr>';
        $total_marks += $row['mark'];
        $num_subjects++;
    }

    $html .= '</tbody></table>';

    // Average and Grade
    if ($num_subjects > 0) {
        $average = $total_marks / $num_subjects;
        $html .= '<p><b>Average Mark:</b> ' . number_format($average, 2) . '</p>';
    }

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // ---------------------------------------------------------

    //Close and output PDF document
    $pdf_path = '../uploads/report_cards/' . $student['edh_id'] . '.pdf';
    $pdf->Output($pdf_path, 'F');

    // Save report card info to database
    $stmt = $conn->prepare("INSERT INTO report_cards (student_id, pdf_path) VALUES (?, ?)");
    $stmt->bind_param("is", $student_id, $pdf_path);
    $stmt->execute();
    $stmt->close();

    $conn->close();

    // a little javascript to trigger the download
    echo "<script>window.open('$pdf_path', '_blank');</script>";
    // and redirect back to the reports page
    echo "<script>window.location.href = '../?page=reports';</script>";

} else {
    header('Location: ../?page=reports');
    exit;
}
?>
