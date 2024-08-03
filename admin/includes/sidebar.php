<style>
     .badge {
          position: relative;
          top: -10px;
          right: -140px;
     }
</style>
<aside id="sidebar" class="sidebar" id="v-pills-tab" role="tablist">
     <?php  $page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/")+ 1); ?>
     <ul class="sidebar-nav" id="sidebar-nav">
          <li class="nav-item">
               <a class="nav-link collapsed<?=$page == 'index.php' ? 'active': '' ?>" href="index.php">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
               </a>
          </li>

          <li class="nav-item">
               <a class="nav-link collapsed<?=$page == 'books.php' || $page == 'book_add.php' || $page == 'book_view.php' || $page == 'book_edit.php'  ? 'active': '' ?>"
                    href="books.php">
                    <i class="bi bi-book"></i><span>Book Collection</span>
               </a>
          </li>

          <li class="nav-item">
               <a class="nav-link collapsed<?=$page == 'users.php' || $page == 'user_student.php' || $page == 'user_student_add.php' || $page == 'user_student_view.php' || $page == 'user_student_edit.php' || $page == 'user_faculty.php' || $page == 'user_student_approval.php'  ? 'active': '' ?>"
                    href="users.php">
                    <i class="bi bi-people"></i><span>Users</span>
                    <?php
                         $user_sql = "SELECT COUNT(*) AS pending_count FROM user WHERE status = 'pending'";
                         $faculty_sql = "SELECT COUNT(*) AS pending_count FROM faculty WHERE status = 'pending'";

                         $user_result = mysqli_query($con, $user_sql);
                         $faculty_result = mysqli_query($con, $faculty_sql);

                         $user_row = mysqli_fetch_assoc($user_result);
                         $faculty_row = mysqli_fetch_assoc($faculty_result);

                         $pendingCount = $user_row['pending_count'] + $faculty_row['pending_count'];

                         if ($pendingCount > 0) {
                              echo '<span class="badge bg-danger">' . $pendingCount . '</span>';
                         }
                    ?>
               </a>
          </li>

          <li class="nav-item">
               <a class="nav-link collapsed<?=$page == 'attendance.php' ? 'active': '' ?>"
                    href="attendance.php">
                    <i class="bi bi-card-checklist"></i><span>Attendance</span>
               </a>
          </li>
          
          <li class="nav-item">
               <a class="nav-link collapsed<?=$page == 'circulation.php' || $page == 'circulation_borrow.php' || $page == 'circulation_borrowing.php' || $page == 'circulation_return.php' || $page == 'circulation_returning.php' || $page == 'acknowledgement_receipt.php' ? 'active': '' ?>"
                    href="circulation.php">
                    <i class="bi bi-journal-album"></i><span>Circulation</span>
               </a>
          </li>

          <li class="nav-item">
               <a class="nav-link collapsed<?=$page == 'ms_account.php' ? 'active': '' ?>"
                    href="ms_account.php">
                    <i class="bi bi-cloud"></i><span>MS 365 Account</span>
               </a>
          </li>

          <li class="nav-item">
               <a class="nav-link collapsed<?=$page == 'report.php' || $page == 'report_penalty.php' || $page == 'report_faculty.php' ? 'active': '' ?>"
                    href="report.php">
                    <i class="bi bi-file-earmark"></i><span>Report</span>
               </a>
          </li>
     </ul>
</aside>
