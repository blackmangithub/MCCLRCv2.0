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
                              <a href="user_student.php" class="btn btn-primary">Back</a>
                         </div>
                         <div class="card-body">
                              <div class="table-responsive mt-3">
                                   <table id="myDataTable" class="table table-bordered table-striped table-sm">
                                        <thead>
                                             <tr>
                                                  <th>Student QRCode</th>
                                                  <th>Full Name</th>
                                                  <th>Student No</th>
                                                  <th>Course</th>
                                                  <th>Action</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <?php
                                             $query = "SELECT * FROM user WHERE status = 'pending' ORDER BY user_id ASC";
                                             $query_run = mysqli_query($con, $query);
                                             
                                             if(mysqli_num_rows($query_run)) {
                                                  foreach($query_run as $user) {
                                                       ?>
                                                       <tr>
                                                            <td>
                                                                 <center>
                                                                      <?php if($user['qr_code'] != ""): ?>
                                                                      <img src="../qrcodes/<?php echo $user['qr_code']; ?>" alt="" width="150px" height="150px">
                                                                      <?php else: ?>
                                                                      <img src="uploads/books_img/book_image.jpg" alt="" width="200px" height="250px">
                                                                      <?php endif; ?>
                                                                 </center>
                                                            </td>
                                                            <td><?=$user['firstname'].' '.$user['middlename'].' '.$user['lastname']?></td>
                                                            <td><?=$user['student_id_no'];?></td>
                                                            <td><?=$user['course'];?></td>
                                                            <td class=" justify-content-center">
                                                                 <button type="button" class="btn btn-success" onclick="confirmApprove('<?=$user['user_id'];?>')">Approve</button>
                                                                 <button type="button" class="btn btn-danger" onclick="confirmDeny('<?=$user['user_id'];?>')">Deny</button>
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
function confirmApprove(userId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You are about to approve this student!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            // Proceed with the approval
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = 'user_student_code.php';

            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'approved';
            input.value = userId;

            form.appendChild(input);

            document.body.appendChild(form);
            form.submit();
        }
    });
}

function confirmDeny(userId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You are about to deny this student!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            // Proceed with the denial
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = 'user_student_code.php';

            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'deny';
            input.value = userId;

            form.appendChild(input);

            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
