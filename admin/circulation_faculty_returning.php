<?php 
include('authentication.php');
include('includes/header.php'); 
include('./includes/sidebar.php'); 

if (isset($_SESSION['auth_admin']['admin_id'])) {
    $id_session = $_SESSION['auth_admin']['admin_id'];
}

$firstname = $_GET['firstname'];

$faculty_query = mysqli_query($con, "SELECT * FROM faculty WHERE firstname = '$firstname' ");
$faculty_row = mysqli_fetch_array($faculty_query);
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Circulation</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="circulation.php">Circulation</a></li>
                <li class="breadcrumb-item active">Return Book</li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="col-12 col-md-6 mt-2">
                            <!-- Form to handle book return -->
                            <form method="post" action="">
                                <input type="hidden" name="date_returned" class="new_text" id="sd" value="<?php echo date('Y-m-d'); ?>" size="16" maxlength="10" />
                                <input type="hidden" name="faculty_id" value="<?php echo $faculty_row['faculty_id']; ?>">
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        $query = "SELECT * FROM faculty WHERE firstname = '$firstname'";
                        $query_run = mysqli_query($con, $query);

                        if ($query_run) {
                            $row = mysqli_fetch_array($query_run);
                        ?>
                        <div class="text-muted mt-3">Student Name&nbsp;: &nbsp;<span class="h5 text-primary p-0 m-0 text-uppercase fw-semibold"><?php echo $row['firstname'].' '.$row['middlename'].' '.$row['lastname']; ?></span></div>
                        <div class="text-muted">Course&emsp;&emsp;&emsp;&ensp;&nbsp;:&ensp;<span class="text-dark"><?php echo $row['course']; ?></span></div>
                        <?php
                        } else {
                            echo "No rows returned";
                        }
                        ?>

                        <div class="table-responsive">
                            <form method="post" action="">
                                <table class="table">
                                    <thead class="border-top border-dark border-opacity-25">
                                        <tr>
                                            <th>Select</th>
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th>Copyright Date</th>
                                            <th>Publisher</th>
                                            <th>Barcode</th>
                                            <th>Date Borrowed</th>
                                            <th>Due Date</th>
                                            <th>Penalty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $borrow_query = mysqli_query($con, "SELECT * FROM borrow_book LEFT JOIN book ON borrow_book.book_id = book.book_id WHERE faculty_id = '".$faculty_row['faculty_id']."' && borrowed_status = 'borrowed' ORDER BY borrow_book_id DESC");
                                        $borrow_count = mysqli_num_rows($borrow_query);

                                        while ($borrow_row = mysqli_fetch_array($borrow_query)) {
                                            $due_date = $borrow_row['due_date'];

                                            $timezone = "Asia/Manila";
                                            if (function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
                                            $cur_date = date("Y-m-d");
                                            $date_returned = date("Y-m-d");

                                            // Exclude Sundays from due date calculation
                                            $adjusted_due_date = strtotime($due_date);
                                            while (date('N', $adjusted_due_date) == 7) { // N returns 7 for Sunday
                                                $adjusted_due_date = strtotime("+1 day", $adjusted_due_date);
                                            }
                                            $due_date = date("Y-m-d", $adjusted_due_date);

                                            if ($date_returned > $due_date) {
                                                $penalty = 0;
                                                $current_date = strtotime($due_date);
                                                $end_date = strtotime($date_returned);

                                                while ($current_date < $end_date) {
                                                    $current_date = strtotime("+1 day", $current_date);
                                                    if (date('N', $current_date) != 7) { // N returns 7 for Sunday
                                                        $penalty += 5;
                                                    }
                                                }
                                            } else {
                                                $penalty = 'No Penalty';
                                            }
                                        ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="selected_books[]" value="<?php echo $borrow_row['book_id']; ?>">
                                            </td>
                                            <td>
                                                <center>
                                                    <?php if ($borrow_row['book_image'] != ""): ?>
                                                    <img src="../uploads/books_img/<?php echo $borrow_row['book_image']; ?>" alt="" width="80px" height="80px">
                                                    <?php else: ?>
                                                    <img src="../uploads/books_img/book_image.jpg" alt="" width="80px" height="80px">
                                                    <?php endif; ?>
                                                </center>
                                            </td>
                                            <td><?php echo $borrow_row['title']; ?></td>
                                            <td style="text-transform: capitalize"><?php echo $borrow_row['author']; ?></td>
                                            <td style="text-transform: capitalize"><?php echo $borrow_row['copyright_date']; ?></td>
                                            <td><?php echo $borrow_row['publisher']; ?></td>
                                            <td><?php echo $borrow_row['barcode']; ?></td>
                                            <td><?php echo date("M d, Y ", strtotime($borrow_row['date_borrowed'])); ?></td>
                                            <td><?php echo date('M d, Y ', strtotime($borrow_row['due_date'])); ?></td>
                                            <td><?php echo $penalty; ?></td>
                                                <!-- Form to handle individual book return -->
                                                <form method="post" action="">
                                                    <input type="hidden" name="book_id" value="<?php echo $borrow_row['book_id']; ?>">
                                                    <input type="hidden" name="borrow_book_id" value="<?php echo $borrow_row['borrow_book_id']; ?>">
                                                    <input type="hidden" name="date_returned" class="new_text" id="sd" value="<?php echo date('Y-m-d'); ?>" size="16" maxlength="10" />
                                                    <input type="hidden" name="faculty_id" value="<?php echo $faculty_row['faculty_id']; ?>">
                                                </form>
                                        </tr>
                                        <?php 
                                        }
                                        if ($borrow_count <= 0) {
                                            echo '
                                                <table style="width:100%;">
                                                    <tr>
                                                        <td style="padding:10px;" class="alert alert-danger text-center">No books borrowed</td>
                                                    </tr>
                                                </table>
                                            ';
                                        } 
                                        ?>
                                    </tbody>
                                </table>
                                <div class="text-end">
                                <button type="submit" name="return_selected" class="btn btn-primary">Return Selected Books</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
function validateForm() {
    const checkboxes = document.querySelectorAll('input[name="selected_books[]"]:checked');
    if (checkboxes.length === 0) {
        alert('No books selected to return.');
        return false;
    }
    return true;
}
</script>

<?php 
include('./includes/footer.php');
include('./includes/script.php');
include('./message.php');   

if (isset($_POST['return']) || isset($_POST['return_individual']) || isset($_POST['return_selected'])) {
    $faculty_id = $_POST['faculty_id'];
    $date_returned = $_POST['date_returned'];
    $return_all = isset($_POST['return']);
    $return_selected = isset($_POST['return_selected']);
    $book_ids = [];

    // Fetch all borrowed books for the user, individual book, or selected books
    if ($return_all) {
        $borrow_query = mysqli_query($con, "SELECT * FROM borrow_book WHERE faculty_id = '$faculty_id' AND borrowed_status = 'borrowed'");
    } elseif ($return_selected) {
        $selected_books = $_POST['selected_books'];
        $book_ids_str = implode(",", $selected_books);
        $borrow_query = mysqli_query($con, "SELECT * FROM borrow_book WHERE faculty_id = '$faculty_id' AND borrowed_status = 'borrowed' AND book_id IN ($book_ids_str)");
    } else {
        $book_id = $_POST['book_id'];
        $borrow_book_id = $_POST['borrow_book_id'];
        $borrow_query = mysqli_query($con, "SELECT * FROM borrow_book WHERE faculty_id = '$faculty_id' AND borrowed_status = 'borrowed' AND book_id = '$book_id' AND borrow_book_id = '$borrow_book_id'");
    }

    while ($borrow_row = mysqli_fetch_array($borrow_query)) {
        $borrow_book_id = $borrow_row['borrow_book_id'];
        $book_id = $borrow_row['book_id'];
        $date_borrowed = $borrow_row['date_borrowed'];
        $due_date = $borrow_row['due_date'];

        mysqli_query($con, "UPDATE book SET status = 'Available' WHERE book_id = '$book_id'");

        $timezone = "Asia/Manila";
        if (function_exists('date_default_timezone_set')) {
            date_default_timezone_set($timezone);
        }
        $cur_date = date("Y-m-d");
        $date_returned_now = date("Y-m-d");

        // Adjust due date to exclude Sundays
        $adjusted_due_date = strtotime($due_date);
        while (date('N', $adjusted_due_date) == 7) { // N returns 7 for Sunday
            $adjusted_due_date = strtotime("+1 day", $adjusted_due_date);
        }
        $due_date = date("Y-m-d", $adjusted_due_date);

        if ($date_returned > $due_date) {
            $penalty = 0;
            $current_date = strtotime($due_date);
            $end_date = strtotime($date_returned);

            while ($current_date < $end_date) {
                $current_date = strtotime("+1 day", $current_date);
                if (date('N', $current_date) != 7) { // N returns 7 for Sunday
                    $penalty += 5;
                }
            }
        } else {
            $penalty = 'No Penalty';
        }

        mysqli_query($con, "UPDATE borrow_book SET borrowed_status = 'returned', date_returned = '$date_returned_now', book_penalty = '$penalty' WHERE borrow_book_id = '$borrow_book_id' AND faculty_id = '$faculty_id' AND book_id = '$book_id'");

        mysqli_query($con, "INSERT INTO return_book (faculty_id, book_id, date_borrowed, due_date, date_returned, book_penalty) VALUES ('$faculty_id', '$book_id', '$date_borrowed', '$due_date', '$date_returned_now', '$penalty')");

        $book_ids[] = $book_id;

        $report_history1 = mysqli_query($con, "SELECT * FROM admin WHERE admin_id = '$id_session'");
        $report_history_row1 = mysqli_fetch_array($report_history1);
        $admin_row1 = $report_history_row1['firstname']." ".$report_history_row1['middlename']." ".$report_history_row1['lastname'];

        mysqli_query($con, "INSERT INTO report (book_id, faculty_id, admin_name, detail_action, date_transaction) VALUES ('$book_id', '$faculty_id', '$admin_row1', 'Returned Book', NOW())");
    }

    if ($penalty === 'No Penalty') {
        echo '<script>location.href="return_faculty_slip.php?firstname='.$firstname.'&book_ids='.implode(',', $book_ids).'";</script>';
    } else {
        echo '<script>location.href="acknowledgement_receipt_print_faculty.php?firstname='.$firstname.'&book_ids='.implode(',', $book_ids).'";</script>';
    }
}
?>
