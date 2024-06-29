<?php 
include('authentication.php');
include('includes/header.php'); 
include('./includes/sidebar.php'); 

?>

<style>
.data_table {
     background: #fff;
     padding: 15px;
     /* box-shadow: 1px 3px 5px #aaa; */
     border-radius: 5px;
}

.data_table .btn {
     padding: 5px 10px;
     margin: 10px 3px 10px 0;
}
</style>

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
                                   <li class="nav-item border border-info border-end-0 rounded-start">
                                        <a class="nav-link <?=$page == 'report.php' ? 'active': '' ?>"
                                             href="report.php">All Transaction</a>
                                   </li>
                                   <li class="nav-item">
                                        <a class="nav-link <?=$page == 'report_penalty.php' ? 'active': '' ?>"
                                             href="report_penalty.php">Penalty Report</a>
                                   </li>
                              </ul>
                         </div>
                         <div class="card-body">
                              <div class="row d-flex justify-content-between align-items-center mt-2">
                                   <h5 class="card-title col-12 col-md-3 px-3 text-center">
                                        Penalty Report
                                   </h5>
                                   <form action="" method="POST" class="col-12 col-md-6 d-flex ">

                                        <?php date_default_timezone_set('Asia/Manila'); ?>
                                        <div class="form-group form-group-sm">
                                             <label for=""> <small>From Date</small></label>
                                             <input type="date" name="from_date" id="disable_date"
                                                  class="form-control form-control-sm" required></input>
                                        </div>
                                        <div class="form-group form-group-sm mx-2">
                                             <label for=""> <small>To Date</small></label>
                                             <input type="date" name="to_date" id="disable_date2"
                                                  class="form-control form-control-sm" required></input>
                                        </div>
                                        <div class="form-group form-group-sm">
                                             <label for=""> <small>Click to Filter</small></label>
                                             <button type="submit" name="filter_attendance"
                                                  class="btn text-white fw-semibold btn-info btn-sm d-block">Filter</button>
                                        </div>


                                   </form>



                              </div>

                              <div class="container">
                                   <div class="row">
                                        <div class="col-12">

                                             <div class="data_table">

                                                  <?php
                                                   if(isset($_POST['from_date']) && isset($_POST['to_date']))
                                                   {
                                                        $from_date = $_POST['from_date'];
                                                        $to_date = $_POST['to_date'];

                                   $result= mysqli_query($con,"SELECT * FROM report 
                                   LEFT JOIN book ON report.book_id = book.book_id 
                                   LEFT JOIN user ON report.user_id = user.user_id 
                                   ORDER BY report.report_id DESC ") or die (mysqli_connect_error());
                                   while ($row= mysqli_fetch_array ($result) ){
                                   $admin =$row['admin_name'];
                                   }

							$return_query= mysqli_query($con,"SELECT * FROM return_book 
							LEFT JOIN book ON return_book.book_id = book.book_id 
							LEFT JOIN user ON return_book.user_id = user.user_id
                                   WHERE 
							 book_penalty > 0 AND date_returned BETWEEN '$from_date' AND '$to_date' AND return_book.return_book_id  ORDER BY return_book.return_book_id DESC") or die (mysqli_connect_error());
								$return_count = mysqli_num_rows($return_query);
								
							$count_penalty = mysqli_query($con,"SELECT sum(book_penalty) FROM return_book ")or die(mysqli_connect_error());
							$count_penalty_row = mysqli_fetch_array($count_penalty);
							
							?>
                                                  <table id="example" cellpadding="0" cellspacing="0" border="0"
                                                       class="table table-striped table-bordered">

                                                       <div class="pull-left">
                                                            <div class="span">
                                                                 <div class="alert alert-info mt-2 p-1"><i
                                                                           class="icon-credit-card icon-large"></i>&nbsp;Total
                                                                      Amount
                                                                      of
                                                                      Penalty:&nbsp;<?php echo "Php ".$count_penalty_row['sum(book_penalty)'].".00"; ?>
                                                                 </div>
                                                            </div>
                                                       </div>

                                                       <thead>
                                                            <tr>

                                                                 <th>Penalty Amount</th>
                                                                 <th>Received from</th>
                                                                 <th>Person In Charge</th>
                                                                 <th>Due Date</th>
                                                                 <th>Date Returned</th>

                                                            </tr>
                                                       </thead>
                                                       <tbody>
                                                            <?php
							while ($return_row= mysqli_fetch_array ($return_query) ){
							$id=$return_row['return_book_id'];
?>


                                                            <tr>
                                                                 <?php
								 if ($return_row['book_penalty'] != 'No Penalty'){
									 echo "<td class='alert alert-warning' style='width:100px;'>Php ".$return_row['book_penalty'].".00</td>";
								 }else {
									 echo "<td>".$return_row['book_penalty']."</td>";
								 }
								
								?>
                                                                 <td style="text-transform: capitalize">
                                                                      <?php echo $return_row['firstname']." ".$return_row['lastname']; ?>
                                                                 </td>
                                                                 <td><?php echo $admin; ?></td>
                                                                 <!---	<td style="text-transform: capitalize"><?php // echo $return_row['author']; ?></td>
								<td><?php // echo $return_row['isbn']; ?></td>	-->

                                                                 <?php
								 if ($return_row['book_penalty'] != 'No Penalty'){
									 echo "<td class='' >".date("M d, Y h:m:s a",strtotime($return_row['due_date']))."</td>";
								 }else {
									 echo "<td>".date("M d, Y h:m:s a",strtotime($return_row['due_date']))."</td>";
								 }
								
								?>
                                                                 <?php date_default_timezone_set('Asia/Manila'); ?>
                                                                 <?php
								 if ($return_row['book_penalty'] != 'No Penalty'){
									 echo "<td class='' >".date("M d, Y h:m:s a",strtotime($return_row['date_returned']))."</td>";
								 }else {
                                             
									 echo "<td>".date("M d, Y h:m:s a",strtotime($return_row['date_returned']))."</td>";
								 }
								
								?>
                                                            </tr>

                                                            <?php 
							}
                              }	
                              else{
                                   $result= mysqli_query($con,"SELECT * FROM report 
                                   LEFT JOIN book ON report.book_id = book.book_id 
                                   LEFT JOIN user ON report.user_id = user.user_id 
                                   
                                   ORDER BY report.report_id DESC ") or die (mysqli_connect_error());
                                   while ($row= mysqli_fetch_array ($result) ){
                                   $admin =$row['admin_name'];
                                   }

							$return_query= mysqli_query($con,"SELECT * FROM return_book 
							LEFT JOIN book ON return_book.book_id = book.book_id 
							LEFT JOIN user ON return_book.user_id = user.user_id
                                   WHERE 
						book_penalty > 0 AND return_book.return_book_id  ORDER BY return_book.return_book_id DESC") or die (mysqli_connect_error());
								$return_count = mysqli_num_rows($return_query);
								
							$count_penalty = mysqli_query($con,"SELECT sum(book_penalty) FROM return_book ")or die(mysqli_connect_error());
							$count_penalty_row = mysqli_fetch_array($count_penalty);
							
							?>
                                                            <table id="example" cellpadding="0" cellspacing="0"
                                                                 border="0" class="table table-striped table-bordered">

                                                                 <div class="pull-left">
                                                                      <div class="span">
                                                                           <div class="alert alert-info mt-2 p-1"><i
                                                                                     class="icon-credit-card icon-large"></i>&nbsp;Total
                                                                                Amount
                                                                                of
                                                                                Penalty:&nbsp;<?php echo "Php ".$count_penalty_row['sum(book_penalty)'].".00"; ?>
                                                                           </div>
                                                                      </div>
                                                                 </div>

                                                                 <thead>
                                                                      <tr>

                                                                           <th>Penalty Amount</th>
                                                                           <th>Received from</th>
                                                                           <th>Person In Charge</th>
                                                                           <th>Due Date</th>
                                                                           <th>Date Returned</th>

                                                                      </tr>
                                                                 </thead>
                                                                 <tbody>
                                                                      <?php
							while ($return_row= mysqli_fetch_array ($return_query) ){
							$id=$return_row['return_book_id'];
?>


                                                                      <tr>
                                                                           <?php
								 if ($return_row['book_penalty'] != 'No Penalty'){
									 echo "<td class='alert alert-warning' style='width:100px;'>Php ".$return_row['book_penalty'].".00</td>";
								 }else {
									 echo "<td>".$return_row['book_penalty']."</td>";
								 }
								
								?>
                                                                           <td style="text-transform: capitalize">
                                                                                <?php echo $return_row['firstname']." ".$return_row['lastname']; ?>
                                                                           </td>
                                                                           <td><?php echo $admin; ?></td>
                                                                           <!---	<td style="text-transform: capitalize"><?php // echo $return_row['author']; ?></td>
								<td><?php // echo $return_row['isbn']; ?></td>	-->

                                                                           <?php
								 if ($return_row['book_penalty'] != 'No Penalty'){
									 echo "<td class='' >".date("M d, Y h:m:s a",strtotime($return_row['due_date']))."</td>";
								 }else {
									 echo "<td>".date("M d, Y h:m:s a",strtotime($return_row['due_date']))."</td>";
								 }
								
								?>
                                                                           <?php
								 if ($return_row['book_penalty'] != 'No Penalty'){
									 echo "<td class='' >".date("M d, Y h:m:s a",strtotime($return_row['date_returned']))."</td>";
								 }else {
									 echo "<td>".date("M d, Y h:m:s a",strtotime($return_row['date_returned']))."</td>";
								 }
								
								?>
                                                                      </tr>
                                                                      <?php
                                   }
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
     </section>
</main>
<?php 
include('./includes/footer.php');
include('./includes/script.php');
include('../message.php');   
?>