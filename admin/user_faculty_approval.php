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
                         <li class="breadcrumb-item"><a href="user_faculty.php">Faculty</a></li>
                         <li class="breadcrumb-item active">Faculty/Staff Approval</li>
                    </ol>
               </nav>
          </div>

     </div>
     <section class="section">
          <div class="row">
               <div class="col-lg-12">
                    <div class="card">
                         <div class="card-header d-flex justify-content-between align-items-center">
                              <h5 class="m-0 text-dark fw-semibold">Faculty/Staff Approval</h5>

                              <a href="user_faculty.php" class="btn btn-primary">
                                   Back</a>
                         </div>
                         <div class="card-body">
                              <div class="table-responsive mt-3">
                                   <table id="myDataTable" class="table table-bordered table-striped table-sm">
                                        <thead>
                                             <tr>
                                                  <th>QR Code</th>
                                                  <th>Full Name</th>
                                                  <th>Department</th>
                                                  <th>Action</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <?php
                                             $query = "SELECT * FROM faculty WHERE (role_as = 'faculty' OR role_as = 'staff') AND status = 'pending' ORDER BY faculty_id ASC";
                                             $query_run = mysqli_query($con, $query);
                                             
                                             if(mysqli_num_rows($query_run))
                                             {
                                                  foreach($query_run as $user)
                                                  {
                                                       ?>
                                             <tr>

                                                  <td>
                                                       <center>
                                                            <?php if($user['qr_code'] != ""): ?>
                                                            <img src="../qrcodes/<?php echo $user['qr_code']; ?>"
                                                                 alt="" width="100px" height="100px">
                                                            <?php else: ?>
                                                            <img src="uploads/books_img/book_image.jpg" alt=""
                                                                 width="200px" height="250px">
                                                            <?php endif; ?>
                                                       </center>
                                                  </td>

                                                  <td>
                                                       <?=$user['firstname'].' '.$user['middlename'].' '.$user['lastname']?>
                                                  </td>
                                                  <td><?=$user['course'];?></td>




                                                  <td class=" justify-content-center">
                                                       <form action="user_faculty_code.php" method="POST">
                                                            <input type="hidden" name="faculty_id"
                                                                 value="<?= $user['faculty_id']; ?>">
                                                            <input type="submit" name="approved" value="Approve"
                                                                 class="btn btn-success">
                                                            <input type="submit" name="deny" value="Deny"
                                                                 class="btn btn-danger">
                                                       </form>
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