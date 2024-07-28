<?php 
include('authentication.php');
include('includes/header.php'); 
include('./includes/sidebar.php');
?>

<style>
     #studbadge{
          position: relative;
          top: -15px;
          left: 20px;
     }
</style>

<main id="main" class="main">
     <div class="pagetitle d-flex justify-content-between">
          <div>
               <h1>Manage Students</h1>
               <nav>
                    <ol class="breadcrumb">
                         <li class="breadcrumb-item"><a href="users.php">Users</a></li>
                         <li class="breadcrumb-item active">Students</li>
                    </ol>
               </nav>
          </div>

     </div>
     <section class="section">
          <div class="row">
               <div class="col-lg-12">
                    <div class="card">
                         <div class="card-header d-flex justify-content-between align-items-center">
                              <a href="user_student_approval.php" class="btn btn-primary position-relative">
                                   <i class="bi bi-people-fill"></i>
                                   Student Approval
                                   <?php
                                   // Example query to count pending student approvals
                                   $sql = "SELECT COUNT(*) AS pending_student_count FROM user WHERE role_as = 'student' AND status = 'pending'";
                                   $result = mysqli_query($con, $sql);
                                   $row = mysqli_fetch_assoc($result);
                                   $pendingStudentCount = $row['pending_student_count'];

                                   if ($pendingStudentCount > 0) {
                                        echo '<span class="badge bg-danger" id="studbadge">' . $pendingStudentCount . '</span>';
                                   }
                                   ?>
                              </a>
                              <a href="users.php" class="btn btn-primary position-relative">Back</a>
                         </div>
                         <div class="card-body">
                              <div class="table-responsive mt-3">
                                   <table id="myDataTable" class="table table-bordered table-striped table-sm">
                                        <thead>
                                             <tr>
                                                  <th>Student No</th>
                                                  <th>Full Name</th>
                                                  <th>Gender</th>
                                                  <th>Course</th>
                                                  <th>Year Level</th>
                                                  <th>Action</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <?php
                                             $query = "SELECT * FROM user WHERE role_as = 'student' ORDER BY user_id ASC";
                                             $query_run = mysqli_query($con, $query);

                                             if(mysqli_num_rows($query_run)) {
                                                  foreach($query_run as $user) {
                                                       ?>
                                                       <tr>
                                                            <td><?=$user['student_id_no'];?></td>
                                                            <td><?=$user['firstname'].' '.$user['middlename'].' '.$user['lastname'];?></td>
                                                            <td><?=$user['gender'];?></td>
                                                            <td><?=$user['course'];?></td>
                                                            <td><?=$user['year_level'];?></td>
                                                            <td class="justify-content-center">
                                                                 <div class="btn-group" style="background: #DFF6FF;">
                                                                      <!-- View Student Action-->
                                                                      <a href="user_student_view.php?id=<?=$user['user_id'];?>" class="viewBookBtn btn btn-sm border text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View Student">
                                                                           <i class="bi bi-eye-fill"></i>
                                                                      </a>
                                                                      <!-- Block/Unblock Student Action-->
                                                                      <form action="user_student_code.php" method="POST">
                                                                           <?php if($user['status'] == 'approved'): ?>
                                                                                <button type="submit" name="block_student" value="<?=$user['user_id'];?>" class="btn btn-sm border text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Block Student">
                                                                                     <i class="bi bi-lock-fill"></i>
                                                                                </button>
                                                                           <?php else: ?>
                                                                                <button type="submit" name="unblock_student" value="<?=$user['user_id'];?>" class="btn btn-sm border text-success" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Unblock Student">
                                                                                     <i class="bi bi-unlock-fill"></i>
                                                                                </button>
                                                                           <?php endif; ?>
                                                                      </form>
                                                                      <!-- Delete Student Action-->
                                                                      <form action="user_student_code.php" method="POST">
                                                                           <button type="submit" name="delete_student" value="<?=$user['user_id'];?>" class="btn btn-sm border text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete Student">
                                                                                <i class="bi bi-trash-fill"></i>
                                                                           </button>
                                                                      </form>
                                                                 </div>
                                                            </td>
                                                       </tr>
                                                       <?php
                                                  }
                                             } else {
                                                  echo "No records found";
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
