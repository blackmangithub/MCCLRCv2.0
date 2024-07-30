<?php
session_start();

include('admin/config/dbcon.php');

if (isset($_POST['password_update'])) {
     $current_password = mysqli_real_escape_string($con, $_POST['current_password']);
     $newpassword = mysqli_real_escape_string($con, $_POST['newpassword']);
     $renewpassword = mysqli_real_escape_string($con, $_POST['renewpassword']);
 
     // Validate the current password for user or faculty
     $current_password_hashed = md5($current_password);
     
     $validate_user_query = "SELECT * FROM user WHERE password = '$current_password_hashed'";
     $validate_faculty_query = "SELECT * FROM faculty WHERE password = '$current_password_hashed'";
 
     $validate_user_query_run = mysqli_query($con, $validate_user_query);
     $validate_faculty_query_run = mysqli_query($con, $validate_faculty_query);
 
     if (!$validate_user_query_run || !$validate_faculty_query_run) {
         die('Query failed: ' . mysqli_error($con));
     }
 
     if (mysqli_num_rows($validate_user_query_run) > 0 || mysqli_num_rows($validate_faculty_query_run) > 0) {
         if ($newpassword == $renewpassword) {
             $newpassword_hashed = md5($newpassword);
             if (mysqli_num_rows($validate_user_query_run) > 0) {
                 // Update password for user
                 $change_pass_query = "UPDATE `user` SET password = '$newpassword_hashed' WHERE password = '$current_password_hashed'";
             } else {
                 // Update password for faculty
                 $change_pass_query = "UPDATE `faculty` SET password = '$newpassword_hashed' WHERE password = '$current_password_hashed'";
             }
             $change_pass_run = mysqli_query($con, $change_pass_query);
 
             if (!$change_pass_run) {
                 $_SESSION['status'] = "Password not updated: " . mysqli_error($con);
                 $_SESSION['status_code'] = "error";
                 header("Location: myprofile.php");
                 exit(0);
             }
 
             $_SESSION['status'] = "<small>Password updated successfully</small>";
             $_SESSION['status_code'] = "success";
             header("Location: myprofile.php");
             exit(0);
         } else {
             $_SESSION['status'] = '<small>Password and confirm password do not match</small>';
             $_SESSION['status_code'] = "warning";
             header("Location: myprofile.php");
             exit(0);
         }
     } else {
         $_SESSION['status'] = 'Current password does not match';
         $_SESSION['status_code'] = "warning";
         header("Location: myprofile.php");
         exit(0);
     }
 }
 

if (isset($_SESSION['auth_stud']['stud_id'])) {
    $id_session = $_SESSION['auth_stud']['stud_id'];
} elseif (isset($_SESSION['auth_faculty']['faculty_id'])) {
    $id_session = $_SESSION['auth_faculty']['faculty_id'];
}

if (isset($_POST['save_changes'])) {
    $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
    $middlename = mysqli_real_escape_string($con, $_POST['middlename']);
    $lastname = mysqli_real_escape_string($con, $_POST['lastname']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $email = mysqli_real_escape_string($con, $_POST['email']);

    // Update profile for user or faculty
    if (isset($_SESSION['auth_stud']['stud_id'])) {
        // Update user profile
        $query = "UPDATE `user` SET firstname='$firstname', middlename='$middlename', lastname='$lastname', address='$address', cell_no='$phone', email='$email' WHERE user_id ='$id_session'";
    } else {
        // Update faculty profile
        $query = "UPDATE `faculty` SET firstname='$firstname', middlename='$middlename', lastname='$lastname', address='$address', cell_no='$phone', email='$email' WHERE faculty_id ='$id_session'";
    }
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        $_SESSION['status'] = "Updated Successfully";
        $_SESSION['status_code'] = "success";
        header("Location: myprofile.php");
        exit(0);
    } else {
        $_SESSION['status'] = "Not Updated";
        $_SESSION['status_code'] = "error";
        header("Location: myprofile.php");
        exit(0);
    }
}

if (isset($_POST['logout_btn'])) {
    unset($_SESSION['auth']);
    unset($_SESSION['auth_role']);
    unset($_SESSION['auth_stud']);
    unset($_SESSION['auth_faculty']);

    $_SESSION['message_success'] = "Logout Successfully";
    header("Location: home.php");
    exit(0);
}
?>
