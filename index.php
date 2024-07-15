<?php 
include('includes/header.php');
include('includes/navbar.php');
include('admin/config/dbcon.php');

if (empty($_SESSION['auth'])) {
  header('Location: home.php');
  exit(0);
}
if ($_SESSION['auth_role'] != "student" && $_SESSION['auth_role'] != "faculty" && $_SESSION['auth_role'] != "staff") {
  header("Location:index.php");
  exit(0);
}
?>

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
                    <input type="text" name="search" value="<?php if (isset($_GET['search'])) { echo $_GET['search']; } ?>" class="form-control" placeholder="Type here to search" required>
                    <button class="btn btn-primary px-md-5 px-sm-1">Search</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="card-body border border-0">
          <?php if (!isset($_GET['search'])) : ?>
          <center>
            <a href="#new_books" class="btn btn-primary mt-2" data-aos="zoom-in">
              New Acquisitions
            </a>
          </center>
          <hr class="mt-2 mb-2 text-black">
          <?php endif; ?>
          <div id="new_books" class="row row-cols-1 row-cols-md-12 g-4">
            <?php if (isset($_GET['search'])) { ?>
            <div class="card mt-4 border-0">
              <div class="card-body">
                <section class="section profile">
                  <div class="col-xl-12">
                    <?php
                    $filtervalues = $_GET['search'];
                    $query = "SELECT book.*, COUNT(book.accession_number) AS copy_count,
                              SUM(CASE WHEN book.status = 'available' THEN 1 ELSE 0 END) AS available_count 
                              FROM book 
                              WHERE title LIKE '%$filtervalues%' 
                              GROUP BY book.title
                              ORDER BY book.title DESC"; // Order by title
                    $query_run = mysqli_query($con, $query);
                    if (mysqli_num_rows($query_run) > 0) {
                      foreach ($query_run as $book) {
                         $unavailable_count = $book['copy_count'] - $book['available_count'];
                    ?>
                    <div class="card mt-1">
                      <div class="card-body pt-3 d-md-flex d-sm-block">
                        <div class="col-xl-2">
                          <a href="book_details.php?title=<?= urlencode($book['title']); ?>" class="text-decoration-none">
                            <?php if ($book['book_image'] != ""): ?>
                            <img src="uploads/books_img/<?php echo $book['book_image']?>" width="100px" alt="">
                            <?php else: ?>
                            <img src="uploads/books_img/book_image.jpg" alt="">
                            <?php endif; ?>
                          </a>
                        </div>
                        <div class="col-xl-10">
                          <div class="row mt-3">
                            <div class="col-lg-12 col-md-12 fs-6">
                              <a href="book_details.php?title=<?= urlencode($book['title']); ?>" style="text-decoration: none" class="fw-bold">
                                <?=$book['title']?>
                              </a>
                              (<?=$book['copyright_date']?>)
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-lg-9 col-md-8">
                              by&nbsp;<?=$book['author'];?>
                              <br>
                              Copies :&nbsp;&nbsp;<b><?= $book['available_count'];?> of <?= $book['copy_count'];?> available</b>
                            </div>
                          </div>
                          <div class="row mt-5 d-flex align-items-center">
                            <form action="" method="POST">
                              <button type="submit" name="hold" class="btn btn-primary px-4 my-2" <?= $unavailable_count > 1 ? '' : 'disabled' ?>>Hold</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php
                      } // End foreach
                    ?>
                    <?php 
                    if (isset($_POST['hold'])) {
                      $book_hold = $book['book_id'];
                      $name_hold = $_SESSION['auth_stud']['stud_id'];
                      $check_query = "SELECT * FROM holds WHERE book_id = '$book_hold' AND user_id = '$name_hold'";
                      $check_result = mysqli_query($con, $check_query);
                      if (mysqli_num_rows($check_result) > 0) {
                        echo "<script>alert('You already have a hold on this book!'); window.location='index.php'</script>";
                      } else {
                        $count_query = "SELECT COUNT(*) AS count_books FROM holds WHERE user_id = '$name_hold'";
                        $count_result = mysqli_query($con, $count_query);
                        $count_row = mysqli_fetch_assoc($count_result);
                        $current_hold_count = $count_row['count_books'];
                        if ($current_hold_count >= 3) {
                          echo "<script>alert('You cannot hold more than 3 books!'); window.location='index.php'</script>";
                        } else {
                          $query = "INSERT INTO holds (book_id, user_id, hold_date) VALUES ('$book_hold', '$name_hold', NOW())";
                          $query_run = mysqli_query($con, $query);
                          if ($query_run) {
                            $update_copies = mysqli_query($con, "SELECT * FROM book WHERE book_id = '$book_hold'");
                            $copies_row = mysqli_fetch_assoc($update_copies);
                            $book_copies = $copies_row['copy'];
                            $new_book_copies = $book_copies - 1;
                            if ($new_book_copies < 1) {
                              echo "<script>alert('Book out of Copy!'); window.location='index.php'</script>";
                            } else {
                              mysqli_query($con, "UPDATE book SET copy = '$new_book_copies' WHERE book_id = '$book_hold'");
                            }
                            echo "<script>alert('Hold book Successfully'); window.location = 'index.php'</script>";
                          } else {
                            $_SESSION['message_error'] = 'Book not Hold';
                            header("Location: index.php?search='$filtervalues'");
                            exit(0);
                          }
                        }
                      }
                    }
                    ?>
                    </section>
                  </div>
                </div>
                <?php
                } else {
                  echo '<div class="col-md-12 alert alert-info h5 text-center">No Book Found</div>';
                }
                } else {
                ?>
                <?php
                $query = "SELECT book.*, COUNT(book.accession_number) AS copy_count, 
                          SUM(CASE WHEN book.status = 'available' THEN 1 ELSE 0 END) AS available_count 
                          FROM book 
                          GROUP BY book.title 
                          ORDER BY book.title DESC";
                $query_run = mysqli_query($con, $query);
                if (mysqli_num_rows($query_run)) {
                  foreach ($query_run as $book) {
                ?>
                <div class="col-12 col-md-3" data-aos="zoom-in">
                  <a href="book_details.php?title=<?= urlencode($book['title']); ?>">
                    <div class="card h-100 shadow">
                      <?php if ($book['book_image'] != ""): ?>
                      <img src="uploads/books_img/<?php echo $book['book_image']; ?>" alt="">
                      <?php else: ?>
                      <img src="uploads/books_img/book_image.jpg" alt="">
                      <?php endif; ?>
                    </div>
                  </a>
                </div>
                <?php
                  }
                }
                }
                ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
include('includes/footer.php');
include('includes/script.php');
include('message.php'); 
?>

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
