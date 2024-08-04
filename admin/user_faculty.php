<?php 
include('authentication.php');
include('includes/header.php'); 
include('./includes/sidebar.php'); 
?>

<style>
     #facultybadge {
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
                                                  <th>ID</th>
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
                                                       <td class="auto-id" style="text-align: center;"></td>
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
                                                                      <button type="button" class="btn btn-sm border text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Block Faculty Staff" onclick="confirmBlock('<?=$user['faculty_id'];?>', '<?=$user['status'];?>')">
                                                                           <i class="bi bi-lock-fill"></i>
                                                                      </button>
                                                                      <!-- Delete Faculty Action-->
                                                                      <button type="button" class="btn btn-sm border text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete Faculty Staff" onclick="confirmDelete('<?=$user['faculty_id'];?>')">
                                                                           <i class="bi bi-trash-fill"></i>
                                                                      </button>
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

<script>
function confirmBlock(facultyId, status) {
    let action = status === 'approved' ? 'block' : 'unblock';
    Swal.fire({
        title: 'Are you sure?',
        text: `You are about to ${action} this faculty/staff!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: `Yes`
    }).then((result) => {
        if (result.isConfirmed) {
            // Proceed with the block/unblock
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = 'user_faculty_code.php';

            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = status === 'approved' ? 'block_faculty' : 'unblock_faculty';
            input.value = facultyId;

            form.appendChild(input);

            document.body.appendChild(form);
            form.submit();
        }
    });
}

function confirmDelete(facultyId) {
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
            form.action = 'user_faculty_code.php';

            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'delete_faculty';
            input.value = facultyId;

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
