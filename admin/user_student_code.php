<?php 
include('authentication.php');

// Student Deny
if(isset($_POST['deny']))
{
     $student_id = $_POST['user_id'];

     $query= "DELETE FROM user WHERE user_id = '$student_id'";
     $query_run = mysqli_query($con, $query);

     if($query_run)
     {
          
          $_SESSION['message_success'] = 'Student Denied ';
          header("Location: user_student_approval.php");
          exit(0);
     }
     else
     {
          $_SESSION['message_error'] = 'Student not Denied';
          header("Location: user_student_approval.php");
          exit(0);
     }
}


// Student Approval
if(isset($_POST['approved']))
{
     $student_id = $_POST['user_id'];

     $query= "UPDATE user SET status = 'approved' WHERE user_id = '$student_id'";
     $query_run = mysqli_query($con, $query);

     if($query_run)
     {
          
          $_SESSION['message_success'] = 'Student approved successfully';
          header("Location: user_student_approval.php");
          exit(0);
     }
     else
     {
          $_SESSION['message_error'] = 'Student not approved';
          header("Location: user_student_approval.php");
          exit(0);
     }
}

// Block student
if(isset($_POST['block_student'])) {
     $user_id = $_POST['block_student'];
     $query = "UPDATE user SET status='blocked' WHERE user_id='$user_id'";
     $query_run = mysqli_query($con, $query);

     if($query_run) {
          $_SESSION['message'] = "Student has been blocked successfully.";
          header("Location: user_student.php");
          exit(0);
     } else {
          $_SESSION['message'] = "Something went wrong.";
          header("Location: user_student.php");
          exit(0);
     }
}

// Unblock student
if(isset($_POST['unblock_student'])) {
     $user_id = $_POST['unblock_student'];
     $query = "UPDATE user SET status='approved' WHERE user_id='$user_id'";
     $query_run = mysqli_query($con, $query);

     if($query_run) {
          $_SESSION['message'] = "Student has been unblocked successfully.";
          header("Location: user_student.php");
          exit(0);
     } else {
          $_SESSION['message'] = "Something went wrong.";
          header("Location: user_student.php");
          exit(0);
     }
}

// Delete Action
if(isset($_POST['delete_student']))
{
     $user_id = mysqli_real_escape_string($con, $_POST['delete_student']);
     $query = "DELETE FROM user WHERE user_id ='$user_id'";
     $query_run = mysqli_query($con, $query);

     if($query_run)
     {
          $_SESSION['message_success'] = 'Student deleted successfully';
          header("Location: user_student.php");
          exit(0);
     }
     else
     {
          $_SESSION['message_error'] = 'Student not deleted';
          header("Location: user_student.php");
          exit(0);
     }
}
?>