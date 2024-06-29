<?php 
include('authentication.php');
include('includes/header.php'); 
include('includes/sidebar.php'); 

?>


<main id="main" class="main">
     <div class="pagetitle">
          <h1>Admin</h1>
          <nav>
               <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Admin</li>
               </ol>
          </nav>
     </div>
     <section class="section">
          <div class="row">
               <div class="col-lg-12">
                    <div class="card">
                         <div class="card-header d-flex justify-content-end">
                              <a href="admin_add.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Add
                                   Admin</a>
                         </div>
                         <div class="card-body">
                              <div class="table-responsive mt-3">
                                   <table id="myDataTable" class="table table-bordered table-striped table-sm">
                                        <thead>
                                             <tr>
                                                  <th>Image</th>
                                                  <th>Full Name</th>
                                                  <th>Phone Number</th>
                                                  <th>Email</th>
                                                  <th>Address</th>
                                                  <th>Action</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <?php
                                             $query = "SELECT * FROM admin";
                                             $query_run = mysqli_query($con, $query);
                                             
                                             if(mysqli_num_rows($query_run))
                                             {
                                                  foreach($query_run as $admin)
                                                  {
                                                       ?>
                                             <tr>
                                                  <td>
                                                       <center>
                                                            <?php if($admin['admin_image'] != ""): ?>
                                                            <img src="../uploads/admin_profile/<?php echo $admin['admin_image']; ?>"
                                                                 alt="" width="60px" height="60px"
                                                                 class="rounded-circle">
                                                            <?php else: ?>
                                                            <img src="../uploads/admin_profile/girl.png" alt=""
                                                                 class="rounded-circle" width="60px" height="60px">
                                                            <?php endif; ?>
                                                       </center>
                                                  </td>
                                                  <td>
                                                       <?=$admin['firstname'].' '.$admin['middlename'].' '.$admin['lastname'];?>
                                                  </td>
                                                  <td><?=$admin['phone_number'];?></td>
                                                  <td><?=$admin['email'];?></td>
                                                  <td><?=$admin['address'];?></td>
                                                  <td class=" justify-content-center">
                                                       <div class="btn-group" style="background: #DFF6FF;  ">
                                                            <!-- View Admin Action-->
                                                            <a href="admin_view.php?id=<?=$admin['admin_id']; ?>"
                                                                 name="view_admin"
                                                                 class="viewAdminBtn btn btn-sm  border text-primary"
                                                                 data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                                 title="View Admin">
                                                                 <i class="bi bi-eye-fill"></i>
                                                            </a>
                                                            <!-- Edit Admin Action-->
                                                            <a href="admin_edit.php?id=<?= $admin['admin_id']; ?>"
                                                                 name="update_admin"
                                                                 class="btn btn-sm  border text-success"
                                                                 data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                                 title="Edit Admin">
                                                                 <i class="bi bi-pencil-fill"></i>
                                                            </a>
                                                            <!-- Delete Admin Action-->
                                                            <form action="admin_code.php" method="POST">
                                                                 <button type="submit" name="delete_admin"
                                                                      value="<?=$admin['admin_id'];?>"
                                                                      class="btn btn-sm  border text-danger"
                                                                      data-bs-toggle="tooltip"
                                                                      data-bs-placement="bottom" title="Delete Admin">
                                                                      <i class="bi bi-trash-fill"></i>
                                                                 </button>
                                                            </form>
                                                       </div>
                                                  </td>
                                             </tr>

                                             <?php
                                                  }
                                             }
                                             else
                                             {
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
include('includes/footer.php');
include('includes/script.php');
include('message.php');   
?>