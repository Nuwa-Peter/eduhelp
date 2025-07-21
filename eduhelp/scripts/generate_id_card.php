<?php
session_start();
require_once '../config.php';
require_once '../vendor/autoload.php';
require_once '../lib/phpqrcode/qrlib.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'headteacher') {
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

    // Generate QR code
    $qr_code_url = SITE_URL . '?page=student&id=' . $student['edh_id'];
    $qr_code_path = '../uploads/qrcodes/' . $student['edh_id'] . '.png';
    QRcode::png($qr_code_url, $qr_code_path, QR_ECLEVEL_L, 4);

    // create new PDF document
    $pdf = new TCPDF('P', PDF_UNIT, [53.98, 85.6], true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('EduHelp');
    $pdf->SetTitle('ID Card - ' . $student['name']);
    $pdf->SetSubject('ID Card');

    // remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    // add a page
    $pdf->AddPage();

    // set font
    $pdf->SetFont('helvetica', '', 10);

    // School Info
    $html = '<div style="text-align:center;">';
    if ($school['logo_path']) {
        $html .= '<img src="../' . $school['logo_path'] . '" height="50"><br>';
    }
    $html .= '<b>' . $school['name'] . '</b></div>';
    $html .= '<hr>';

    // Student Info
    $html .= '<table cellpadding="2">
                <tr>
                    <td rowspan="4" width="30%">';
    if ($student['photo_path']) {
        $html .= '<img src="../' . $student['photo_path'] . '" width="60">';
    }
    $html .= '</td>
                    <td width="70%"><b>Name:</b> ' . $student['name'] . '</td>
                </tr>
                <tr>
                    <td><b>EDH ID:</b> ' . $student['edh_id'] . '</td>
                </tr>
                <tr>
                    <td><b>Class:</b> ' . $student['class_name'] . '</td>
                </tr>
                <tr>
                    <td><img src="' . $qr_code_path . '" width="40"></td>
                </tr>
              </table>';


    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // ---------------------------------------------------------

    //Close and output PDF document
    $pdf_path = '../uploads/id_cards/' . $student['edh_id'] . '.pdf';
    $pdf->Output($pdf_path, 'F');

    // Save ID card info to database
    $stmt = $conn->prepare("INSERT INTO id_cards (student_id, pdf_path, qr_code_url) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $student_id, $pdf_path, $qr_code_url);
    $stmt->execute();
    $stmt->close();

    $conn->close();

    // a little javascript to trigger the download
    echo "<script>window.open('$pdf_path', '_blank');</script>";
    // and redirect back to the id cards page
    echo "<script>window.location.href = '../?page=id_cards';</script>";

} else {
    header('Location: ../?page=id_cards');
    exit;
}
?>
