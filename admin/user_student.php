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
                                             <th><center>ID</center></th>
                                                  <th><center>Student No</center></th>
                                                  <th><center>Full Name</center></th>
                                                  <th><center>Gender</center></th>
                                                  <th><center>Course</center></th>
                                                  <th><center>Year Level</center></th>
                                                  <th><center>Action</center></th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <?php
                                             $query = "SELECT * FROM user WHERE status IN ('approved', 'blocked') AND role_as = 'student' ORDER BY user_id ASC";
                                             $query_run = mysqli_query($con, $query);

                                             if(mysqli_num_rows($query_run)) {
                                                  foreach($query_run as $user) {
                                                       ?>
                                                       <tr>
                                                       <td class="auto-id" style="text-align: center;"></td>
                                                            <td><center><?=$user['student_id_no'];?></center></td>
                                                            <td><center><?=$user['firstname'].' '.$user['middlename'].' '.$user['lastname'];?></center></td>
                                                            <td><center><?=$user['gender'];?></center></td>
                                                            <td><center><?=$user['course'];?></center></td>
                                                            <td><center><?=$user['year_level'];?></center></td>
                                                            <td class="justify-content-center">
                                                                 <center>
                                                                 <div class="btn-group" style="background: #DFF6FF;">
                                                                      <!-- View Student Action-->
                                                                      <a href="user_student_view.php?id=<?=$user['user_id'];?>" class="viewBookBtn btn btn-sm border text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View Student">
                                                                           <i class="bi bi-eye-fill"></i>
                                                                      </a>
                                                                      <!-- Block/Unblock Student Action-->
                                                                      <?php if($user['status'] == 'approved'): ?>
                                                                           <button type="button" class="btn btn-sm border text-warning" onclick="confirmBlock('<?=$user['user_id'];?>')">
                                                                                <i class="bi bi-lock-fill"></i>
                                                                           </button>
                                                                      <?php else: ?>
                                                                           <button type="button" class="btn btn-sm border text-success" onclick="confirmUnblock('<?=$user['user_id'];?>')">
                                                                                <i class="bi bi-unlock-fill"></i>
                                                                           </button>
                                                                      <?php endif; ?>
                                                                      <!-- Delete Student Action-->
                                                                      <button type="button" class="btn btn-sm border text-danger" onclick="confirmDelete('<?=$user['user_id'];?>')">
                                                                           <i class="bi bi-trash-fill"></i>
                                                                      </button>
                                                                      <!-- Generate ID Card Action-->
                                                                      <button type="button" class="btn btn-sm border text-info" onclick="generateIdCard('<?=$user['user_id'];?>')">
                                                                           <i class="bi bi-card-heading"></i>
                                                                      </button>
                                                                 </div>
                                                                 </center>
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

<script>
function confirmBlock(userId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You are about to block this student!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            // Proceed with the blocking
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = 'user_student_code.php';

            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'block_student';
            input.value = userId;

            form.appendChild(input);

            document.body.appendChild(form);
            form.submit();
        }
    });
}

function confirmUnblock(userId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You are about to unblock this student!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            // Proceed with the unblocking
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = 'user_student_code.php';

            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'unblock_student';
            input.value = userId;

            form.appendChild(input);

            document.body.appendChild(form);
            form.submit();
        }
    });
}

function confirmDelete(userId) {
    Swal.fire({
        title: 'Are you sure to delete this?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            // Proceed with the deletion
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = 'user_student_code.php';

            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'delete_student';
            input.value = userId;

            form.appendChild(input);

            document.body.appendChild(form);
            form.submit();
        }
    });
}

function generateIdCard(userId) {
    Swal.fire({
        title: 'Generate Library ID Card',
        text: "Are you sure you want to generate a library ID card for this student?",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            // Proceed with the ID card generation
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = 'user_student_generate_id_card.php';

            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'generate_id_card';
            input.value = userId;

            form.appendChild(input);

            document.body.appendChild(form);
            form.submit();
        }
    });
}

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
