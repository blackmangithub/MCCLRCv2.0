<?php 
ini_set('display_error', '1');
include('includes/header.php');
include('includes/navbar.php');
include('admin/config/dbcon.php');

if (empty($_SESSION['auth'])) {
  header('Location: home.php');
  exit(0);
}

if ($_SESSION['auth_role'] != "student" && $_SESSION['auth_role'] != "faculty" && $_SESSION['auth_role'] != "staff") 
{
  header("Location:index.php");
  exit(0);
}
?>

<div class="container">
  <div class="row">
    <div class="col-12">
      <div class="card mt-4" data-aos="fade-up">
        <div class="card-header">
          <div class="d-flex align-items-center justify-content-center mt-2">
            <div class="mx-2">
            <img src="assets/img/mcc-logo.png" class="d-sm-none d-md-block me-4" style="height: 100px; width: 100px;" alt="MCC Logo">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>