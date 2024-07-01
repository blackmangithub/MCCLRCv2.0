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
    <a class="nav-link collapsed<?=$page == 'users.php' || 
        $page == 'user_student.php' || 
        $page == 'user_student_add.php' || 
        $page == 'user_student_view.php' || 
        $page == 'user_student_edit.php' || 
        $page == 'user_faculty.php' || 
        $page == 'user_student_approval.php' ? 'active': '' ?>"
        href="users.php">
        <i class="bi bi-people"></i><span>Users</span>
        <?php
            $sql = "SELECT COUNT(*) AS pending_count FROM user WHERE status = 'pending'";
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_assoc($result);
            $pendingCount = $row['pending_count'];

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
               <a class="nav-link collapsed<?=$page == 'report.php' || $page == 'report_penalty.php' || $page == 'report_faculty.php' ? 'active': '' ?>"
                    href="report.php">
                    <i class="bi bi-file-earmark"></i><span>Report</span>
               </a>
          </li>

          <!-- <li class="nav-item">
               <a class="nav-link collapsed<?=$page == 'web_opac.php' || $page == 'web_opac_add.php' || $page == 'web_opac_view.php' || $page == 'web_opac_edit.php' ? 'active': '' ?>"
                    href="web_opac.php">
                    <i class="bi bi-book"></i><span>Web OPAC</span>
               </a>
          </li> -->
     </ul>
</aside>