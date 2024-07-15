<?php //include('authentication.php'); ?>
<header id="header" class="header fixed-top d-flex align-items-center">
     <!-- Logo -->
     <div class="d-flex align-items-center">
          <a href="index.php" class="logo d-flex align-items-center">
               <img src="assets/img/mcc-logo.png" alt="logo" class=" mx-2" />
               <span class="d-none d-lg-block mx-2 ">MCC <span class="text-info d-block fs-6">Learning Resource
                         Center</span></span>
          </a>
          <i class="bi bi-list toggle-sidebar-btn"></i>
     </div>
     <?php 
if (isset($_SESSION['auth_admin']['admin_id']))
{
     $id_session=$_SESSION['auth_admin']['admin_id'];

 }
 ?>
     <!-- Search -->
     <!-- <div class="search-bar ">
          <form class="search-form d-flex align-items-center" method="POST" action="#">
               <input type="text" class="d-flex align-items-center align-middle" name="query" placeholder="Search"
                    title="Enter search keyword" />
               <button type="submit" title="Search">
                    <i class="bi bi-search"></i>
               </button>
          </form>
     </div> -->
     <nav class="header-nav ms-auto">
          <ul class="d-flex align-items-center">
               <!-- <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle" href="#">
                         <i class="bi bi-search"></i>
                    </a>
               </li> -->


               <li class="nav-item dropdown me-3">

                    <a class="nav-link nav-icon fs-4" href="#" data-bs-toggle="dropdown">

                         <i class="bi bi-bell"></i>
                         <?php
                                             $query = "SELECT COUNT(DISTINCT user_id) AS total_borrowers FROM holds WHERE hold_status = ''";
                                             $query_run = mysqli_query($con, $query);
                                             
                                             if ($query_run) {
                                                 $row = mysqli_fetch_assoc($query_run);
                                                 $total_borrowers = $row['total_borrowers'];
                                             
                                                 echo '<span class="badge bg-primary badge-number">'.$total_borrowers.'</span>';
                                             } else {
                                                 echo '<span class="badge bg-primary badge-number">0</span>';
                                             }
                                             ?>

                    </a>

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">

                         <li class="dropdown-header">
                              You have <?=$total_borrowers?> notifications
                         </li>
                         <?php 
                    $query_notif = "SELECT user.user_id, user.firstname, user.lastname, 
                    COUNT(holds.hold_id) AS num_hold_books
             FROM user
             LEFT JOIN holds ON user.user_id = holds.user_id AND holds.hold_status = ''
             LEFT JOIN book ON holds.book_id = book.book_id
             WHERE holds.hold_status = ''
             GROUP BY user.user_id, user.firstname, user.lastname
             ORDER BY holds.hold_id DESC";
