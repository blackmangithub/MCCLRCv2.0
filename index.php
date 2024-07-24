<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="utf-8" />
     <meta name="viewport" content="width=device-width, initial-scale=1" />
     <link rel="icon" href="./assets/img/mcc-logo.png">
     <title>MCC Learning Resource Center</title>

     <!-- Bootstrap CSS -->
     <link rel="stylesheet" href="assets/css/bootstrap5.min.css" />

     <!-- Bootstrap Icon -->
     <link rel="stylesheet" href="assets/font/bootstrap-icons.css">

     <!-- Iconscout cdn link -->
     <link rel="stylesheet" href="assets/css/line.css">
     <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

     <!-- Custom CSS Styling -->
     <link rel="stylesheet" href="assets/css/style.css">

     <!-- Alertify JS cdn link -->
     <link rel="stylesheet" href="assets/css/alertify.min.css" />
     <link rel="stylesheet" href="assets/css/alertify.bootstraptheme.min.css" />

     <!-- Animation -->
     <link rel="stylesheet" href="assets/css/aos.css" />
</head>
<body>
<nav class="navbar navbar-expand-lg" style="background: #0096FF;">
    <div class="container-fluid mx-5">
        <img src="assets/img/mcc-logo.png" alt="logo" class=" mx-2" height="40px" width="40px" />
        <a class="navbar-brand text-white fw-bold fs-5" href="#">MCC-LRC</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 nav nav-pills nav-justified">
                <li class="nav-item">
                    <a class="nav-link text-white active fw-semibold" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white  fw-semibold" href="ebook.php">Ebooks</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white  fw-semibold" href="notification.php">Notification</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link  dropdown-toggle text-white fw-semibold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span>Diovin Calatero</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="myprofile.php"><i class="bi bi-person"></i> My Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="hold.php"><i class="bi bi-book"></i> Hold Books</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="allcode.php" method="POST">
                                <button type="submit" name="logout_btn" class="dropdown-item"><i class="bi bi-box-arrow-right"></i> Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card mt-4" data-aos="fade-up">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-center mt-2">
                        <div class="mx-2">
                            <img src="assets/img/mcc-logo.png" class="d-sm-none d-md-block me-4" style="height: 100px; width: 100px;" alt="MCC Logo">
                        </div>
                        <div class="col-8 mt-2">
                            <center>
                                <h3 class="fw-semibold">Madridejos Community College</h3>
                                <h4 class="fw-semibold">Learning Resource Center</h4>
                            </center>
                            <form method="GET">
                                <div class="d-flex">
                                    <div class="input-group mb-3 me-6">
                                        <input type="text" name="search" value="" class="form-control" placeholder="Type here to search" required>
                                        <button class="btn btn-primary px-md-5 px-sm-1">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body border border-0">
                    <center>
                        <a href="#new_books" class="btn btn-primary mt-2" data-aos="zoom-in">New Acquisitions</a>
                    </center>
                    <hr class="mt-2 mb-2 text-black">
                    <div id="new_books" class="row row-cols-1 row-cols-md-12 g-4">
                        <?php
                        include('admin/config/dbcon.php');

                        if (isset($_GET['search'])) {
                            $filtervalues = mysqli_real_escape_string($con, $_GET['search']);
                            $query = "SELECT book.*, COUNT(book.accession_number) AS copy_count,
                                      SUM(CASE WHEN book.status = 'available' THEN 1 ELSE 0 END) AS available_count
                                      FROM book 
                                      WHERE title LIKE '%$filtervalues%' AND status_hold = ''
                                      GROUP BY title
                                      ORDER BY title DESC";
                        } else {
                            $query = "SELECT book.*, COUNT(book.accession_number) AS copy_count, 
                                      SUM(CASE WHEN book.status = 'available' THEN 1 ELSE 0 END) AS available_count 
                                      FROM book 
                                      WHERE status_hold = ''
                                      GROUP BY title 
                                      ORDER BY title DESC";
                        }

                        $query_run = mysqli_query($con, $query);

                        if (mysqli_num_rows($query_run) > 0) {
                            foreach ($query_run as $book) {
                                $unavailable_count = $book['copy_count'] - $book['available_count'];
                        ?>
                        <div class="card mt-1">
                            <div class="card-body pt-3 d-md-flex d-sm-block">
                                <div class="col-xl-2">
                                    <a href="book_details.php?title=<?= urlencode($book['title']); ?>&id=<?= urlencode($book['book_id']); ?>" class="text-decoration-none">
                                        <?php if ($book['book_image'] != ""): ?>
                                            <img src="uploads/books_img/<?php echo htmlspecialchars($book['book_image']); ?>" width="100px" alt="">
                                        <?php else: ?>
                                            <img src="uploads/books_img/book_image.jpg" alt="">
                                        <?php endif; ?>
                                    </a>
                                </div>
                                <div class="col-xl-10">
                                    <div class="row mt-3">
                                        <div class="col-lg-12 col-md-12 fs-6">
                                            <a href="book_details.php?title=<?= urlencode($book['title']); ?>&id=<?= urlencode($book['book_id']); ?>" style="text-decoration: none" class="fw-bold">
                                                <?= htmlspecialchars($book['title']) ?>
                                            </a>
                                            (<?= htmlspecialchars($book['copyright_date']) ?>)
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-lg-9 col-md-8">
                                            by&nbsp;<?= htmlspecialchars($book['author']); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                            }
                        } else {
                            echo '<div class="col-md-12 alert alert-info h5 text-center">No Book Found</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/alertify.min.js"></script>
<script src="assets/js/aos.js"></script>
<script>
    $(document).ready(function() {
        $("#live_search").keyup(function() {
            var input = $(this).val();
            if (input != "") {
                $.ajax({
                    url: "home_code.php",
                    method: "POST",
                    data: {
                        input: input
                    },
                    success: function(data) {
                        $("#searchresult").html(data);
                    }
                });
            } else {
                $("#searchresult").css("display", "none");
            }
        });
    });
</script>

<?php include('includes/footer.php'); ?>
<?php include('includes/script.php'); ?>
<?php include('message.php'); ?>
</body>
</html>
