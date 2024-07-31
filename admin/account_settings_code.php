<?php
include('authentication.php');

if(isset($_POST['change_password']))
{
     $current_password = mysqli_real_escape_string($con, $_POST['current_password']);
     $newpassword = mysqli_real_escape_string($con, $_POST['newpassword']);
     $renewpassword = mysqli_real_escape_string($con, $_POST['renewpassword']);
     
     // Fetch the current hashed password from the database
     $validate_query = "SELECT password FROM admin WHERE admin_id = '".$_SESSION['auth_admin']['admin_id']."'";
     $validate_query_run = mysqli_query($con, $validate_query);

     if(mysqli_num_rows($validate_query_run) > 0)
     {
          $row = mysqli_fetch_assoc($validate_query_run);
          $current_hashed_password = $row['password'];
          
          // Verify the current password
          if(password_verify($current_password, $current_hashed_password))
          {
               if($newpassword == $renewpassword)
               {
                    // Hash the new password
                    $new_hashed_password = password_hash($newpassword, PASSWORD_DEFAULT);
                    
                    $change_pass = "UPDATE `admin` SET password= '$new_hashed_password' WHERE admin_id = '".$_SESSION['auth_admin']['admin_id']."'";
                    $change_pass_run = mysqli_query($con, $change_pass);

                    if($change_pass_run)
                    {
                         $_SESSION['status'] = '<small>Password updated successfully</small>';
                         $_SESSION['status_code'] = "success";
                         header("Location: account_settings.php");
                         exit(0);
                    }
                    else
                    {
                         $_SESSION['status'] = 'Password not updated';
                         $_SESSION['status_code'] = "error";
                         header("Location: account_settings.php");
                         exit(0);
                    }
               }
               else
               {
                    $_SESSION['status'] = '<small>New password and confirm password do not match</small>';
                    $_SESSION['status_code'] = "warning";
                    header("Location: account_settings.php");
                    exit(0);
               }
          }
          else
          {
               $_SESSION['status'] = 'Current password is incorrect';
               $_SESSION['status_code'] = "error";
               header("Location: account_settings.php");
               exit(0);
          }
     }
     else
     {
          $_SESSION['status'] = 'Failed to fetch current password';
          $_SESSION['status_code'] = "error";
          header("Location: account_settings.php");
          exit(0);
     }
}


if (isset($_SESSION['auth_admin']['admin_id']))
{
     $id_session=$_SESSION['auth_admin']['admin_id'];

 }
                
          


if(isset($_POST['save_changes']))
{
     $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
     $middlename = mysqli_real_escape_string($con, $_POST['middlename']);
     $lastname = mysqli_real_escape_string($con, $_POST['lastname']);
     $address = mysqli_real_escape_string($con, $_POST['address']);
     $phone = mysqli_real_escape_string($con, $_POST['phone']);
     $email = mysqli_real_escape_string($con, $_POST['email']);


     $old_admin_filename = $_POST['old_admin_image'];

     $admin_image = $_FILES['admin_image']['name'];

     $update_admin_filename = "";

     if($admin_image != NULL)
     {
           // Rename the Image
           $admin_extension = pathinfo($admin_image, PATHINFO_EXTENSION);
           $admin_filename = time().'.'.$admin_extension;

           $update_admin_filename =  $admin_filename;
     }
     else
     {
          $update_admin_filename = $old_admin_filename;
     }

     $query = "UPDATE `admin` SET admin_image='$update_admin_filename', firstname='$firstname', middlename='$middlename', lastname='$lastname', address='$address', phone_number='$phone', email='$email' WHERE admin_id ='$id_session' ";
     $query_run = mysqli_query($con, $query);

     if($query_run)
     {
          if($admin_image != NULL)
          {
               if(file_exists('../uploads/admin_profile/'.$old_admin_filename))
               {
                    unlink("../uploads/admin_profile/".$old_admin_filename);
               }
          }
          move_uploaded_file($_FILES['admin_image']['tmp_name'], '../uploads/admin_profile/'.$admin_filename);

          $_SESSION['status'] = 'Updated Successfully';
          $_SESSION['status_code'] = "success";
          header("Location: account_settings.php");
          exit(0);
     }
     else
     {
          $_SESSION['status'] = 'Not Updated';
          $_SESSION['status_code'] = "error";
          header("Location: account_settings.php");
          exit(0);
     }
}
?>