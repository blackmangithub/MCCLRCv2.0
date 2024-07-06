<?php
// error_reporting(E_ALL ^ E_NOTICE);

// Include the main TCPDF library (search for installation path).
require('config/dbcon.php');
require_once('tcpdf/tcpdf.php');

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
// ---------------------------------------------------------

// Add a page
$pdf->AddPage();

// Set JPEG quality
$pdf->setJPEGQuality(75);

// Insert an image (change as needed)
$pdf->Image('images/image_demo.jpg', 15, 140, 75, 113, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);

$pdf->Ln(15);
$pdf->setFont('Helvetica', '', '12');
$pdf->Cell(180, 15, 'Date : ' . date("M d, Y"), 0, 1, 'R', 0, '', 0, false, 'M', 'M');
$pdf->Ln(15);

$pdf->setFont('Helvetica', 'B', '13');
$pdf->Cell(0, 10, 'RETURN SLIP', 0, 1, 'C', 0, '', false, 'M', 'M');
$pdf->Ln(15);

// Fetch faculty member details
if (isset($_SESSION['auth_admin']['admin_id'])) {
    $id_session = $_SESSION['auth_admin']['admin_id'];
}

$firstname = $_GET['firstname'];
$user_query = mysqli_query($con, "SELECT * FROM faculty WHERE firstname = '$firstname' ");
$user_row = mysqli_fetch_array($user_query);

// Fetch all books returned by the faculty member
$return_query = mysqli_query($con, "SELECT * FROM return_book 
    LEFT JOIN book ON return_book.book_id = book.book_id 
    LEFT JOIN faculty ON return_book.faculty_id = faculty.faculty_id 
    WHERE faculty.firstname = '$firstname' 
    ORDER BY return_book.return_book_id DESC") or die(mysqli_error($con));

// Check if there are returned books
if (mysqli_num_rows($return_query) > 0) {
    $pdf->setFont('Helvetica', '', '12');
    $pdf->Cell(0, 10, 'This is to acknowledge that ' . $user_row['firstname'] . ' ' . $user_row['middlename'] . ' ' . $user_row['lastname'], 0, 1, 'C', 0, '', false, 'M', 'M');
    $pdf->Cell(0, 10, 'has returned the following books:', 0, 1, 'C', 0, '', false, 'M', 'M');

    $pdf->Ln(10);
    $tbl = <<<EOD
    <table border="1" cellpadding="2">
    <tr>
        <th width="40%" style="font-size:10px; text-align:center; vertical-align:middle; font-weight:bold;">Title</th>
        <th width="15%" style="font-size:10px; text-align:center; vertical-align:middle; font-weight:bold;">Author</th>
        <th width="15%" style="font-size:10px; text-align:center; vertical-align:middle; font-weight:bold;">Date Borrowed</th>
        <th width="15%" style="font-size:10px; text-align:center; vertical-align:middle; font-weight:bold;">Due Date</th>
        <th width="15%" style="font-size:10px; text-align:center; vertical-align:middle; font-weight:bold;">Date Returned</th>
    </tr>
    EOD;

    // Loop through each returned book and add to the table
    while ($return_row = mysqli_fetch_array($return_query)) {
        $title = $return_row['title'];
        $author = $return_row['author'];
        $date_borrowed = date("M d, Y", strtotime($return_row['date_borrowed']));
        $due_date = date("M d, Y", strtotime($return_row['due_date']));
        $date_returned = date("M d, Y", strtotime($return_row['date_returned']));

        $tbl .= <<<EOD
        <tr>
            <td style="font-size:10px; text-align:center; vertical-align:middle;">$title</td>
            <td style="font-size:10px; text-align:center; vertical-align:middle;">$author</td>
            <td style="font-size:10px; text-align:center; vertical-align:middle;">$date_borrowed</td>
            <td style="font-size:10px; text-align:center; vertical-align:middle;">$due_date</td>
            <td style="font-size:10px; text-align:center; vertical-align:middle;">$date_returned</td>
        </tr>
        EOD;
    }

    $tbl .= '</table>';

    // Add the HTML table to the PDF
    $pdf->writeHTML($tbl, true, false, false, false, '');
} else {
    $pdf->setFont('Helvetica', '', '12');
    $pdf->Cell(0, 10, 'No books returned by ' . $user_row['firstname'] . ' ' . $user_row['middlename'] . ' ' . $user_row['lastname'], 0, 1, 'C', 0, '', false, 'M', 'M');
}

$pdf->Ln(20);
$pdf->setFont('Helvetica', '', '12');
$pdf->Cell(180, 15, '________________', 0, 1, 'R', 0, '', 0, false, 'M', 'M');
$pdf->Cell(180, 15, 'Signature', 0, 1, 'R', 0, '', 0, false, 'M', 'M');
// ---------------------------------------------------------

// Close and output PDF document
$pdf->Output('penalty_receipt.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>
