<?php 
include('authentication.php');
include('includes/header.php'); 
include('./includes/sidebar.php'); 

?>

<style>
     #facultybadge{
          position: relative;
          top: -15px;
          left: 20px;
     }
</style>

<main id="main" class="main">
     <div class="pagetitle">
          <h1>Manage Faculty Staff</h1>
          <nav>
               <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="users.php">Users</a></li>
                    <li class="breadcrumb-item active">Faculty Staff</li>
               </ol>
          </nav>
     </div>
     <section class="section">
          <div class="row">
               <div class="col-lg-12">
                    <div class="card">
                         <div class="card-header d-flex justify-content-between align-items-center">
                              <a href="user_faculty_approval.php" class="btn btn-primary position-relative">
                                   <i class="bi bi-people-fill"></i>
                                   Faculty Approval
                                   <?php
                                   // Example query to count pending faculty approvals
                                   $sql = "SELECT COUNT(*) AS pending_student_count FROM faculty WHERE (role_as = 'faculty' OR role_as = 'staff') AND status = 'pending'";
                                   $result = mysqli_query($con, $sql);
                                   $row = mysqli_fetch_assoc($result);
                                   $pendingStudentCount = $row['pending_student_count'];

                                   if ($pendingStudentCount > 0) {
                                        echo '<span class="badge bg-danger" id="facultybadge">' . $pendingStudentCount . '</span>';
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
                                                  <th>Username</th>
                                                  <th>Full Name</th>
                                                  <th>Gender</th>
                                                  <th>Department</th>
                                                  <th>Action</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <?php
                                             $query = "SELECT * FROM faculty WHERE status IN ('approved', 'blocked') AND (role_as = 'faculty' OR role_as = 'staff') ORDER BY faculty_id ASC";
                                             $query_run = mysqli_query($con, $query);

                                             if(mysqli_num_rows($query_run)) {
                                                  foreach($query_run as $user) {
                                                       ?>
                                                       <tr>
                                                            <td><?=$user['username'];?></td>
                                                            <td><?=$user['firstname'].' '.$user['middlename'].' '.$user['lastname'];?></td>
                                                            <td><?=$user['gender'];?></td>
                                                            <td><?=$user['course'];?></td>
                                                            <td class="justify-content-center">
                                                                 <div class="btn-group" style="background: #DFF6FF;">
                                                                      <!-- View Faculty Action-->
                                                                      <a href="user_faculty_view.php?id=<?=$user['faculty_id'];?>" class="viewBookBtn btn btn-sm border text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View Faculty Staff">
                                                                           <i class="bi bi-eye-fill"></i>
                                                                      </a>
                                                                      <!-- Block/Unblock Faculty Action-->
                                                                      <form action="user_faculty_code.php" method="POST">
                                                                           <?php if($user['status'] == 'approved'): ?>
                                                                                <button type="submit" name="block_faculty" value="<?=$user['faculty_id'];?>" class="btn btn-sm border text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Block Faculty Staff">
                                                                                     <i class="bi bi-lock-fill"></i>
                                                                                </button>
                                                                           <?php else: ?>
                                                                                <button type="submit" name="unblock_faculty" value="<?=$user['faculty_id'];?>" class="btn btn-sm border text-success" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Unblock Faculty Staff">
                                                                                     <i class="bi bi-unlock-fill"></i>
                                                                                </button>
                                                                           <?php endif; ?>
                                                                      </form>
                                                                      <!-- Delete Faculty Action-->
                                                                      <form action="user_faculty_code.php" method="POST">
                                                                           <button type="submit" name="delete_faculty" value="<?=$user['faculty_id'];?>" class="btn btn-sm border text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete Faculty Staff">
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
include('../message.php');   
?>
