<?php
include('authentication.php');


if(isset($_POST['delete_admin']))
{
     $admin_id = mysqli_real_escape_string($con, $_POST['delete_admin']);

     $check_img_query = "SELECT * FROM admin WHERE admin_id ='$admin_id'";
     $img_result = mysqli_query($con, $check_img_query);
     $result_data = mysqli_fetch_array($img_result);

     $admin_image = $result_data['admin_image'];

     $query = "DELETE FROM admin WHERE admin_id ='$admin_id'";
     $query_run = mysqli_query($con, $query);

     if($query_run)
     {
          if(file_exists('../uploads/admin_profile/'.$admin_image))
          {
               unlink("../uploads/admin_profile/".$admin_image);
          }

          $_SESSION['message_success'] = 'Admin Deleted Successfully';
          header("Location: admin.php");
          exit(0);
     }
     else
     {
          $_SESSION['message_error'] = 'Admin Not Deleted';
          header("Location: admin.php");
          exit(0);
     }
}


// Update Admin
if(isset($_POST['edit_admin']))
{
     $admin_id =mysqli_real_escape_string($con, $_POST['admin_id']);

     $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
     $middlename = mysqli_real_escape_string($con, $_POST['middlename']);
     $lastname = mysqli_real_escape_string($con, $_POST['lastname']);
     $email = mysqli_real_escape_string($con, $_POST['email']);
     $address = mysqli_real_escape_string($con, $_POST['address']);
     $phone_number = mysqli_real_escape_string($con, $_POST['phone_number']);
    


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

     $query = "UPDATE `admin` SET firstname='$firstname', middlename='$middlename', lastname='$lastname', email='$email', address='$address', phone_number='$phone_number', admin_image='$update_admin_filename' WHERE admin_id = '$admin_id'";
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
          
          $_SESSION['message_success'] = 'Admin Updated successfully';
          header("Location: admin.php");
          exit(0);
     }
     else
     {
          $_SESSION['message_error'] = 'Admin not Updated';
          header("Location: admin.php");
          exit(0);
     }
}


// Add Admin
if(isset($_POST['add_admin']))
{
    $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
    $middlename = mysqli_real_escape_string($con, $_POST['middlename']);
    $lastname = mysqli_real_escape_string($con, $_POST['lastname']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $phone_number = mysqli_real_escape_string($con, $_POST['phone_number']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $admin_type = mysqli_real_escape_string($con, $_POST['admin_type']);
    $admin_image = $_FILES['admin_image']['name'];

    if($admin_image != "")
    {
        // Rename the Image
        $admin_extension = pathinfo($admin_image, PATHINFO_EXTENSION);
        $admin_filename = time().'.'.$admin_extension;

        $query = "INSERT INTO admin (firstname, middlename, lastname, email, address, phone_number, password, admin_image, admin_type, admin_added) 
                  VALUES ('$firstname', '$middlename', '$lastname', '$email', '$address', '$phone_number', '$hashed_password', '$admin_filename', '$admin_type', NOW())";
        $query_run = mysqli_query($con, $query);

        if($query_run)
        {
            move_uploaded_file($_FILES['admin_image']['tmp_name'], '../uploads/admin_profile/'.$admin_filename);
            $_SESSION['message_success'] = 'Admin Added successfully';
            header("Location: admin.php");
            exit(0);
        }
        else
        {
            $_SESSION['message_error'] = 'Admin not Added';
            header("Location: admin.php");
            exit(0);
        }
    }
    else
    {
        $query = "INSERT INTO admin (firstname, middlename, lastname, email, address, phone_number, password, admin_image, admin_type, admin_added) 
                  VALUES ('$firstname', '$middlename', '$lastname', '$email', '$address', '$phone_number', '$hashed_password', NULL, '$admin_type', NOW())";
        $query_run = mysqli_query($con, $query);

        if($query_run)
        {
            $_SESSION['message_success'] = 'Admin Added successfully';
            header("Location: admin.php");
            exit(0);
        }
        else
        {
            $_SESSION['message_error'] = 'Admin not Added';
            header("Location: admin.php");
            exit(0);
        }
    }
}
?>