$query_run = mysqli_query($con, $query_notif);
if(mysqli_num_rows($query_run) > 0 ) {
 while($holdlist = mysqli_fetch_assoc($query_run)) {
     // Fetch additional details if needed for each user
     $hold_books_query = "SELECT * FROM holds 
                          LEFT JOIN book ON holds.book_id = book.book_id
                          WHERE holds.user_id = {$holdlist['user_id']} AND holds.hold_status = ''";
     $hold_books_result = mysqli_query($con, $hold_books_query);
                    ?>
                         <li>
                              <hr class="dropdown-divider" />
                         </li>
                         <li class="notification-item">

                              <div>
                              <h4><?=$holdlist['firstname'].' '.$holdlist['lastname'];?></h4>
                <p>hold <span><?=$holdlist['num_hold_books'];?></span> books.</p>
                                   <form action="" method="POST">
                    <button type="submit" value="<?=$holdlist['user_id'];?>" class="btn btn-primary btn-sm" name="done">Accept</button>
                    <button type="submit" value="<?=$holdlist['user_id'];?>" class="btn btn-danger btn-sm" name="cancel">Delete</button>
                </form>
                              </div>

                         </li>

                         <li>
                              <hr class="dropdown-divider" />
                         </li>
                         <?php
                    }
                    }
                ?>

                         <li>
                              <a href="hold_list.php" style="text-decoration:underline;font-size:13px;margin-left:10px;">Show all notifications</a>
                         </li>

                    </ul>

               </li>


               <li class="nav-item dropdown pe-3">
                    <?php
               $query = "SELECT * FROM admin WHERE admin_id = '$id_session'";
               $query_run = mysqli_query($con, $query);
               $row = mysqli_fetch_array($query_run);
               ?>
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="javascript:;"
                         data-bs-toggle="dropdown">

                         <?php if($row['admin_image'] != ""): ?>
                         <img src="../uploads/admin_profile/<?php echo $row['admin_image']; ?>" alt="" width="30px"
                              height="30px" class="rounded-circle">
                         <?php else: ?>
                         <img src="assets/img/admin.png" alt="" class="rounded-circle" width="30px" height="30px">
                         <?php endif; ?>
                         <span
                              class="d-none d-md-block dropdown-toggle ps-2"><?= $_SESSION['auth_admin']['admin_name']; ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                         <li class="dropdown-header">
                              <h6><?= $_SESSION['auth_admin']['admin_name'];?></h6>
                         </li>
                         <li>
                              <hr class="dropdown-divider" />
                         </li>
                         <li>
                              <a class="dropdown-item d-flex align-items-center" href="admin_profile.php">
                                   <i class="bi bi-person"></i> <span>My Profile</span>
                              </a>
                         </li>
                         <li>
                              <hr class="dropdown-divider" />
                         </li>
                         <li>
                              <a class="dropdown-item d-flex align-items-center" href="account_settings.php">
                                   <i class="bi bi-gear"></i> <span>Account Settings</span>
                              </a>
                         </li>
                         <li>
                              <hr class="dropdown-divider" />
                         </li>
                         <li>
                              <a class="dropdown-item d-flex align-items-center" href="admin.php">
                                   <i class="bi bi-person-workspace"></i><span>Admin</span>
                              </a>
                         </li>
                         <li>
                              <hr class="dropdown-divider" />
                         </li>
                         <li>
                              <a class="dropdown-item d-flex align-items-center" href="circulation_settings.php">
                                   <i class="bi bi-journal-album"></i><span>Circulation Settings</span>
                              </a>
                         </li>
                         <li>
                              <hr class="dropdown-divider" />
                         </li>
                         <li>
                              <form action="allcode.php" method="POST">

                                   <button class="dropdown-item d-flex align-items-center" name="logout_btn"
                                        type="submit">
                                        <i class="bi bi-box-arrow-right"></i>
                                        <span>Log Out</span>
                                   </button>

                              </form>
                         </li>

                    </ul>
               </li>
          </ul>

     </nav>
</header>

<?php
 if(isset($_POST['cancel']))
 {
      $holdbook_id = mysqli_real_escape_string($con, $_POST['cancel']);
 
      $query = "DELETE FROM holds WHERE hold_id ='$holdbook_id'";
      $query_run = mysqli_query($con, $query);
 
      if($query_run)
      {
          $update_copies = mysqli_query($con,"SELECT * FROM book WHERE book_id = '$book_hold' ");
          $copies_row= mysqli_fetch_assoc($update_copies);
          
          $book_copies = $copies_row['copy'];
          $new_book_copies = $book_copies + 1;

          mysqli_query($con,"UPDATE book SET copy = '$new_book_copies' where book_id = '$book_hold' ");



          //  $_SESSION['message_success'] = 'Cancel book successfully';
          //  header("Location: hold.php");
          //  exit(0);

           echo "<script>alert('Cancel book successfully'); window.location='index.php'</script>";
      }
      else
      {
           $_SESSION['message_error'] = 'There something Wrong';
           header("Location: hold.php");
           exit(0);
      }
 }


 

 if(isset($_POST['done']))
{
     $holdbook_id = mysqli_real_escape_string($con, $_POST['done']);

               $query = "UPDATE `holds` SET hold_status='approved' WHERE hold_id ='$holdbook_id'";
               $query_run = mysqli_query($con, $query);

               if($query_run)
               {
                    $update_copies = mysqli_query($con,"SELECT * FROM book WHERE book_id = '$book_hold' ");
                    $copies_row= mysqli_fetch_assoc($update_copies);
                    
                    $book_copies = $copies_row['copy'];
                    $new_book_copies = $book_copies + 1;

                    mysqli_query($con,"UPDATE book SET copy = '$new_book_copies' where book_id = '$book_hold' ");

                    
                    echo "<script>alert('Book approved successfully'); window.location='index.php'</script>";
               }
               else
               {
                    $_SESSION['message_error'] = 'Hold Book not approved';
                    header("Location: index.php");
                    exit(0);
               }
     }
    
     ?>