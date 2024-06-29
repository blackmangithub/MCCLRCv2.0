<?php 
include('authentication.php');
include('includes/header.php'); 
include('./includes/sidebar.php'); 

?>
<main id="main" class="main">
     <?php  $page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/")+ 1); ?>
     <div class="pagetitle">
          <h1>Report</h1>
          <nav>
               <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Report</li>
               </ol>
          </nav>
     </div>
     <section class="section">
          <div class="row">
               <div class="col-lg-12">
                    <div class="card">
                         <div class="card-header">
                              <ul class="nav nav-pills">
                                   <li class="nav-item">
                                        <a class="nav-link <?=$page == 'report.php' || $page == 'report_faculty.php' ? 'active': '' ?>"
                                             href="report.php">All Transaction</a>
                                   </li>
                                   <li class="nav-item  border border-info border-start-0 rounded-end">
                                        <a class="nav-link <?=$page == 'report_penalty.php' ? 'active': '' ?>"
                                             href="report_penalty.php">Penalty Report</a>
                                   </li>
                              </ul>
                         </div>
                         <div class="card-body">
                              <!-- <h4 class="m-3">All Transaction</h4> -->
                              <div class="table-responsive mt-3">
                                   <ul class="nav nav-tabs mb-3">
                                        <li class="nav-item">
                                             <a class="nav-link <?=$page == 'report.php' ? 'active': '' ?> text-dark"
                                                  href="report.php">Students </a>
                                        </li>
                                        <li class="nav-item">
                                             <a class="nav-link <?=$page == 'report_faculty.php' ? 'active': '' ?> text-dark"
                                                  href="report_faculty.php">Faculty Staff</a>
                                        </li>
                                   </ul>
                                   <table id="myDataTable" cellpadding="0" cellspacing="0" border="0"
                                        class="table table-striped table-bordered">

                                        <thead>
                                             <tr>
                                                  <th>Name</th>
                                                  <th>Book Title</th>
                                                  <th>Task</th>
                                                  <th>Person In Charge</th>
                                                  <th>Date Transaction</th>
                                             </tr>
                                        </thead>
                                        <tbody>


                                             <?php
							$result= mysqli_query($con,"SELECT * from report 
							LEFT JOIN book ON report.book_id = book.book_id 
							LEFT JOIN faculty ON report.faculty_id = faculty.faculty_id
							order by report.report_id DESC ");
							while ($row= mysqli_fetch_array ($result) ){
							$id=$row['report_id'];
							$book_id=$row['book_id'];
							$faculty_name=$row['firstname']." ".$row['lastname'];
							$faculty_name=$row['firstname']." ".$row['lastname'];
                                   $admin =$row['admin_name'];
							
							?>
                                             <?php if(isset($row['faculty_id'])) :?>
                                             <tr>

                                                  <td><?php echo $faculty_name; ?></td>
                                                  <td><?php echo $row['title']; ?></td>
                                                  <td><?php echo $row['detail_action']; ?></td>
                                                  <td><?php echo $row['admin_name']; ?></td>
                                                  <td><?php echo date("M d, Y h:m:s a",strtotime($row['date_transaction'])); ?>
                                                  </td>
                                             </tr>
                                             <?php endif; ?>
                                             <?php } ?>
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