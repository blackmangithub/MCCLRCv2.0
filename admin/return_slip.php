<?php 
include('authentication.php');

$student_id = $_GET['student_id'];
$book_ids = explode(',', $_GET['book_ids']);

$user_query = mysqli_query($con, "SELECT * FROM user WHERE student_id_no = '$student_id' ");
$user_row = mysqli_fetch_array($user_query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8" />
     <meta http-equiv="X-UA-Compatible" content="IE=edge" />
     <meta name="viewport" content="width=device-width, initial-scale=1.0" />
     <meta name="robots" content="noindex, nofollow" />
     <link rel="icon" href="./assets/img/mcc-logo.png">
     <link href="https://fonts.gstatic.com" rel="preconnect" />
     <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i"
          rel="stylesheet" />
     <!-- Bootstrap CSS -->
     <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

     <!-- Boxicons Icon -->
     <link href="assets/css/boxicons.min.css" rel="stylesheet" />

     <!-- Remixicon Icon -->
     <link href="assets/css/remixicon.css" rel="stylesheet" />

     <!-- Bootstrap Icon -->
     <link rel="stylesheet" href="assets/font/bootstrap-icons.css">

     <!-- Alertify JS link -->
     <link rel="stylesheet" href="assets/css/alertify.min.css" />
     <link rel="stylesheet" href="assets/css/alertify.bootstraptheme.min.css" />
     <!-- Datatables -->
     <link rel="stylesheet" href="assets/css/bootstrap.min.css">
     <link rel="stylesheet" href="assets/css/dataTables.bootstrap5.min.css">

     <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" />
     <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/buttons/2.3.3/css/buttons.bootstrap5.min.css" />

     <!-- Custom CSS -->
     <link href="assets/css/style.css" rel="stylesheet" />

     <!-- Animation -->
     <link rel="stylesheet" href="https://www.cssportal.com/css-loader-generator/" />
     <!-- Loader -->
     <link rel="stylesheet" href="https://www.cssportal.com/css-loader-generator/" />

     <link rel="stylesheet" href="assets/css/bootstrap-datepicker.min.css">
     
     <style>
         @media print {
             .print-button {
                 display: none;
             }
             #back {
                display: none;
             }
             @page {
                 margin: 0;
             }
             body {
                 margin: 0;
                 padding: 20px;
             }
         }
     </style>

</head>

<body>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                    <div class="text-start mt-3">
                    <a href="circulation_return.php" id="back" class="btn btn-primary">Back</a>
                    </div>
                        <div class="text-end mt-5">
                            <h5>Date: <?php echo date('F d, Y'); ?></h5>
                        </div>
                        <div class="text-center mt-5">
                            <h4 style="font-weight:bold;">Return Slip</h4>
                        </div>
                        <div class="text-center mt-5">
                            <h5>This to acknowledge that <span style="font-weight: 700;"><?php echo $user_row['firstname'].' '.$user_row['middlename'].' '.$user_row['lastname']; ?></span>
                        <br>has returned the following books below:</h5>
                        </div>
                        <div class="table-responsive mt-5">
                            <table border="1" cellpadding="2" class="table">
                                <thead>
                                <tr>
                                    <th colspan="5" style="font-size:15px; font-weight:bold;text-align:center;" >BORROWED BOOK DETAILS</th>
                                </tr>
                                <tr>
                                    <th style="font-size:15px;">Title</th>
                                    <th style="font-size:15px;">Author</th>
                                    <th style="font-size:15px;">Date Borrowed</th>
                                    <th style="font-size:15px;">Due Date</th>
                                    <th style="font-size:15px;">Date Returned</th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    foreach ($book_ids as $book_id) {
                                        $return_query = mysqli_query($con, "SELECT * FROM return_book LEFT JOIN book ON return_book.book_id = book.book_id WHERE return_book.book_id = '$book_id' AND return_book.user_id = '".$user_row['user_id']."'");
                                        $return_row = mysqli_fetch_array($return_query);
                                    ?>
                                    <tr>
                                        <td><?php echo $return_row['title']; ?></td>
                                        <td style="text-transform: capitalize"><?php echo $return_row['author']; ?></td>
                                        <td><?php echo date("M d, Y", strtotime($return_row['date_borrowed'])); ?></td>
                                        <td><?php echo date("M d, Y", strtotime($return_row['due_date'])); ?></td>
                                        <td><?php echo date("M d, Y", strtotime($return_row['date_returned'])); ?></td>
                                        
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-5">
                            <div class="col text-end">
                                <p>__________________________</p>
                                <p style="margin-right: 50px;">Signature</p>
                            </div>
                        </div>
                        <div class="text-center mt-5">
                            <button onclick="window.print()" class="btn btn-primary print-button">Print</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php 
include('./includes/script.php');
include('./message.php');   
?>
</body>
</html>
