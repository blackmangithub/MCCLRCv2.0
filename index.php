<?php 
include('includes/header.php');
include('includes/navbar.php');
include('admin/config/dbcon.php');

if(empty($_SESSION['auth'])){
//   $_SESSION['message_error'] = "<small>Login your Credentials to Access</small>";
  header('Location: home.php');
  exit(0);
}
if ($_SESSION['auth_role'] != "student" && $_SESSION['auth_role'] != "faculty" && $_SESSION['auth_role'] != "staff") 
{
  header("Location:index.php");
  exit(0);
}
?>

