<?php 
include('authentication.php');


if(isset($_POST['deny']))
{
     $faculty_id = $_POST['faculty_id'];

     $query= "DELETE FROM faculty WHERE faculty_id = '$faculty_id'";
     $query_run = mysqli_query($con, $query);

     if($query_run)
     {
          
          $_SESSION['message_success'] = 'Faculty Denied ';
          header("Location: user_faculty_approval.php");
          exit(0);
     }
     else
     {
          $_SESSION['message_error'] = 'Faculty not Denied';
          header("Location: user_faculty_approval.php");
          exit(0);
     }
}


// Student Approval
if(isset($_POST['approved']))
{
     $faculty_id = $_POST['faculty_id'];

     $query= "UPDATE faculty SET status = 'approved' WHERE faculty_id = '$faculty_id'";
     $query_run = mysqli_query($con, $query);

     if($query_run)
     {
          
          $_SESSION['message_success'] = 'Faculty approved successfully';
          header("Location: user_faculty_approval.php");
          exit(0);
     }
     else
     {
          $_SESSION['message_error'] = 'Faculty not approved';
          header("Location: user_faculty_approval.php");
          exit(0);
     }
}

// Delete Action
if(isset($_POST['delete_faculty']))
{
     $faculty_id = mysqli_real_escape_string($con, $_POST['delete_faculty']);
     $query = "DELETE FROM faculty WHERE faculty_id ='$faculty_id'";
     $query_run = mysqli_query($con, $query);

     if($query_run)
     {
          $_SESSION['message_success'] = 'Faculty deleted successfully';
          header("Location: user_faculty.php");
          exit(0);
     }
     else
     {
          $_SESSION['message_error'] = 'Faculty not deleted';
          header("Location: user_faculty.php");
          exit(0);
     }
}
?>