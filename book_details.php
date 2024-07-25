<?php 
include('includes/header.php');
include('includes/navbar.php');
include('admin/config/dbcon.php');

if(empty($_SESSION['auth'])){
    header('Location: home.php');
    exit(0);
}
if($_SESSION['auth_role'] != "student" && $_SESSION['auth_role'] != "faculty" && $_SESSION['auth_role'] != "staff") {
    header("Location:index.php");
    exit(0);
}
?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card mt-4">
                <div class="card-header">
                    <a href="index.php" class="btn btn-primary">Back</a>
                </div>
                <div class="card-body">
                    <section class="section profile">
                        <div class="row">
                            <?php
                            if(isset($_GET['id']) || isset($_GET['title'])) {
                                $book_id = mysqli_real_escape_string($con, $_GET['id']);
                                $book_title = mysqli_real_escape_string($con, $_GET['title']);

                                // Fetch book details
                                $query = "SELECT 
                                               book.*, 
                                               COUNT(book.accession_number) AS copy_count, 
                                               SUM(CASE WHEN book.status = 'available' THEN 1 ELSE 0 END) AS available_count
                                          FROM book 
                                          WHERE title = '$book_title' 
                                          GROUP BY title 
                                          ORDER BY title DESC";
                                $query_run = mysqli_query($con, $query);

                                if(mysqli_num_rows($query_run) > 0) {
                                    $book = mysqli_fetch_array($query_run);
                                    $unavailable_count = $book['copy_count'] - $book['available_count'];
                                    ?>
                                    <div class="col-xl-4">
                                        <div class="card">
                                            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                                                <?php if($book['book_image'] != ""): ?>
                                                    <img src="uploads/books_img/<?php echo $book['book_image']; ?>" height="300px" alt="">
                                                <?php else: ?>
                                                    <img src="uploads/books_img/book_image.jpg" height="300px" alt="">
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-8">
                                        <div class="card">
                                            <div class="card-body pt-3">
                                                <ul class="nav nav-tabs nav-tabs-bordered border-info">
                                                    <li class="nav-item">
                                                        <button class="nav-link active text-info border-info fw-semibold" data-bs-toggle="tab" data-bs-target="#profile-overview">Book Details</button>
                                                    </li>
                                                </ul>
                                                <div class="tab-content pt-2">
                                                    <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                                        <div class="row mt-3">
                                                            <div class="col-lg-3 col-md-4 label fw-semibold">Title</div>
                                                            <div class="col-lg-9 col-md-8"><?= $book['title'] ?></div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-lg-3 col-md-4 label fw-semibold">Author</div>
                                                            <div class="col-lg-9 col-md-8"><?= $book['author'] ?></div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-lg-3 col-md-4 label fw-semibold">Copyright Date</div>
                                                            <div class="col-lg-9 col-md-8"><?= $book['copyright_date'] ?></div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-lg-3 col-md-4 label fw-semibold">Publisher</div>
                                                            <div class="col-lg-9 col-md-8"><?= $book['publisher'] ?></div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-lg-3 col-md-4 label fw-semibold">Place of Publication</div>
                                                            <div class="col-lg-9 col-md-8"><?= $book['place_publication'] ?></div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-lg-3 col-md-4 label fw-semibold">ISBN</div>
                                                            <div class="col-lg-9 col-md-8"><?= $book['isbn'] ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card mt-2">
                                            <div class="card-body">
                                                <div class="row mt-2">
                                                    <div class="col-lg-3 col-md-4 label fw-semibold">Books Available</div>
                                                    <div class="col-lg-6 col-md-4">
                                                        <?= $book['available_count']; ?> of <?= $book['copy_count']; ?> available
                                                    </div>
                                                    <div class="col-lg-3 col-md-4 fw-semibold text-primary">
                                                        <form action="" method="POST">
                                                            <input type="hidden" name="book_id" value="<?= $book_id ?>">
                                                            <button type="submit" name="hold" class="btn btn-primary px-4" <?= $unavailable_count > 0 ? '' : 'disabled' ?>>Hold</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } else {
                                    echo "No Book details found";
                                }
                            }
                            ?>
                        </div>
                    </section>
                </div>
                <div id="searchresult" class="text-center"></div>
            </div>
        </div>
    </div>
</div>

<?php 
if (isset($_POST['hold'])) {
    $book_id = mysqli_real_escape_string($con, $_POST['book_id']);
    $book_title_query = "SELECT title FROM book WHERE book_id = '$book_id'";
    $book_title_result = mysqli_query($con, $book_title_query);
    $book_title_row = mysqli_fetch_assoc($book_title_result);
    $book_title = $book_title_row['title'];
    
    $user_id = $_SESSION['auth_role'] == "student" ? $_SESSION['auth_stud']['stud_id'] : null;
    $faculty_id = ($_SESSION['auth_role'] == "faculty" || $_SESSION['auth_role'] == "staff") ? $_SESSION['auth_stud']['stud_id'] : null;

    // Check if the book title is already on hold by the same user or faculty
    $check_query = "SELECT * FROM holds 
                    WHERE book_title = '$book_title'
                    AND (user_id = '$user_id' OR faculty_id = '$faculty_id')";
    $check_result = mysqli_query($con, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('You have already placed a hold on this book title!'); window.location='index.php'</script>";
    } else {
        // Check the current hold count for the user/faculty
        $count_query = "SELECT COUNT(*) AS count_books FROM holds 
                        WHERE (user_id = '$user_id' OR faculty_id = '$faculty_id')";
        $count_result = mysqli_query($con, $count_query);
        $count_row = mysqli_fetch_assoc($count_result);
        $current_hold_count = $count_row['count_books'];

        if ($current_hold_count >= 3) {
            echo "<script>alert('You cannot hold more than 3 books!'); window.location='index.php'</script>";
        } else {
            $update_query = "UPDATE book SET status_hold = 'Hold' WHERE book_id = '$book_id'";
            mysqli_query($con, $update_query);

            $insert_query = "";
            if ($_SESSION['auth_role'] == "student") {
                $insert_query = "INSERT INTO holds (book_id, book_title, user_id, hold_status, hold_date) 
                                 VALUES ('$book_id', '$book_title', '$user_id', 'Hold', NOW())";
            } elseif ($_SESSION['auth_role'] == "faculty" || $_SESSION['auth_role'] == "staff") {
                $insert_query = "INSERT INTO holds (book_id, book_title, faculty_id, hold_status, hold_date) 
                                 VALUES ('$book_id', '$book_title', '$faculty_id', 'Hold', NOW())";
            }

            $query_run = mysqli_query($con, $insert_query);

            if ($query_run) {
                echo "<script>alert('Book held successfully'); window.location = 'index.php'</script>";
            } else {
                $_SESSION['message_error'] = 'Failed to hold the book';
                header("Location: index.php");
                exit(0);
            }
        }
    }
}
?>

<?php
include('includes/footer.php');
include('includes/script.php');
include('message.php'); 
?>
