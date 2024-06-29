<?php 
include('authentication.php');
include('includes/header.php'); 
include('./includes/sidebar.php'); 

?>


<main id="main" class="main" data-aos="fade-down">
     <?php  $page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/")+ 1); ?>
     <div class="pagetitle">
          <h1>Collection of Books</h1>
          <nav>
               <ol class="breadcrumb">
                    <li class="breadcrumb-item active">Book Collection</li>
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
                                                  data-bs-target="#books-tab-pane">Books</button>
                                        </li>
                                        <li class="nav-item">
                                             <!-- Ebook Tabs -->
                                             <button class="nav-link" id="ebooks-tab" data-bs-toggle="tab"
                                                  data-bs-target="#ebooks-tab-pane">Ebooks</button>
                                        </li>
                                   </ul>
                                   <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="books-tab-pane">
                                             <div class="d-flex justify-content-end my-2">
                                                  <!-- Add Book Button -->
                                                  <a href="book_add.php" class="btn btn-primary">
                                                       <i class="bi bi-journal-plus"></i> Add Book
                                                  </a>
                                             </div>
                                             <div class="table-responsive">
                                                  <!-- Books Table -->
                                                  <table id="myDataTable"
                                                       class="table table-bordered table-striped table-sm">
                                                       <thead>
                                                            <tr>

                                                                 <th>Image</th>
                                                                 <th>Title</th>
                                                                 <th>Author</th>
                                                                 <th>Copyright Date</th>
                                                                 <th>Publisher</th>
                                                                 <th>Copy</th>
                                                                 <th>Call Number</th>
                                                                 <th>Accession Number</th>
                                                                 <th>Barcode</th>
                                                                 <th>Action</th>

                                                            </tr>
                                                       </thead>
                                                       <tbody>
                                                            <?php
                                                            $query = "SELECT * FROM book";
                                                            $query_run = mysqli_query($con, $query);
                                                            
                                                            if(mysqli_num_rows($query_run))
                                                            {
                                                                 foreach($query_run as $book)
                                                                 {
                                                                      ?>
                                                            <tr>
                                                                 <td>
                                                                      <center>
                                                                           <?php if($book['book_image'] != ""): ?>
                                                                           <img src="../uploads/books_img/<?php echo $book['book_image']; ?>"
                                                                                alt="" width="60px" height="60px">
                                                                           <?php else: ?>
                                                                           <img src="../uploads/books_img/book_image.jpg"
                                                                                alt="" width="60px" height="60px">
                                                                           <?php endif; ?>
                                                                      </center>
                                                                 </td>
                                                                 <td><?=$book['title'];?></td>
                                                                 <td><?=$book['author'];?></td>
                                                                 <td><?=$book['copyright_date'];?></td>
                                                                 <td><?=$book['publisher'];?></td>
                                                                 <td><?=$book['copy'];?></td>
                                                                 <td><?=$book['call_number'];?></td>
                                                                 <td><?=$book['accession_number'];?></td>
                                                                 <td><?=$book['barcode'];?></td>
                                                                 <td class=" justify-content-center">
                                                                      <div class="btn-group"
                                                                           style="background: #DFF6FF;  ">
                                                                           <!-- View Book Action-->
                                                                           <a href="book_views.php?id=<?=$book['book_id']; ?>"
                                                                                name=""
                                                                                class="viewBookBtn btn btn-sm  border text-primary"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-placement="bottom"
                                                                                title="View Book">
                                                                                <i class="bi bi-eye-fill"></i>
                                                                           </a>
                                                                           <!-- Edit Book Action-->
                                                                           <a href="book_edit.php?id=<?= $book['book_id']; ?>"
                                                                                name="update_book"
                                                                                class="btn btn-sm  border text-success"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-placement="bottom"
                                                                                title="Edit Book">
                                                                                <i class="bi bi-pencil-fill"></i>
                                                                           </a>
                                                                           <!-- Delete Book Action-->
                                                                           <form action="books_code.php" method="POST">
                                                                                <button type="submit" name="delete_book"
                                                                                     value="<?=$book['book_id'];?>"
                                                                                     class="btn btn-sm  border text-danger"
                                                                                     data-bs-toggle="tooltip"
                                                                                     data-bs-placement="bottom"
                                                                                     title="Delete Book">
                                                                                     <i class="bi bi-trash-fill"></i>
                                                                                </button>
                                                                           </form>
                                                                      </div>
                                                                 </td>
                                                            </tr>

                                                            <?php
                                                                 }
                                                            }
                                                            else
                                                            {
                                                                 echo "No records found";
                                                            }                                           
                                                            ?>
                                                       </tbody>
                                                  </table>
                                             </div>
                                        </div>
                                        <div class="tab-pane fade" id="ebooks-tab-pane">
                                             <div class="d-flex justify-content-end my-2">
                                                  <!-- Add Ebook Button -->
                                                  <a href="ebook_add.php" class="btn btn-primary"><i
                                                            class="bi bi-journal-plus"></i>
                                                       Upload Book</a>
                                             </div>
                                             <div class="table-responsive">
                                                  <!-- Ebooks Table -->
                                                  <table id="myDataTable2"
                                                       class="table table-bordered table-striped table-sm">
                                                       <thead>
                                                            <tr>
                                                                 <th>Book Image</th>
                                                                 <th>Title</th>
                                                                 <th>Author</th>
                                                                 <th>Copyright Date</th>
                                                                 <th>Publisher</th>
                                                                 <th>Action</th>
                                                            </tr>
                                                       </thead>
                                                       <tbody>
                                                            <?php
                                                            $query = "SELECT * FROM web_opac";
                                                            $query_run = mysqli_query($con, $query);
                                                            
                                                            if(mysqli_num_rows($query_run))
                                                            {
                                                                 foreach($query_run as $book)
                                                                 {
                                                                      ?>
                                                            <tr>
                                                                 <td>
                                                                      <center>

                                                                           <?php if($book['opac_image'] != ""): ?>
                                                                           <img src="../uploads/ebook_img/<?=$book['opac_image'];?>"
                                                                                alt="" width="60px" height="60px">
                                                                           <?php else: ?>
                                                                           <img src="../uploads/ebook_img/book_image.jpg"
                                                                                alt="" width="60px" height="60px">
                                                                           <?php endif; ?>
                                                                      </center>
                                                                 </td>
                                                                 <td><?=$book['title'];?></td>
                                                                 <td><?=$book['author'];?></td>
                                                                 <td><?=$book['copyright_date'];?></td>
                                                                 <td><?=$book['publisher'];?></td>
                                                                 <td class=" justify-content-center">
                                                                      <div class="btn-group"
                                                                           style="background: #DFF6FF;  ">
                                                                           <!-- View Book Action-->
                                                                           <a href="ebook_view.php?id=<?=$book['web_opac_id']; ?>"
                                                                                name="view_book"
                                                                                class="viewweb_opacBtn btn btn-sm  border text-primary"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-placement="bottom"
                                                                                title="View Book">
                                                                                <i class="bi bi-eye-fill"></i>
                                                                           </a>
                                                                           <!-- Edit web_opac Action-->
                                                                           <a href="ebook_edit.php?id=<?= $book['web_opac_id']; ?>"
                                                                                name="update_book"
                                                                                class="btn btn-sm  border text-success"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-placement="bottom"
                                                                                title="Edit Book">
                                                                                <i class="bi bi-pencil-fill"></i>
                                                                           </a>
                                                                           <!-- Delete web_opac Action-->
                                                                           <form action="ebooks_code.php" method="POST">
                                                                                <button type="submit" name="delete_book"
                                                                                     value="<?=$book['web_opac_id'];?>"
                                                                                     class="btn btn-sm  border text-danger"
                                                                                     data-bs-toggle="tooltip"
                                                                                     data-bs-placement="bottom"
                                                                                     title="Delete Book">
                                                                                     <i class="bi bi-trash-fill"></i>
                                                                                </button>
                                                                           </form>
                                                                      </div>
                                                                 </td>
                                                            </tr>

                                                            <?php
                                                                 }
                                                            }
                                                                                                    
                                                            ?>
                                                       </tbody>
                                                  </table>
                                             </div>
                                        </div>
                                   </div>

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