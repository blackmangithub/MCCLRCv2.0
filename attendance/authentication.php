<?php
session_start();
include('config/dbcon.php');

if(!isset($_SESSION['auth']))
{
  $_SESSION['message_error'] ="Scan your QR Code to enter.";
  header("Location:attendance_list.php");
  exit(0);
}
else  
{
  if($_SESSION['auth_role'] != "1")
  {
    $_SESSION['message_error'] = "<small>You are not authorized as ADMIN</small>";
    header("Location:attendance_list.php");
    exit(0);
  }
  
}



?>