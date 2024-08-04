<?php 
include('authentication.php');
include('includes/header.php'); 
include('./includes/sidebar.php'); 

// Handle the delete request
if (isset($_POST['delete_user_btn'])) {
    $user_id = $_POST['user_id'];
    
    $query = "DELETE FROM ms_account WHERE ms_id=?";
    if ($stmt = $con->prepare($query)) {
        $stmt->bind_param('i', $user_id);
        if ($stmt->execute()) {
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted',
                    text: 'User has been deleted successfully.'
                }).then(function() {
                    window.location = 'ms_account.php';
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'There was an error deleting the user.'
                }).then(function() {
                    window.location = 'ms_account.php';
                });
            </script>";
        }
        $stmt->close();
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'There was an error preparing the statement.'
            }).then(function() {
                window.location = 'ms_account.php';
            });
        </script>";
    }
}
?>

<main id="main" class="main">
     <div class="pagetitle" data-aos="fade-down">
          <h1>MS 365 Account</h1>
          <nav>
               <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">MS 365 Account</li>
               </ol>
          </nav>
     </div>
     <section class="section dashboard">
          <div class="row">
               <div class="col-lg-12">
                    <div class="row">
                         <div data-aos="fade-down" class="col-12">
                              <div class="card recent-sales overflow-auto border-3 border-top border-info">
                                   <div class="card-body">
                                        <div class="row d-flex justify-content-end align-items-center mt-4">
                                             <div class="text-start">
                                                  <form action="import.php" method="post" enctype="multipart/form-data">
                                                       <input type="file" name="file" required>
                                                       <button type="submit" name="save_excel_data" class="btn btn-primary">
                                                             <b>Import</b>
                                                       </button>
                                                  </form>
                                             </div>
                                        </div>
                                        <br>
                                        <div class="container">
                                             <div class="row">
                                                  <div class="col-12">
                                                       <div class="data_table">
                                                            <table id="myDataTable" class="table table-striped table-bordered">
                                                                 <br>
                                                                 <thead>
                                                                      <tr>
                                                                           <th>Firstname</th>
                                                                           <th>Lastname</th>
                                                                           <th>Email</th>
                                                                           <th>Action</th>
                                                                      </tr>
                                                                 </thead>
                                                                 <tbody>
                                                                      <?php
                                                                      $query = "SELECT * FROM ms_account";
                                                                      if ($stmt = $con->prepare($query)) {
                                                                           $stmt->execute();
                                                                           $result = $stmt->get_result();
                                                                           while ($row = $result->fetch_assoc()) {
                                                                                echo "<tr>
                                                                                     <td>{$row['firstname']}</td>
                                                                                     <td>{$row['lastname']}</td>
                                                                                     <td>{$row['username']}</td>
                                                                                     <td>
                                                                                          <form action='' method='post' class='d-inline'>
                                                                                               <input type='hidden' name='user_id' value='{$row['ms_id']}'>
                                                                                               <button type='submit' name='delete_user_btn' class='btn btn-danger btn-sm'>Delete</button>
                                                                                          </form>
                                                                                     </td>
                                                                                </tr>";
                                                                           }
                                                                           $stmt->close();
                                                                      } else {
                                                                           echo "<tr><td colspan='4'>Error retrieving data</td></tr>";
                                                                      }
                                                                      ?>
                                                                 </tbody>
                                                            </table>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>
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

<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
