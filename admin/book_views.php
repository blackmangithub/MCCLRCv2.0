<?php 
include('authentication.php');
include('includes/header.php'); 
include('./includes/sidebar.php'); 

// Check which tab to show
$activeTab = isset($_GET['tab']) && $_GET['tab'] == 'copies' ? 'copies-tab' : 'details-tab';
$activeTabPane = isset($_GET['tab']) && $_GET['tab'] == 'copies' ? 'copies-tab-pane' : 'details-tab-pane';
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>View Book</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="books.php">Book Collection</a></li>
                <li class="breadcrumb-item active">View Book</li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-end mb-3">
                            <!-- Back Button -->
                            <a href="books.php" class="btn btn-primary" style="margin-top:10px;margin-bottom:-30px;">Back</a>
                        </div>
                        <ul class="nav nav-tabs" id="myTab">
                            <li class="nav-item">
                                <!-- Book Details Tab -->
                                <button class="nav-link <?= $activeTab == 'details-tab' ? 'active' : '' ?>" id="details-tab" data-bs-toggle="tab" data-bs-target="#details-tab-pane">Book Details</button>
                            </li>
                            <li class="nav-item">
                                <!-- Copies Tab -->
                                <button class="nav-link <?= $activeTab == 'copies-tab' ? 'active' : '' ?>" id="copies-tab" data-bs-toggle="tab" data-bs-target="#copies-tab-pane">Copies</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade <?= $activeTabPane == 'details-tab-pane' ? 'show active' : '' ?>" id="details-tab-pane">
                                <div class="card-body">
                                    <?php
                                    if (isset($_GET['title'])) {
                                        $book_title = mysqli_real_escape_string($con, $_GET['title']);
                                        $query = "SELECT book.*, category.classname, COUNT(book.accession_number) AS copy_count,
                                                  SUM(CASE WHEN book.status = 'available' THEN 1 ELSE 0 END) AS available_count 
                                                  FROM book 
                                                  LEFT JOIN category ON book.category_id = category.category_id 
                                                  WHERE book.title = '$book_title'";
                                        $query_run = mysqli_query($con, $query);

                                        if (mysqli_num_rows($query_run) > 0) {
                                            $book = mysqli_fetch_array($query_run);
                                            ?>
                                            <div class="row">
                                                <div class="col-12 col-md-5 d-flex align-items-center justify-content-center my-4">
                                                    <?php if ($book['book_image'] != ""): ?>
                                                        <img src="../uploads/books_img/<?= $book['book_image']; ?>" alt="" width="250px" height="250px">
                                                    <?php else: ?>
                                                        <img src="../uploads/books_img/book_image.jpg" alt="" width="250px" height="250px">
                                                    <?php endif; ?>
                                                </div>
                                                <div class="col-12 col-md-7 my-4">
                                                    <div class="mb-3">
                                                        <span class="fw-semibold">Title</span>
                                                        <p class="d-inline">: <?= $book['title']; ?></p>
                                                    </div>
                                                    <div class="mb-3">
                                                        <span class="fw-semibold">Author</span>
                                                        <p class="d-inline">: <?= $book['author']; ?></p>
                                                    </div>
                                                    <div class="mb-3">
                                                        <span class="fw-semibold">Copyright Date</span>
                                                        <p class="d-inline">: <?= $book['copyright_date']; ?></p>
                                                    </div>
                                                    <div class="mb-3">
                                                        <span class="fw-semibold">Publisher</span>
                                                        <p class="d-inline">: <?= $book['publisher']; ?></p>
                                                    </div>
                                                    <div class="mb-3">
                                                        <span class="fw-semibold">ISBN</span>
                                                        <p class="d-inline">: <?= $book['isbn']; ?></p>
                                                    </div>
                                                    <div class="mb-3">
                                                        <span class="fw-semibold">Place of Publication</span>
                                                        <p class="d-inline">: <?= $book['place_publication']; ?></p>
                                                    </div>
                                                    <div class="mb-3">
                                                        <span class="fw-semibold">LRC Location</span>
                                                        <p class="d-inline">: <?= $book['classname']; ?></p>
                                                    </div>
                                                    <div class="mb-3">
                                                        <span class="fw-semibold">Copy</span>
                                                        <p class="d-inline">: <?= $book['available_count']; ?> of <?= $book['copy_count']; ?> available</p>
                                                    </div>
                                                    <div class="mb-3 mt-2">
                                                        <span class="fw-semibold">Call Number</span>
                                                        <p class="d-inline">: <?= $book['call_number']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        } else {
                                            echo "No such title found";
                                        }
                                    }  
                                    ?>
                                </div>
                            </div>
                            <div class="tab-pane fade <?= $activeTabPane == 'copies-tab-pane' ? 'show active' : '' ?>" id="copies-tab-pane">
                                <div class="table-responsive">
                                    <br>
                                    <!-- Copies Table -->
                                    <table id="myDataTable" class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>Accession No.</th>
                                                <th>Barcode</th>
                                                <th>Status</th>
                                                <th>LRC Location</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = "SELECT book.*, category.classname 
                                                      FROM book 
                                                      LEFT JOIN category ON book.category_id = category.category_id 
                                                      WHERE book.title = '$book_title'";
                                            $query_run = mysqli_query($con, $query);

                                            if (mysqli_num_rows($query_run) > 0) {
                                                while ($book = mysqli_fetch_assoc($query_run)) {
                                                    ?>
                                                    <tr>
                                                        <td><?= $book['accession_number']; ?></td>
                                                        <td><?= $book['barcode']; ?></td>
                                                        <td><?= $book['status']; ?></td>
                                                        <td><?= $book['classname']; ?></td>
                                                        <td>
                                                        <form action="books_code.php" method="POST">
                                                                <input type="hidden" name="accession_number" value="<?= $book['accession_number']; ?>">
                                                                <button type="submit" name="delete_book" class="btn btn-danger btn-sm">Delete</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                echo '<tr><td colspan="4">No records found</td></tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <!-- Additional footer content if needed -->
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
include('../message.php');
?>
