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
                        <div class="col-12 col-md-6 mt-2"></div>
                    </div>
                    <div class="card-body">
                        <?php
                        if ($faculty_row) {
                        ?>
                        <div class="text-muted mt-3">Faculty/Staff Name&nbsp;: &nbsp;<span
                                class="h5 text-primary p-0 m-0 text-uppercase fw-semibold"><?php echo $faculty_row['firstname'].' '.$faculty_row['middlename'].' '.$faculty_row['lastname'];?></span>
                        </div>
                        <div class="text-muted">
                            Department&emsp;&emsp;&emsp;&ensp;&nbsp;:&ensp;<span class="text-dark"><?=$faculty_row['course'];?></span>
                        </div>
                        <?php
                        } else {
                            echo "No rows returned";
                        }
                        ?>

                        <div class="table-responsive">
                            <table class="table">
                                <thead class="border-top border-dark border-opacity-25">
                                    <tr>
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
                                    $borrow_query = mysqli_query($con, "SELECT * FROM borrow_book
                                    LEFT JOIN book ON borrow_book.book_id = book.book_id
                                    WHERE faculty_id = '".$faculty_row['faculty_id']."' AND borrowed_status = 'borrowed' ORDER BY borrow_book_id DESC");
                                    $borrow_count = mysqli_num_rows($borrow_query);

                                    if ($borrow_count > 0) {
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
                                            <center>
                                                <?php if($borrow_row['book_image'] != ""): ?>
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
                                        <td><?php echo date('M d, Y ', strtotime($borrow_row['due_date'])) ?></td>
                                        <td><?php echo $penalty; ?></td>
                                    </tr>
                                    <?php 
                                        }
                                    } else {
                                        echo '
                                        <tr>
                                            <td colspan="9" class="alert alert-danger text-center">No books borrowed</td>
                                        </tr>
                                        ';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <?php if ($borrow_count > 0): ?>
                        <form method="post" action="">
                            <input type="hidden" name="date_returned" class="new_text" id="sd" value="<?php echo date("Y-m-d"); ?>" size="16" maxlength="10" />
                            <input type="hidden" name="faculty_id" value="<?php echo $faculty_row['faculty_id']; ?>">
                            <button type="submit" name="return" class="btn btn-danger">Return All Books</button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php 
include('./includes/footer.php');
include('./includes/script.php');
include('./message.php');   
?>
