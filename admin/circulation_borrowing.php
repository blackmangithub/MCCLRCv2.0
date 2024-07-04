<?php 
include('authentication.php');
include('includes/header.php'); 
include('./includes/sidebar.php'); 

error_reporting(0);

if (isset($_SESSION['auth_admin']['admin_id'])) {
    $id_session = $_SESSION['auth_admin']['admin_id'];
}
$student_id = $_GET['student_id'];

$user_query = mysqli_query($con, "SELECT * FROM user WHERE student_id_no = '$student_id'");
$user_row = mysqli_fetch_array($user_query);
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Circulation</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="circulation.php">Circulation</a></li>
                <li class="breadcrumb-item active">Borrow Book</li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="col-12 col-md-6 mt-2">
                            <form action="" method="POST">
                                <div class="input-group mb-3 input-group-sm">
                                    <span class="input-group-text bg-primary text-white" id="basic-addon1">ACCESSION NO.</span>
                                    <input type="text" name="barcode" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" autofocus required>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        $query = "SELECT * FROM user WHERE student_id_no = '$student_id'";
                        $query_run = mysqli_query($con, $query);

                        if ($query_run) {
                            $row = mysqli_fetch_array($query_run);
                            ?>
                            <div class="text-muted mt-3">Student Name&nbsp;: &nbsp;<span class="h5 text-primary p-0 m-0 text-uppercase fw-semibold"><?php echo $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname']; ?></span></div>
                            <div class="text-muted">Course&emsp;&emsp;&emsp;&ensp;&nbsp;:&ensp;<span class="text-dark"><?= $row['course']; ?></span></div>
                            <div class="text-muted mb-5">Year Level&emsp;&emsp;&nbsp;:&ensp;<span class="text-dark"><?= $row['year_level']; ?></span></div>
                            <?php
                        } else {
                            echo "No rows returned";
                        }
                        ?>

                        <div class="table-responsive">
                            <table class="table">
                                <form method="POST" action="">
                                    <thead class="border-top border-dark border-opacity-25">
                                        <tr>
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th>Copyright Date</th>
                                            <th>Publisher</th>
                                            <th>Accession No.</th>
                                            <th>Barcode</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider">
                                        <?php 
                                        if (isset($_POST['barcode'])) {
                                            $barcode = $_POST['barcode'];

                                            $book_query = mysqli_query($con, "SELECT * FROM book WHERE accession_number = '$barcode'");
                                            $book_count = mysqli_num_rows($book_query);
                                            $book_row = mysqli_fetch_array($book_query);

                                            if ($book_count == 0) {
                                                echo '
                                                    <tr>
                                                        <td colspan="8" class="alert alert-info">No match for the accession number entered!</td>
                                                    </tr>
                                                ';
                                            } else {
                                                ?>
                                                <tr>
                                                    <input type="hidden" name="user_id" value="<?php echo $user_row['user_id'] ?>">
                                                    <input type="hidden" name="accession_number" value="<?php echo $book_row['accession_number'] ?>">

                                                    <td>
                                                        <center>
                                                            <?php if ($book_row['book_image'] != ""): ?>
                                                                <img src="../uploads/books_img/<?php echo $book_row['book_image']; ?>" alt="" width="80px" height="80px">
                                                            <?php else: ?>
                                                                <img src="../uploads/books_img/book_image.jpg" alt="" width="80px" height="80px">
                                                            <?php endif; ?>
                                                        </center>
                                                    </td>
                                                    <td><?php echo $book_row['title'] ?></td>
                                                    <td><?php echo $book_row['author'] ?></td>
                                                    <td><?php echo $book_row['copyright_date'] ?></td>
                                                    <td><?php echo $book_row['publisher'] ?></td>
                                                    <td><?php echo $book_row['accession_number'] ?></td>
                                                    <td><?php echo $book_row['barcode'] ?></td>
                                                    <td><button name="borrow" class="btn btn-primary"><i class="fa fa-check"></i> Borrow</button></td>
                                                </tr>
                                            <?php } }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php 
    include('./includes/footer.php');
    include('./includes/script.php');
    include('message.php');   

    if (isset($_POST['borrow'])) {
        $user_id = $_POST['user_id'];
        $accession_number = $_POST['accession_number'];

        // Insert into borrow_book table
        $date_borrowed = date("Y-m-d H:i:s");
        $due_date = date("Y-m-d H:i:s", strtotime("+7 days")); // Example: Due date after 7 days

        mysqli_query($con, "INSERT INTO borrow_book (user_id, book_id, date_borrowed, due_date, borrowed_status) VALUES ('$user_id', '$accession_number', '$date_borrowed', '$due_date', 'borrowed')");

        // Update book status
        mysqli_query($con, "UPDATE book SET status = 'Unavailable' WHERE accession_number = '$accession_number'");

        // Log borrowing action
        $report_history = mysqli_query($con, "SELECT * FROM admin WHERE admin_id = $id_session");
        $report_history_row = mysqli_fetch_array($report_history);
        $admin_name = $report_history_row['firstname'] . " " . $report_history_row['middlename'] . " " . $report_history_row['lastname'];

        mysqli_query($con, "INSERT INTO report (accession_number, user_id, admin_name, detail_action, date_transaction) VALUES ('$accession_number', '$user_id', '$admin_name', 'Borrowed Book', NOW())");

        echo "<script>alert('Book Borrowed Successfully'); window.location='circulation_borrowing.php?student_id=$student_id'</script>";
    }
    ?>
