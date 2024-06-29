<?php 
include('authentication.php');
include('includes/header.php'); 
include('./includes/sidebar.php'); 

$query = "SELECT * FROM `barcode` ORDER BY mid_barcode DESC";
$query_run = mysqli_query($con, $query);


     $fetch = mysqli_fetch_array($query_run);
     $mid_barcode = $fetch['mid_barcode'];

     $new_barcode = $mid_barcode + 1;
     $pre_barcode = "MCC";
     $suf_barcode = "LRC";
     $generate_barcode = $pre_barcode.$new_barcode.$suf_barcode;


						// $query = mysqli_query($con,"SELECT * FROM `barcode` ORDER BY mid_barcode DESC ") or die (mysqli_error());
						// $fetch = mysqli_fetch_array($query);
						// $mid_barcode = $fetch['mid_barcode'];
						
						// $new_barcode =  $mid_barcode + 1;
						// $pre_barcode = "VNHS";
						// $suf_barcode = "LMS";
						// $generate_barcode = $pre_barcode.$new_barcode.$suf_barcode;

?>
<main id="main" class="main">
     <div class="pagetitle">
          <h1>Add Book</h1>
          <nav>
               <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="web_opac.php">Web OPAC</a></li>
                    <li class="breadcrumb-item active">Add Book</li>
               </ol>
          </nav>
     </div>
     <section class="section">
          <div class="row">
               <div class="col-lg-12">
                    <div class="card">
                         <div class="card-header d-flex justify-content-end">

                         </div>
                         <div class="card-body">

                              <form action="web_opac_code.php" method="POST" enctype="multipart/form-data">

                                   <div class="row d-flex justify-content-center mt-4">

                                        <div class="col-12 col-md-5">
                                             <div class="mb-3 mt-2">
                                                  <label for="">Title</label>
                                                  <input type="text" name="title" class="form-control" required>
                                             </div>
                                        </div>

                                        <div class="col-12 col-md-5">
                                             <div class="mb-3 mt-2">
                                                  <label for="">Author</label>
                                                  <input type="text" name="author" class="form-control" required>
                                             </div>
                                        </div>

                                   </div>

                                   <div class="row d-flex justify-content-center">

                                        <div class="col-12 col-md-5">
                                             <div class="mb-3 mt-2">
                                                  <label for="">Copyright Date</label>
                                                  <input type="text" name="copyright_date" class="form-control"
                                                       required>
                                             </div>
                                        </div>

                                        <div class="col-12 col-md-5">
                                             <div class="mb-3 mt-2">
                                                  <label for="">Publisher</label>
                                                  <input type="text" name="publisher" class="form-control" required>
                                             </div>
                                        </div>

                                   </div>

                                   <div class="row d-flex justify-content-center">

                                        <div class="col-12 col-md-5">
                                             <div class="mb-3 mt-2">
                                                  <label for="">Book File</label>
                                                  <input type="file" name="ebook" class="form-control" required>
                                             </div>
                                        </div>

                                        <div class="col-12 col-md-5">
                                             <div class="mb-3 mt-2">
                                                  <div class="d-flex justify-content-between">
                                                       <label for="">Book Image</label>
                                                       <span class=" text-muted"><small>(Optional)</small></span>
                                                  </div>
                                                  <input type="file" name="opac_image" class="form-control" required>
                                             </div>
                                        </div>

                                   </div>


                         </div>
                         <div class="card-footer d-flex justify-content-end">
                              <div>
                                   <a href="books.php" class="btn btn-secondary">Cancel</a>
                                   <button type="submit" name="upload_book" class="btn btn-primary">Upload Book</button>
                              </div>
                         </div>
                         </form>
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