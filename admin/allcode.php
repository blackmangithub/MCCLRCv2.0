<?php
session_start();


include('admin/config/dbcon.php');

if(isset($_POST['change_password']))
{
     $current_password = mysqli_real_escape_string($con, $_POST['current_password']);
     $newpassword = mysqli_real_escape_string($con, $_POST['newpassword']);
     $renewpassword = mysqli_real_escape_string($con, $_POST['renewpassword']);

     $validate_query = "SELECT * FROM user WHERE password = md5('$current_password')";
     $validate_query_run = mysqli_query($con, $validate_query);

     if(mysqli_num_rows($validate_query_run) > 0)
     {
          if($newpassword == $renewpassword)
          {
               $change_pass = "UPDATE `user` SET password= md5('$newpassword'),  confirm_password=md5('$renewpassword')";
               $change_pass_run = mysqli_query($con, $change_pass);

               if($change_pass_run)
               {
                    $_SESSION['message_success'] = '<small>Password updated successfully</small>';
                    header("Location: myprofile.php");
                    exit(0);
               }
               else
               {
                    $_SESSION['message_error'] = 'Password not updated';
                    header("Location: myprofile.php");
                    exit(0);
               }
          }
          else
          {
               $_SESSION['message_error'] = '<small>Password and confirm password not match</small>';
               header("Location: myprofile.php");
               exit(0);
          }
     }
     else
     {
          $_SESSION['message_error'] = 'Current password not match';
          header("Location: myprofile.php");
          exit(0);
     }
}


if (isset($_SESSION['auth_stud']['stud_id']))
{
     $id_session=$_SESSION['auth_stud']['stud_id'];

 }
                
          


if(isset($_POST['save_changes']))
{
     $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
     $middlename = mysqli_real_escape_string($con, $_POST['middlename']);
     $lastname = mysqli_real_escape_string($con, $_POST['lastname']);
     $address = mysqli_real_escape_string($con, $_POST['address']);
     $phone = mysqli_real_escape_string($con, $_POST['phone']);
     $email = mysqli_real_escape_string($con, $_POST['email']);


    //  $old_admin_filename = $_POST['old_admin_image'];

    //  $admin_image = $_FILES['admin_image']['name'];

    //  $update_admin_filename = "";

    //  if($admin_image != NULL)
    //  {
           // Rename the Image
    //        $admin_extension = pathinfo($admin_image, PATHINFO_EXTENSION);
    //        $admin_filename = time().'.'.$admin_extension;

    //        $update_admin_filename =  $admin_filename;
    //  }
    //  else
    //  {
    //       $update_admin_filename = $old_admin_filename;
    //  }

     $query = "UPDATE `user` SET  firstname='$firstname', middlename='$middlename', lastname='$lastname', address='$address', cell_no='$phone', email='$email' WHERE user_id ='$id_session' ";
     $query_run = mysqli_query($con, $query);

     if($query_run)
     {
          // if($admin_image != NULL)
          // {
          //      if(file_exists('../uploads/admin_profile/'.$old_admin_filename))
          //      {
          //           unlink("../uploads/admin_profile/".$old_admin_filename);
          //      }
          // }
          // move_uploaded_file($_FILES['admin_image']['tmp_name'], '../uploads/admin_profile/'.$admin_filename);

          $_SESSION['message_success'] = 'Updated Successfully';
          header("Location: myprofile.php");
          exit(0);
     }
     else
     {
          $_SESSION['message_error'] = 'Not Updated';
          header("Location: myprofile.php");
          exit(0);
     }
}



















// Logout
if(isset($_POST['logout_btn']))
{
// session_destroy();
unset($_SESSION['auth']);
unset($_SESSION['auth_role']);
unset($_SESSION['auth_stud']);


$_SESSION['message_success'] ="Logout Successfully";
header("Location: admin_login.php");
exit(0);
}


?>