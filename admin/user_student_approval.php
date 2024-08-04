<?php 
include('authentication.php');
include('includes/header.php'); 
include('./includes/sidebar.php');
?>



<main id="main" class="main">
     <div class="pagetitle d-flex justify-content-between">
          <div>
               <h1>Manage Users</h1>
               <nav>
                    <ol class="breadcrumb">
                         <li class="breadcrumb-item"><a href="users.php">Users</a></li>
                         <li class="breadcrumb-item"><a href="user_student.php">Students</a></li>
                         <li class="breadcrumb-item active">Student Approval</li>
                    </ol>
               </nav>
          </div>

     </div>
     <section class="section">
          <div class="row">
               <div class="col-lg-12">
                    <div class="card">
                         <div class="card-header d-flex justify-content-between align-items-center">
                              <h5 class="m-0 text-dark fw-semibold">Students Approval</h5>

                              <a href="user_student.php" class="btn btn-primary">
                                   Back</a>
                         </div>
                         <div class="card-body">
                              <div class="table-responsive mt-3">
                                   <table id="myDataTable" class="table table-bordered table-striped table-sm">
                                        <thead>
                                             <tr>
                                             <th><center>ID</center></th>
                                                  <th><center>Student Profile</center></th>
                                                  <th><center>Full Name</center></th>
                                                  <th><center>Student No</center></th>
                                                  <th><center>Course</center></th>
                                                  <th><center>Action</center></th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <?php
                                             $query = "SELECT * FROM user WHERE status = 'pending' ORDER BY user_id ASC";
                                             $query_run = mysqli_query($con, $query);
                                             
                                             if(mysqli_num_rows($query_run))
                                             {
                                                  foreach($query_run as $user)
                                                  {
                                                       ?>
                                             <tr>
                                             <td class="auto-id" style="text-align: center;"></td>
                                                  <td>
                                                       <center>
                                                            <?php if($user['profile_image'] != ""): ?>
                                                            <img src="../uploads/profile_images/<?php echo $user['profile_image']; ?>"
                                                                 alt="image" width="120px" height="100px">
                                                            <?php else: ?>
                                                            <img src="uploads/books_img/book_image.jpg" alt=""
                                                                 width="120px" height="100px">
                                                            <?php endif; ?>
                                                       </center>
                                                  </td>

                                                  <td>
                                                       <center>
                                                       <?=$user['firstname'].' '.$user['middlename'].' '.$user['lastname']?>
                                                       </center>
                                                  </td>
                                                  <td>
                                                       <center>
                                                       <?=$user['student_id_no'];?>
                                                       </center>
                                                  </td>
                                                  <td>
                                                       <center>
                                                       <?=$user['course'];?>
                                                       </center>
                                                  </td>

                                                  <td class=" justify-content-center">
                                                       <center>
                                                       <form action="user_student_code.php" method="POST">
                                                            <input type="hidden" name="user_id"
                                                                 value="<?= $user['user_id']; ?>">
                                                            <input type="submit" name="approved" value="Approve"
                                                                 class="btn btn-success">
                                                            <input type="submit" name="deny" value="Deny"
                                                                 class="btn btn-danger">
                                                       </form>
                                                       </center>
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
document.addEventListener('DOMContentLoaded', function () {
     // Add auto-increment ID to Books Table
     let booksTable = document.querySelector('#myDataTable tbody');
     let bookRows = booksTable.querySelectorAll('tr');
     bookRows.forEach((row, index) => {
          row.querySelector('.auto-id').textContent = index + 1;
     });

     // Add auto-increment ID to Ebooks Table
     let ebooksTable = document.querySelector('#myDataTable2 tbody');
     let ebookRows = ebooksTable.querySelectorAll('tr');
     ebookRows.forEach((row, index) => {
          row.querySelector('.auto-id').textContent = index + 1;
     });
});
</script>