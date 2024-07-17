<?php 
include('authentication.php');
include('includes/header.php'); 
include('./includes/sidebar.php'); 
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Hold Books</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="circulation.php">Hold Books</a></li>
                <li class="breadcrumb-item active">View Hold Books</li>
            </ol>
        </nav>
    </div>
    <section class="section ">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header text-bg-primary d-flex fw-semibold justify-content-between">
                        <h5 class="m-0 text-white fw-semibold">Recent Hold Books</h5>
                        <a href="hold_list.php" class="btn btn-success">Back</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive mt-3">
                            <table id="myDataTable" cellpadding="0" cellspacing="0" border="0"
                                   class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Hold Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $borrow_query = mysqli_query($con, "
                                        SELECT holds.hold_id, holds.hold_date, 
                                               book.title, book.book_image, 
                                               user.user_id, faculty.faculty_id 
                                        FROM holds
                                        LEFT JOIN book ON holds.accession_number = book.accession_number 
                                        LEFT JOIN user ON holds.user_id = user.user_id 
                                        LEFT JOIN faculty ON holds.faculty_id = faculty.faculty_id
                                        WHERE hold_status = 'Hold'
                                        ORDER BY holds.hold_id DESC
                                    ");
                                    $borrow_count = mysqli_num_rows($borrow_query);
                                    while($borrow_row = mysqli_fetch_array($borrow_query)){
                                        $id = $borrow_row['hold_id'];
                                        $book_title = $borrow_row['title'];
                                        $user_id = $borrow_row['user_id'];
                                        $faculty_id = $borrow_row['faculty_id'];
                                    ?>
                                    <?php if(isset($user_id) || isset($faculty_id)) { ?>
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
                                        <td style="text-transform: capitalize"><?php echo $book_title; ?></td>
                                        <td><?php echo date("M d, Y h:i:s a", strtotime($borrow_row['hold_date'])); ?></td>
                                    </tr>
                                    <?php } } ?>
                                </tbody>
                            </table>
                            <?php if ($borrow_count <= 0) { ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                No Hold Books at this Moment
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php 
include('./includes/footer.php');
include('./includes/script.php');
include('../message.php');   
?>

<script>
var select_box_element = document.querySelector('#select_box');
dselect(select_box_element, {
    search: true
});
</script>
