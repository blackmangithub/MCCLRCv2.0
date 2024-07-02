<?php 
include('authentication.php');
include('includes/header.php'); 
include('./includes/sidebar.php'); 

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
                    <div class="table-responsive mt-3">
                    <ul class="nav nav-tabs" id="myTab">
                                        <li class="nav-item">
                                             <!-- Book Tab -->
                                             <button class="nav-link active" id="books-tab" data-bs-toggle="tab"
                                                  data-bs-target="#books-tab-pane">Book Details</button>
                                        </li>
                                        <li class="nav-item">
                                             <!-- Ebook Tabs -->
                                             <button class="nav-link" id="ebooks-tab" data-bs-toggle="tab"
                                                  data-bs-target="#ebooks-tab-pane">Copies</button>
                                        </li>
                                   </ul>
                                   <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="books-tab-pane">
                                        <div class="card-body">
                              <?php
                              if(isset($_GET['id']))
                              {
                                   $book_id = mysqli_real_escape_string($con, $_GET['id']);

                                   $query = "SELECT * FROM book LEFT JOIN category on book.category_id = category.category_id WHERE book_id ='$book_id'"; 
                                   $query_run = mysqli_query($con, $query);

                                   if(mysqli_num_rows($query_run) > 0)
                                   {
                                       $book = mysqli_fetch_array($query_run);
                                        ?>


                              <div class="row">

                                   <div class="col-12 col-md-5 d-flex align-items-center justify-content-center my-4">

                                        <?php if($book['book_image'] != ""): ?>
                                        <img src="../uploads/books_img/<?php echo $book['book_image']; ?>" alt=""
                                             width="250px" height="250px">
                                        <?php else: ?>
                                        <img src="../uploads/books_img/book_image.jpg" alt="" width="250px"
                                             height="250px">
                                        <?php endif; ?>

                                   </div>
                                   <div class="col-12 col-md-7 my-4">

                                        <div class="mb-3">
                                             <span
                                                  class="fw-semibold">Title&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&ensp;</span>
                                             <p class="d-inline">:&nbsp;<?=$book['title'];?></p>
                                        </div>


                                        <div class="mb-3">
                                             <span class="fw-semibold">Author
                                                  &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</span>
                                             <p class="d-inline">:&nbsp;<?=$book['author'];?></p>
                                        </div>

                                        <div class="mb-3">
                                             <span class="fw-semibold">Copyright Date &emsp;&emsp;</span>
                                             <p class="d-inline">:&nbsp;<?=$book['copyright_date'];?></p>
                                        </div>

                                        <div class="mb-3">
                                             <span class="fw-semibold">Publisher
                                                  &emsp;&emsp;&emsp;&emsp;&ensp;&nbsp;</span>
                                             <p class="d-inline">:&nbsp;<?=$book['publisher'];?></p>
                                        </div>
                                        <div class="mb-3">
                                             <span class="fw-semibold">ISBN
                                                  &emsp;&emsp;&emsp;&emsp;&ensp;&nbsp;</span>
                                             <p class="d-inline">:&nbsp;<?=$book['isbn'];?></p>
                                        </div>
                                        <div class="mb-3">
                                             <span class="fw-semibold">Place of Publication
                                                  &ensp;&nbsp;</span>
                                             <p class="d-inline">:&nbsp;<?=$book['place_publication'];?></p>
                                        </div>

                                        <div class="mb-3">

                                             <span class="fw-semibold">LRC Location &ensp;</span>
                                             <p class="d-inline">:&nbsp;<?=$book['classname'];?></p>


                                        </div>

                                        <div class="mb-3">
                                             <span class="fw-semibold">Copy
                                                  &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</span>
                                             <p class="d-inline">:&nbsp;<?=$book['copy'];?></p>
                                        </div>

                                        <div class="mb-3 mt-2">
                                             <span class="fw-semibold">Call Number &emsp;&emsp;&emsp;&nbsp;</span>
                                             <p class="d-inline">:&nbsp;<?=$book['call_number'];?></p>
                                        </div>

                                   </div>
                              </div>

                         </div>
</div>
<div class="tab-pane fade" id="ebooks-tab-pane">
<div class="table-responsive">
    <br>
    <!-- Books Table -->
                              <table id="myDataTable" class="table table-bordered table-striped table-sm">
                                   <thead>
                                        <tr>
                                             <th>Accession No.</th>
                                             <th>Barcode</th>
                                             <th>Status</th>
                                             <th>LRC Location</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <?php
                                        $query = "SELECT * FROM book ORDER BY title DESC";
                                        $query_run = mysqli_query($con, $query);

                                        if(mysqli_num_rows($query_run) > 0) {
                                             while($book = mysqli_fetch_assoc($query_run)) {
                                        ?>
                                        <tr>
                                             <td><?= $book['accession_number']; ?></td>
                                             <td><?= $book['barcode']; ?></td>
                                             <td><?= $book['status']; ?></td>
                                             <td><?= $book['category_id']; ?></td>
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


                              <?php
                              }
                              else
                              {
                                   echo "No such ID found";
                              }

                         }  
                         ?>
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