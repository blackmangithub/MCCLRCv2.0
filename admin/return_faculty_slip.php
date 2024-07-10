<?php 
include('authentication.php');

$firstname = $_GET['firstname'];
$book_ids = explode(',', $_GET['book_ids']);

// Prevent SQL injection
$firstname_safe = mysqli_real_escape_string($con, $firstname);

$user_query = mysqli_query($con, "SELECT * FROM faculty WHERE firstname = '$firstname_safe'");
$faculty_row = mysqli_fetch_array($user_query);

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
     <link rel="stylesheet" href="assets/css/dataTables.bootstrap5.min.css">

     <!-- Custom CSS -->
     <link href="assets/css/style.css" rel="stylesheet" />

     <!-- Bootstrap Datepicker -->
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
                    <a href="circulation_faculty_return.php" id="back" class="btn btn-primary">Back</a>
                    </div>
                        <div class="text-end mt-5">
                            <h5>Date: <?php echo date('F d, Y'); ?></h5>
                        </div>
                        <div class="text-center mt-5">
                            <h4 style="font-weight:bold;">Return Slip</h4>
                        </div>
                        <div class="text-center mt-5">
                            <h5>This to acknowledge that <span style="font-weight: 700;"><?php echo htmlspecialchars($faculty_row['firstname'].' '.$faculty_row['middlename'].' '.$faculty_row['lastname']); ?></span>
                            <br>has returned the following books below:</h5>
                        </div>
                        <div class="table-responsive mt-5">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Date Borrowed</th>
                                    <th>Due Date</th>
                                    <th>Date Returned</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    foreach ($book_ids as $book_id) {
                                        // Prevent SQL injection
                                        $book_id_safe = mysqli_real_escape_string($con, $book_id);

                                        $return_query = mysqli_query($con, "SELECT * FROM return_book LEFT JOIN book ON return_book.book_id = book.book_id WHERE return_book.book_id = '$book_id_safe' AND return_book.faculty_id = '".$faculty_row['faculty_id']."'");
                                        $return_row = mysqli_fetch_array($return_query);
                                        if ($return_row) {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($return_row['title']); ?></td>
                                        <td><?php echo htmlspecialchars($return_row['author']); ?></td>
                                        <td><?php echo date("M d, Y", strtotime($return_row['date_borrowed'])); ?></td>
                                        <td><?php echo date("M d, Y", strtotime($return_row['due_date'])); ?></td>
                                        <td><?php echo date("M d, Y", strtotime($return_row['date_returned'])); ?></td>
                                    </tr>
                                    <?php 
                                        }
                                    } 
                                    ?>
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

    <?php 
    include('./includes/script.php');
    include('./message.php');   
    ?>
</body>
</html>
