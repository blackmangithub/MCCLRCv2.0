<?php 
include('authentication.php');
include('includes/header.php'); 
include('./includes/sidebar.php'); 

 error_reporting(0);

if (isset($_SESSION['auth_admin']['admin_id']))
{
     $id_session=$_SESSION['auth_admin']['admin_id'];

 }
 $employee_id = $_GET['employee_id'];

$faculty_query = mysqli_query($con,"SELECT * FROM faculty WHERE employee_id_no = '$employee_id' ");
$faculty_row = mysqli_fetch_array($faculty_query);
?>


<main id="main" class="main">
     <div class="pagetitle">
          <h1>Circulation</h1>
          <nav>
               <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="circulation.php">Circulation</a></li>
                    <li class="breadcrumb-item active">Borrow Book</li>
               </ol>
          </nav>
     </div>
     <section class="section ">
          <div class="row">
               <div class="col-lg-12">
                    <div class="card">
                         <div class="card-header d-flex justify-content-between">
                              <div class="col-12 col-md-6 mt-2">
                                   <form action="" method="POST">
                                        <div class="input-group mb-3 input-group-sm">
                                             <span class="input-group-text bg-primary text-white"
                                                  id="basic-addon1">BARCODE</span>
                                             <input type="text" name="barcode" class="form-control" placeholder=""
                                                  aria-label="Username" aria-describedby="basic-addon1" autofocus
                                                  required>
                                        </div>
                                   </form>
                              </div>
                         </div>
                         <div class="card-body">
                              <?php
                              $query = "SELECT * FROM faculty WHERE employee_id_no ='$employee_id'";
                              $query_run = mysqli_query($con, $query);

                              if($query_run)
                              {
                                   $row = mysqli_fetch_array($query_run);
                                   ?>
                              <div class="text-muted mt-3">Employee Name&nbsp;: &nbsp;<span
                                        class="h5 text-primary p-0 m-0 text-uppercase fw-semibold"><?php echo $row['firstname'].' '.$row['middlename'].' '.$row['lastname'];?></span>
                              </div>

                              <div class="text-muted mb-5">Department&emsp;&emsp;&nbsp;:&ensp;<span
                                        class="text-dark"><?=$row['department'];?></span></div>
                              <?php

                              }
                              else
                              {
                                   echo "No rows returned";
                              }
                              ?>

                              <div class="table-responsive">
                                   <table class="table">
                                        <form method="POST" action="">
                                             <thead class="border-top  border-dark border-opacity-25">
                                                  <tr>

                                                       <th>Image</th>
                                                       <th>Title</th>
                                                       <th>Author</th>
                                                       <th>Copyright Date</th>
                                                       <th>Publisher</th>
                                                       <th>Copy</th>
                                                       <th>Barcode</th>
                                                       <th>Action</th>


                                                       <?php 
								if (isset($_POST['barcode']))
                                        {
									$barcode = $_POST['barcode'];
									
									$book_query = mysqli_query($con,"SELECT * FROM book WHERE accession_number = '$barcode' ");
									$book_count = mysqli_num_rows($book_query);
									$book_row = mysqli_fetch_array($book_query);
									
									if ($book_row['accession_number'] != $barcode){
										echo '
											<table>
												<tr>
													<td class="alert alert-info">No match for the barcode entered!</td>
												</tr>
											</table>
										';
									} elseif ($barcode == '') {
										echo '
											<table>
												<tr>
													<td class="alert alert-info">Enter the correct details!</td>
												</tr>
											</table>
										';
									}else{
							?>
                                                  </tr>
                                             </thead>
                                             <tbody class="table-group-divider">
                                                  <tr>
                                                       <input type="hidden" name="faculty_id"
                                                            value="<?php echo $faculty_row['faculty_id'] ?>">
                                                       <input type="hidden" name="book_id"
                                                            value="<?php echo $book_row['book_id'] ?>">

                                                       <td>
                                                            <center>
                                                                 <?php if($book_row['book_image'] != ""): ?>
                                                                 <img src="../uploads/books_img/<?php echo $book_row['book_image']; ?>"
                                                                      alt="" width="80px" height="80px">
                                                                 <?php else: ?>
                                                                 <img src="../uploads/books_img/book_image.jpg" alt=""
                                                                      width="80px" height="80px">
                                                                 <?php endif; ?>
                                                            </center>
                                                       </td>
                                                       <td><?php echo $book_row['title'] ?></td>
                                                       <td><?php echo $book_row['author'] ?></td>
                                                       <td><?php echo $book_row['copyright_date'] ?></td>
                                                       <td><?php echo $book_row['publisher'] ?></td>
                                                       <td><?php echo $book_row['copy'] ?></td>
                                                       <td><?php echo $book_row['barcode']?></td>
                                                       <td><button name="borrow" class="btn btn-primary"><i
                                                                      class="fa fa-check"></i> Borrow</button></td>
                                                  </tr>
                                             </tbody>
                                             <?php } }?>


                                             <?php
							
							$allowable_days_query= mysqli_query($con,"SELECT * FROM allowed_days WHERE allowed_days_id = 2 ");
							$allowable_days_row = mysqli_fetch_assoc($allowable_days_query);
							
							$timezone = "Asia/Manila";
							if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
							$cur_date = date("Y-m-d H:i:s");
							$date_borrowed = date("Y-m-d H:i:s");
							$due_date = strtotime($cur_date);
							$due_date = strtotime("+".$allowable_days_row['no_of_days']." day", $due_date);
							$due_date = date('Y-m-d H:i:s', $due_date);
							
							?>
                                             <input type="hidden" name="due_date" class="new_text" id="sd"
                                                  value="<?php echo $due_date; ?>" size="16" maxlength="10" />
                                             <input type="hidden" name="date_borrowed" class="new_text" id="sd"
                                                  value="<?php echo $date_borrowed ?>" size="16" maxlength="10" />

                                             <?php 
								if (isset($_POST['borrow'])){
									$faculty_id =$_POST['faculty_id'];
									$book_id =$_POST['book_id'];
									$date_borrowed =$_POST['date_borrowed'];
									$due_date =$_POST['due_date'];
									
									$trapBookCount= mysqli_query($con,"SELECT count(*) as books_allowed from borrow_book where faculty_id = '$faculty_id' and borrowed_status = 'borrowed'");
									
									$countBorrowed = mysqli_fetch_assoc($trapBookCount);
									
									$bookCountQuery= mysqli_query($con,"SELECT count(*) as book_count from borrow_book where faculty_id = '$faculty_id' and borrowed_status = 'borrowed' and book_id = $book_id");
									
									$bookCount = mysqli_fetch_assoc($bookCountQuery);
									
									$allowed_book_query= mysqli_query($con,"SELECT * FROM allowed_book WHERE allowed_book_id = 2 ");
									$allowed = mysqli_fetch_assoc($allowed_book_query);
									
									if ($countBorrowed['books_allowed'] == $allowed['qntty_books']){
										echo "<script>alert(' ".$allowed['qntty_books']." ".'Books Allowed per User!'." '); window.location='circulation_faculty_borrowing.php?employee_id=".$employee_id."'</script>";
									}elseif ($bookCount['book_count'] == 1){
										echo "<script>alert('Book Already Borrowed!'); window.location='circulation_faculty_borrowing.php?employee_id=".$employee_id."'</script>";
									}else{
										
									$update_copies = mysqli_query($con,"SELECT * FROM book WHERE book_id = '$book_id' ");
									$copies_row= mysqli_fetch_assoc($update_copies);
									
									$book_copies = $copies_row['copy'];
									$new_book_copies = $book_copies - 1;
									
									if ($new_book_copies < 0){
										echo "<script>alert('Book out of Copy!'); window.location='circulation_faculty_borrowing.php?employee_id=".$employee_id."'</script>";
									}
                                             else
                                             {
										
									
									
									mysqli_query($con,"UPDATE book SET copy = '$new_book_copies' where book_id = '$book_id' ");
									
									
									mysqli_query($con,"INSERT INTO borrow_book(faculty_id,book_id,date_borrowed,due_date,borrowed_status)
									VALUES('$faculty_id','$book_id','$date_borrowed','$due_date','borrowed')");
									
									$report_history=mysqli_query($con,"select * from admin where admin_id = $id_session ");
									$report_history_row=mysqli_fetch_array($report_history);
									$admin_row=$report_history_row['firstname']." ".$report_history_row['middlename']." ".$report_history_row['lastname'];	
									
									mysqli_query($con,"INSERT INTO report 
									(book_id, faculty_id, admin_name, detail_action, date_transaction)
									VALUES ('$book_id','$faculty_id','$admin_row','Borrowed Book',NOW())");
									
                                             // $_SESSION['message_success'] = 'Book Borrowed Successfully';
                                             // echo "<script>location='circulation_borrowing.php?faculty_id=".$faculty_id."'</script>";

                                             echo "<script>alert('Book Borroowed Successfully'); window.location='circulation_faculty_borrowing.php?employee_id=".$employee_id."'</script>";
									}
									}
							?>
                                             <script>
                                             window.location =
                                                  "circulation_faculty_borrowing.php?employee_id=<?php echo $employee_id ?>";
                                             </script>
                                             <?php	
								}
							?>
                                        </form>
                                   </table>
                              </div>
                         </div>
                         <div class="card-footer">


                         </div>
                    </div>
               </div>
          </div>
     </section>
</main>

<?php 
include('./includes/footer.php');
include('./includes/script.php');
include('message.php');   
?>