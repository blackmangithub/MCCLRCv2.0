<?php
// error_reporting(E_ALL ^ E_NOTICE);

 // Include the main TCPDF library (search for installation path).
 require('config/dbcon.php');
require_once('tcpdf/tcpdf.php');





// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
// ---------------------------------------------------------


// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set JPEG quality
$pdf->setJPEGQuality(75);


// Image method signature:
// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
$pdf->Image('images/image_demo.jpg', 15, 140, 75, 113, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);


$pdf->Ln(15);
$pdf->setFont('Helvetica', '', '12');
$pdf->Cell(180, 15, 'Date : '.date("M d, Y"), 0, 1, 'R', 0, '', 0, false, 'M', 'M');
$pdf->Ln(15);

$pdf->setFont('Helvetica', 'B', '13');
$pdf->Cell(0, 10, 'RETURN SLIP', 0, 1, 'C', 0, '', false, 'M', 'M' );
$pdf->Ln(15);

if (isset($_SESSION['auth_admin']['admin_id']))
{
     $id_session=$_SESSION['auth_admin']['admin_id'];

 }

$employee_id = $_GET['employee_id'];

$user_query = mysqli_query($con,"SELECT * FROM faculty WHERE employee_id_no = '$employee_id' ");
$user_row = mysqli_fetch_array($user_query);

    $return_query= mysqli_query($con,"SELECT * FROM return_book 
        LEFT JOIN book ON return_book.book_id = book.book_id 
        LEFT JOIN faculty ON return_book.faculty_id = faculty.faculty_id 
        WHERE return_book.return_book_id order by return_book.return_book_id DESC") or die (mysqli_error());
        if($return_query)
        {

      
        $return_row = mysqli_fetch_array($return_query);



        $borrower = $user_row['firstname'].' '.$user_row['middlename'].' '.$user_row['lastname'];
        $penalty = 'Php '.$return_row['book_penalty'];


        $title = $return_row['title'];
        $author = $return_row['author'];
        $date_borrowed = date("M d, Y h:m:s a",strtotime($return_row['date_borrowed']));
        $due_date = date("M d, Y h:m:s a",strtotime($return_row['due_date']));
        $date_returned = date("M d, Y h:m:s a",strtotime($return_row['date_returned']));

        $pdf->setFont('Helvetica', '', '12');
        $pdf->Cell(0, 10, 'This to acknowledge that '.$borrower, 0, 1, 'C', 0, '', false, 'M', 'M' );
        $pdf->Cell(0, 10, 'has return the following books bellow: ', 0, 1, 'C', 0, '', false, 'M', 'M');


$pdf->Ln(10);
$tbl = <<<EOD
        <table border="1" cellpading="2">
        <tr>
            <th colspan="5"  align="center" style="font-size:10px; font-weight:bold;" >BORROWED BOOK DETAILS</th>
        </tr>
        <tr>
            <td width="40%" style="font-size:10px; text-align:center; vertical-align:middle; ">Title</td>
            <td width="15%" style="font-size:10px; text-align:center; vertical-align:middle; ">Author</td>
            <td width="15%" style="font-size:10px; text-align:center; vertical-align:middle; ">Date Borrowed</td>
            <td width="15%" style="font-size:10px; text-align:center; vertical-align:middle; ">Due Date</td>
            <td width="15%" style="font-size:10px; text-align:center; vertical-align:middle; ">Date Returned</td>
        </tr>
        <tr>
            <td width="40%" style="font-size:10px; text-align:center; vertical-align:middle; ">$title</td>
            <td width="15%" style="font-size:10px; text-align:center; vertical-align:middle; ">$author</td>
            <td width="15%" style="font-size:10px; text-align:center; vertical-align:middle; ">$date_borrowed</td>
            <td width="15%" style="font-size:10px; text-align:center; vertical-align:middle; ">$due_date</td>
            <td width="15%" style="font-size:10px; text-align:center; vertical-align:middle; ">$date_returned</td>        
        </tr>
        
        </table>
        EOD;



       
    //     $return_query= mysqli_query($con,"select * from return_book 
    //     LEFT JOIN book ON return_book.book_id = book.book_id 
    //     LEFT JOIN user ON return_book.user_id = user.user_id 
    //     where return_book.return_book_id order by return_book.return_book_id DESC") or die (mysqli_error());

    //     if($return_query)
    //     {
    //         while($row = mysqli_fetch_assoc($return_query))
    //         {
                    
           
       
        // $tbl .= <<<EOD 
        // <tr>
        //     <td width="16.66%" style="font-size:10px; text-align:center; vertical-align:middle; font-weight:bold;"></td>
        //     <td width="16.66%" style="font-size:10px; text-align:center; vertical-align:middle; font-weight:bold;">Author</td>
        //     <td width="16.66%" style="font-size:10px; text-align:center; vertical-align:middle; font-weight:bold;">Date Borrowed</td>
        //     <td width="16.66%" style="font-size:10px; text-align:center; vertical-align:middle; font-weight:bold;">Due Date</td>
        //     <td width="16.66%" style="font-size:10px; text-align:center; vertical-align:middle; font-weight:bold;">Date Returned</td>
        //     <td width="16.66%" style="font-size:10px; text-align:center; vertical-align:middle; font-weight:bold;">Penalty</td>
        // </tr>
        
        // EOD;
        //     }
    }
$pdf->writeHTML($tbl, true, false, false, false, '');

$pdf->Ln(20);
$pdf->setFont('Helvetica', '', '12');
$pdf->Cell(180, 15, '________________', 0, 1, 'R', 0, '', 0, false, 'M', 'M');
$pdf->Cell(180, 15, 'Signature       ', 0, 1, 'R', 0, '', 0, false, 'M', 'M');
// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('penalty_receipt.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>