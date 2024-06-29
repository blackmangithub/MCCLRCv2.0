<?php 

include('includes/header.php');
include('includes/navbar.php');
include('admin/config/dbcon.php');

if(empty($_SESSION['auth'])){
//   $_SESSION['message_error'] = "<small>Login your Credentials to Access</small>";
  header('Location: home.php');
  exit(0);
}
if($_SESSION['auth_role'] != "student" && $_SESSION['auth_role'] != "faculty")
{
  header("Location:index.php");
  exit(0);
}
?>



<div class="container ">
     <div class="row ">
          <div class="col-12">
               <div class="card  mt-4 " data-aos="fade-up" style="height: 70vh">
                    <?php 
                    $query_notif = "SELECT * FROM holds LEFT JOIN book ON holds.book_id = book.book_id
                   LEFT JOIN user ON holds.user_id = user.user_id WHERE hold_status = ''
                   ORDER BY hold_id DESC";
                      $query_run = mysqli_query($con, $query_notif);
                      if(mysqli_num_rows($query_run) > 0 )
                      {
                                foreach($query_run as $holdlist)
                                {
                                   $hold_book = $holdlist['hold_id'];
                                   $book_hold = $holdlist['book_id'];
                                   $book_title = $holdlist['title'];
                    ?>

                    <?php 
                    



                     $name_hold = $_SESSION['auth_stud']['stud_id'];
                          $query = "SELECT * FROM holds WHERE hold_status = 'approved' AND user_id = '$name_hold'";
                          $query_run = mysqli_query($con, $query);

                         
                    
                         

                         if($query_run)
                         {   
                              ?>

                    <div class="alert alert-info text-center" role="alert">
                         <?php  echo  "This book <b>".$book_title."</b> now Available"; 
                                             
                         ?>

                    </div>
                    <?php
                    }
                    else
                    {
                    $_SESSION['message_error'] = 'Hold Book not approved';
                    header("Location: notification.php");
                    exit(0);
                    }


                    }
                    }

                    ?>


                    <?php
                         $name_hold = $_SESSION['auth_stud']['stud_id'];

                         $borrow_query = mysqli_query($con,"SELECT * FROM borrow_book
                         LEFT JOIN book ON borrow_book.book_id = book.book_id
                         WHERE user_id = '$name_hold' && borrowed_status = 'borrowed' ORDER BY borrow_book_id DESC");
                        
                         if(mysqli_num_rows($borrow_query) > 0 )
                         {

                         
                         while($borrow_row = mysqli_fetch_array($borrow_query))
                         {
                        

                         $timezone = "Asia/Manila";
                         if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
                         $cur_date = date("Y-m-d H:i:s");
                         $due_date= $borrow_row['due_date'];
                        
                         $curr_date = date('Y-m-d H:i:s', strtotime($cur_date ));
                         $duee_date = date('Y-m-d H:i:s', strtotime($due_date. ' -1 day'));
                         
                        


                         if ($duee_date < $curr_date) 
                         {
                              
                              
                         ?>
                    <div class="alert alert-info text-center" role="alert">
                         <?php  echo  'Please return this Book <b>'.$borrow_row['title'].'</b> before '.date("M d, Y",strtotime($borrow_row['due_date'])); 
                                             
                         ?>
                    </div>
                    <?php  
                   
                         } 
                         // else 
                         // {
                              
                         //      echo '<div class="alert alert-info text-center" role="alert">
                         //                No Notifications
                         //           </div>';
                                  
                         // }   
                        

                         // if ($duee_date >= $curr_date) 
                         // {
                         //     echo $due_date;
                         //      echo ' Your Book Due date is in '.date("M d, Y",strtotime($borrow_row['due_date'])).' Please return the Book ';
                            
                         // } elseif ($duee_date < $curr_date) {
                              
                         //      echo $due_date.'<br>';
                         //      echo 'Due Date: '.$duee_date.'<br>Current Date: '.$curr_date.'<br>';
                         //      echo date("M d, Y",strtotime($borrow_row['due_date'])).' Your Borrowed Book is already have a Penalty. Please return it now';
                              
                         // } else {
                              
                         //     echo '<div class="alert alert-info text-center" role="alert">
                         //                No Notifications
                         //           </div>';
                         //     echo $curr_date;
                         // }
                    }
               }
               else
               {
                    ?>
                    <!-- <div class="alert alert-info text-center" role="alert">
                         No Notifications
                    </div> -->
                    <?php
               }

                     ?>

                    <!-- 
                    <?php


                         $stop_date = '2009-09-30 20:24:00';
                         echo 'date before day adding: ' . $stop_date; 
                         $stop_date = date('Y-m-d H:i:s', strtotime($stop_date . ' +1 day'));
                         echo '<br>date after adding 1 day: ' . $stop_date;
                    ?> -->
               </div>

          </div>

          <div id="searchresult" class="text-center"></div>

     </div>
</div>
</div>
</div>
</div>

</div>

<?php
include('includes/footer.php');
include('includes/script.php');
include('message.php'); 
?>
<!-- <script>
$(document).ready(function() {
     $("#live_search").keyup(function() {
          var input = $(this).val();
          // alert(input);
          if (input != "") {
               $.ajax({
                    url: "home_code.php",
                    method: "POST",
                    data: {
                         input: input
                    },

                    success: function(data) {
                         $("#searchresult").html(data);
                    }
               });
          } else {
               $("#searchresult").css("display", "none");
          }
     });
});
</script> -->