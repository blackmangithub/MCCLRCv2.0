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
                    <li class="breadcrumb-item active">Hold Books</li>
               </ol>
          </nav>
     </div>
     <section class="section ">
          <div class="row">
               <div class="col-lg-12">
                    <div class="card">
                         <div class="card-header text-bg-primary">
                              <i class="bi bi-book"></i> Hold Books
                         </div>
                         <div class="card-body">
                              <div class="row d-flex justify-content-center">
                                   <div class="col-12 col-md-4 mt-4">
                                        <form action="" method="GET">
                                             <div class="input-group mb-3 input-group-sm">

                                                  <!-- <span class="input-group-text bg-primary text-white"
                                                  id="basic-addon1">SEARCH ID</span> -->
                                                  <input type="text" name="student_id_no"
                                                       value="<?php if(isset($_GET['student_id_no'])){echo $_GET['student_id_no'];}?>"
                                                       class="form-control" placeholder="Enter Student ID or Faculty Name"
                                                       aria-label="Username" aria-describedby="basic-addon1" autofocus
                                                       required>
                                                  <button class="input-group-text bg-primary text-white"
                                                       id="basic-addon1">Search</button>
                                             </div>

                                             <!-- <div class="col-md-3 mt-3">
                                             <button type="submit" name="submit_borrower"
                                                  class="btn btn-primary">Submit</button>
                                        </div> -->
                                        </form>
                                   </div>

                                   <?php
                                  if(isset($_GET['student_id_no']))
                                  {
                                   $student_id_no = $_GET['student_id_no'];

                                   $query = "SELECT * FROM user WHERE student_id_no='$student_id_no' AND username='$student_id_no'";
                                   $query_run = mysqli_query($con, $query);

                                   if(mysqli_num_rows($query_run) > 0)
                                   {
                                        foreach($query_run as $row)
                                        {
                                             // echo $row['student_id_no'];
                                             $student_id = $_GET['student_id_no'];
                                                  echo ('<script> location.href="circulation_borrowing.php?student_id='.$student_id.'";</script');
                                             
                                        }
                                   }
                                   else
                                   {
                                        $_SESSION['message_error'] = 'No ID or Username Found';
                                        // echo ('<script> location.href="circulation_borrow.php";</script');
                                        
                                        
                                        
                                   }
                                  }



                                       
                                   ?>



                              </div>
                         </div>
                         <div class="card-footer">


                         </div>
                    </div>
                    <div class="card">
                         <div class="card-header text-dark fw-semibold ">
                              Recent Hold Books
                         </div>
                         <div class="card-body">
                              <div class="table-responsive mt-3">
                                   <table id="myDataTable" cellpadding="0" cellspacing="0" border="0"
                                        class="table table-striped table-bordered" id="example">

                                        <thead>
                                             <tr>
                                                  <th>Borrower Name</th>
                                                  <th>Hold Books</th>
                                                  <th>Action</th>
                                             </tr>
                                        </thead>
                                        <tbody>

                                             <?php
								$borrow_query = mysqli_query($con,"SELECT user.user_id, user.firstname, user.lastname,
                                        COUNT(holds.hold_id) AS num_hold_books 
                                        FROM user
                                        LEFT JOIN holds ON user.user_id = holds.user_id AND holds.hold_status = 'Hold'
                                        LEFT JOIN book ON holds.book_id = book.book_id
                                        WHERE holds.hold_status = 'Hold'
                                        GROUP BY user.user_id, user.firstname, user.lastname
                                        ORDER BY holds.hold_id DESC");
								$borrow_count = mysqli_num_rows($borrow_query);
                                             while($holdlist = mysqli_fetch_array($borrow_query)) {
                                                 // Fetch additional details if needed for each user
                                                 $hold_books_query = "SELECT * FROM holds 
                                                                      LEFT JOIN book ON holds.book_id = book.book_id
                                                                      WHERE holds.user_id = {$holdlist['user_id']} AND holds.hold_status = 'Hold'";
                                                 $hold_books_result = mysqli_query($con, $hold_books_query);
                                                 $user_id = $holdlist['user_id'];
							?>
                                             <?php
                                                       if(isset($user_id))
                                                       {
                                                       ?>
                                             <tr>

                                                  <td style="text-transform: capitalize">
                                                       <?php echo $holdlist['firstname']." ".$holdlist['lastname']; ?>
                                                  </td>
                                                  <td><?=$holdlist['num_hold_books'];?></td>
                                                  <td class=" justify-content-center">
                                                       <div class="btn-group" style="background: #DFF6FF;  ">
                                                            <!-- View Student Action-->
                                                            <a href="hold_view.php?id=<?=$holdlist['user_id']; ?>"
                                                                 name=""
                                                                 class="viewBookBtn btn btn-sm  border text-primary"
                                                                 data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                                 title="View Hold Books">
                                                                 <i class="bi bi-eye-fill"></i>
                                                            </a>
                                                            <!-- Delete Student Action-->
                                                            <form action="" method="POST">
                                                                 <button type="submit" name="cancel"
                                                                      value="<?=$holdlist['user_id'];?>"
                                                                      class="btn btn-sm  border text-danger"
                                                                      data-bs-toggle="tooltip"
                                                                      data-bs-placement="bottom" title="Delete Holder">
                                                                      <i class="bi bi-trash-fill"></i>
                                                                 </button>
                                                            </form>
                                                            <?php
                                                            if(isset($_POST['cancel']))
                                                            {
                                                                 $holdbook_id = mysqli_real_escape_string($con, $_POST['cancel']);
                                                            
                                                                 $query = "DELETE FROM holds WHERE hold_id ='$holdbook_id'";
                                                                 $query_run = mysqli_query($con, $query);
                                                            
                                                                 if($query_run)
                                                                 {
                                                                     $update_copies = mysqli_query($con,"SELECT * FROM book WHERE book_id = '$book_hold' ");
                                                                     $copies_row= mysqli_fetch_assoc($update_copies);
                                                                     
                                                                     $book_copies = $copies_row['copy'];
                                                                     $new_book_copies = $book_copies + 1;
                                                           
                                                                     mysqli_query($con,"UPDATE book SET copy = '$new_book_copies' where book_id = '$book_hold' ");
                                                           
                                                           
                                                           
                                                                     //  $_SESSION['message_success'] = 'Cancel book successfully';
                                                                     //  header("Location: hold.php");
                                                                     //  exit(0);
                                                           
                                                                      echo "<script>alert('Deleted successfully'); window.location='hold_list.php'</script>";
                                                                 }
                                                                 else
                                                                 {
                                                                      $_SESSION['message_error'] = 'There something Wrong';
                                                                      header("Location: hold_list.php");
                                                                      exit(0);
                                                                 }
                                                            }
                                                            ?>
                                                       </div>
                                                  </td>
                                             </tr>
                                             <?php } }
							if ($borrow_count <= 0){
								echo '
									<table style="float:right;">
										<tr>
											<td style="padding:10px;" class="alert alert-danger">No Hold Books at this Moment</td>
										</tr>
									</table>
								';
							} 							
							?>
                                        </tbody>
                                   </table>
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